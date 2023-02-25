<?php

namespace App\Models;
use App\Models\users;
use App\Models\competition;
use App\Models\articles;
use App\Models\judges;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class sessions extends Model
{
    use HasFactory;

    protected $table = 'session';
    
    public $timestamps = true;

    protected $guarded = [];

    // protected $casts = [
    //     'content' => 'array'
    // ];

    public static function store($request)
    {
        $user = DB::table('session')
            -> where('mid', $request['mid']) 
            -> where('cid', $request['cid']) 
            -> first();
        if ($user)
            return (NULL);
        $content = new sessions;
        $content->mid = $request['mid'];
        $content->cid = $request['cid'];
        if (array_key_exists('role', $request))  $content->role = $request['role'];
        $content->save();
        return $content->id;
    }
    
    public static function deleteById($input)
    {
        $row = DB::table('session') 
                -> where('cid', $input['cid']) 
                -> where('mid', $input['mid']) 
                -> first();
        if (!$row)
            return NULL;
        DB::table('session')->delete($row->id);
        return true;
    }

    public static function updateById($id, $input)
    {
        $content = sessions::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if ($content->role < 3 && array_key_exists('status', $input)){
            $content->status = $input['status'];
            if ($input['status'] == 1)
                ARTICLES::initArticle($id);
            else if ($input['status'] == 4)
                JUDGES::init($content->cid, $id);
        }
        if (array_key_exists('roomid', $input) || array_key_exists('role', $input))
        {
            $content->judge_note = NULL;
            $tmp = DB::table('session')
                        -> where ('roomid', $input['roomid'])
                        -> where ('role', $input['role'])
                        -> where ('id', '!=', $id)
                        -> update (['judge_note' => NULL]);
            if (array_key_exists('roomid', $input)) $content->roomid = $input['roomid'];
            if (array_key_exists('role', $input)) $content->role = $input['role'];
        }
        else
        {
            if (array_key_exists('judge_note', $input)) $content->judge_note = $input['judge_note'];
        }
        $content->save();
        return true;
    }

    public static function uploadImage($sid, $input)
    {
        $content = sessions::find($sid);
        if (!$content)
            return ("error");
        if ($content->camera && (is_writable($_SERVER['DOCUMENT_ROOT']."/camera//" . $content->camera)))
            unlink($_SERVER['DOCUMENT_ROOT']."/camera//" . $content->camera);
        $content->camera = Uuid::uuid4() . '.jpeg';
        $content->timestamps = false;
        $content->camera_ts = time();
        $content->save();

        $mime = substr($input['dataURI'], 5, strpos($input['dataURI'], ';') - 5);
        $extension = explode('/', $mime)[1];
        $filename = $content->camera;
        $file_path = public_path() .'/camera//' . $filename;
        $data = base64_decode(str_replace('data:'.$mime.';base64,', '', $input['dataURI']));
        file_put_contents($file_path, $data);

        $row = DB::table('session')
                -> where('cid', $content->cid)
                -> where('roomid', $content->roomid)
                -> where('mid', '<>', $content->mid)
                -> first();
        if (!$row)
            return (NULL);
        return $row;
    }
    
    public static function saveImage()
    {
        $row = DB::table('session')
                -> where('camera', '<>', NULL)
                -> get();
        foreach ($row as $v)
        {
            $base64 = $v->camera;

            $mime = substr($base64, 5, strpos($base64, ';') - 5);
            $extension = explode('/', $mime)[1];
            $filename = Uuid::uuid4() . '.' . $extension;
            $file_path = public_path() .'/camera//' . $filename;

            
            $data = base64_decode(str_replace('data:'.$mime.';base64,', '', $base64));
            file_put_contents($file_path, $data);
            DB::table('session')
                    -> where('id', $v->id)
                    -> update(['camera' => $filename]);
        }
        if (!$row)
            return (NULL);
        return $row;
    }

    public static function getElementById($id)
    {
        $row = DB::table('session')
                -> where('id', $id)
                -> select ('id', 'status', 'updated_at', 'mid', 'camera')
                -> first();
        $row->user = USERS::getElementBySId($row->mid);
        return $row;
    }

    public static function getListbyCID($roles, $cid)
    {
        if ($roles == 1)
            return DB::table('session')
                    -> where('role', '<=', '2')
                    -> where('cid', $cid) 
                    -> leftJoin('users', 'session.mid', '=', 'users.id')
                    -> select('session.*', 'users.name_cn', 'users.school_cn')
                    -> orderBy('roomid', 'ASC') 
                    -> orderBy('role', 'ASC') 
                    -> get();
        else
            return DB::table('session')
                    -> where('cid', $cid) 
                    -> where('role', '>', '2')
                    -> orderBy('roomid', 'ASC') 
                    -> get();
    }
    
    public static function getListByUser($mid)
    {
        return DB::table('session')
                -> where ('mid', $mid)
                -> leftJoin('competition', 'session.cid', '=', 'competition.id')
                -> get();
    }

    public static function getSessionStatus($rid, $cid)
    {
        $row = DB::table('session')
                -> where('roomid', $rid)
                -> where('cid', $cid)
                -> leftJoin('users', 'session.mid', '=', 'users.id')
                -> select ('session.*', 'users.name_cn', 'users.name_zh', 'users.school_cn', 'users.school_zh')
                -> get();
        
        $content = [];
        $content['usr'] = $row;
        $content['usr'][0]->status = $row[0]->status;
        $content['usr'][1]->status = $row[1]->status;
        $content['status'] = ($content['usr'][0]->status < $content['usr'][1]->status) ? $content['usr'][0]->status : $content['usr'][1]->status;
        // if ($content['a'] == $content['b'])
        {
            switch ($content['status'])    {
                // // submit rebuttal
                //3: reading time end, start to write for rebuttal
                case 3: 
                    $articles = ARTICLES::getArticlebySID($row[0]->id);
                    $content['usr'][0]->debate = $articles[1];
                    $articles = ARTICLES::getArticlebySID($row[1]->id);
                    $content['usr'][1]->debate = $articles[1];
                //2: submit argument, reading time
                case 2: 
                //1: finished video, reveal question, start to write for argument
                case 1: 
                    $content['competition'] = COMPETITION::getElementById($row[0]->cid);
                    $articles = ARTICLES::getArticlebySID($row[0]->id);
                    $content['usr'][0]->article = $articles[0];
                    $articles = ARTICLES::getArticlebySID($row[1]->id);
                    $content['usr'][1]->article = $articles[0];
                //0: competition start
            }
        }
        return ($content);
    }

    public static function pairsRoom($cid, $mid, $room, $role)
    {
        DB::table('session')
            -> where('cid', $cid)
            -> where('mid', $mid)
            -> update(['roomid' => $room, 'role' => $role]);
        return true;
    }

    public static function getCandidatesListbyCid($request)
    {
        $lst = DB::table('session')
                    -> whereIn('cid', $request['cid'])
                    -> where('role', '<', 3)
                    -> join('competition', 'competition.id', '=', 'session.cid')
                    -> join('users', 'users.id', '=', 'session.mid')
                    -> orderBy ('score', 'DESC')
                    -> select ('competition.tag', 'users.name_cn', 'session.id', 'session.score', 'session.status', 'session.rank')
                    -> get();
        if (!$lst)
            return (NULL);
        return $lst;
    }
    
    public static function updateRankingList($request)
    {
        foreach ($request['lst'] as $key => $value)
        {
            $content = sessions::find($key);
            if ($content)
            {
                $content->rank = $value;
                $content->status = 6;
                $content->save();
            }
        }
        return true;
    }

}
