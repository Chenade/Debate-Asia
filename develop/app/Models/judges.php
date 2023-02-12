<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\articles;
use App\Models\competition;

class judges extends Model
{
    use HasFactory;

    protected $table = 'judge';
    
    public $timestamps = true;

    protected $guarded = [];

    public static function store($request)
    {
        $user = DB::table('judge')-> where('mid', $request['mid']) -> first();
        if ($user)
            return (NULL);
        $content = new JUDGES;
        $content->mid = $request['mid'];
        $content->cid = $request['cid'];
        $content->save();
        return $content->id;
    }

    public static function getListbyCID($cid, $mid)
    {
        return DB::table('session')
                -> where('cid', $cid)
                -> where('role', '<>', 3)
                -> orderBy ('roomid')
                -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('judge') 
                -> where('id', $id) 
                -> get();
    }

    public static function deleteById($id)
    {
        $row = DB::table('judge') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        $input = [];
        $input['del'] = 1;
        DB::table('judge')-> where('id', $id)-> update($input);

        return true;
    }

    public static function updateById($id, $input)
    {
        $content = judges::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('comment', $input)) $content->comment = $input['comment'];
        if (array_key_exists('score_1', $input)) $content->score_1 = $input['score_1'];
        if (array_key_exists('score_2', $input)) $content->score_2 = $input['score_2'];
        if (array_key_exists('score_3', $input)) $content->score_3 = $input['score_3'];
        if (array_key_exists('score_4', $input)) $content->score_4 = $input['score_4'];
        if (array_key_exists('score_5', $input)) $content->score_5 = $input['score_5'];
        $content->score = $content->score_1 + $content->score_2 + $content->score_3 + $content->score_4 + $content->score_5;
        $content->save();
        $status = DB::table('session')
                        -> where('id', $content->jid) 
                        -> update(['status' => 2]);
        return true;
    }
    
    public static function init($cid, $sid)
    {
        $lst = DB::table('session')
                -> where('cid', $cid)
                -> where('role', 3)
                -> get();
        foreach ($lst as $key => $value) {
            $content = DB::table('judge')
                        -> where('sid', $sid) 
                        -> where('jid', $value->id) 
                        -> first();
            if (!$content)
            {
                $content = new judges;
                $content->sid = $sid;
                $content->jid = $value->id;
                $content->save();
            }
            $content = DB::table('session')
                        -> where('id', $value->id) 
                        -> update(['status' => 1]);
        }
        
        return true;
    }

    public static function getJudgeStatus($sid)
    {
        $row = DB::table('judge')
                -> where ('judge.sid', $sid)
                -> leftJoin ('session', 'judge.sid', '=', 'session.id')
                -> leftJoin ('competition', 'session.cid', '=', 'competition.id')
                -> select (
                            'judge.id','judge.comment', 'judge.score_1', 'judge.score_2', 'judge.score_3', 'judge.score_4', 'judge.score', 
                            'session.cid', 'session.role',
                            'competition.title', 'competition.tag', 'competition.date', 'competition.t_read', 'competition.t_debate', 'competition.t_write',
                            )
                -> get();
        if (count($row) < 1)
        {
            $cid = DB::table('session') -> where('id', $sid) -> first();
            if (!$cid)
                return NULL;
            JUDGES::init($cid->cid, $sid);

            $row = DB::table('judge')
                -> where ('judge.sid', $sid)
                -> leftJoin ('session', 'judge.sid', '=', 'session.id')
                -> leftJoin ('competition', 'session.cid', '=', 'competition.id')
                -> select (
                            'judge.id','judge.comment', 'judge.score_1', 'judge.score_2', 'judge.score_3', 'judge.score_4', 'judge.score', 
                            'session.cid', 'session.role',
                            'competition.title', 'competition.tag', 'competition.date', 'competition.t_read', 'competition.t_debate', 'competition.t_write',
                            )
                -> get();
        }
       return ($row);
    }

    public static function getJudgeRoom($cid, $rid)
    {
        $row = DB::table('session')
                -> where ('session.cid', $cid)
                -> where ('session.roomid', $rid)
                -> select ('id')
                -> get();
        $return = array();
        foreach ($row as $key => $value) {
            $tmp = JUDGES::getJudgeStatus($value->id);
            if (!$tmp)
                return (NULL);
            $tmp = $tmp[0];
            $article = ARTICLES::getArticlebySID($value->id);
            $arr_article[$article[0]->type] = $article[0]->content;
            $arr_article[$article[1]->type] = $article[1]->content;
            $tmp->article = $arr_article;
            array_push($return, $tmp);
        }
       return ($return);
    }

    public static function getJudgeList($mid)
    {
        $row = DB::table('session')
                    -> where ('mid', $mid)
                    -> get();
        $return = array();
        $return['competition'] = array();
        foreach ($row as $k => $v) {
            $return['competition'][$v->cid]['status'] = $v->status;
            $return['competition'][$v->cid]['info'] = COMPETITION::getElementById($v->cid)[0];
        }
        $return['usr'] = DB::table('users') -> where('id', $mid) -> first();
       return ($return);
    }

    
    public static function getJudgeRoomList($cid, $mid)
    {
        $return = array();
        $arr = JUDGES::getListbyCID($cid, $mid);
        $tmp = array();
        foreach ($arr as $key => $value) {
            if (!array_key_exists($value->roomid, $tmp))
                $tmp[$value->roomid] = array();
            array_push($tmp[$value->roomid], $value);
        }
        $return['rooms'] = $tmp;
       return ($return);
    }
}
