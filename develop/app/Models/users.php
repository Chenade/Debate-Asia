<?php

namespace App\Models;
use App\Models\sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\competition_log;

class users extends Model
{
    use HasFactory;

    protected $table = 'users';
    
    public $timestamps = true;

    protected $guarded = [];

    public static function store($request)
    {
        $content = new users;
        $content->authority = $request['authority'];
        $content->email = $request['email'];
        $content->account = $request['account'];
        $content->password = $request['password'];
        $content->school_cn = $request['school_cn'];
        $content->school_zh = $request['school_zh'];
        $content->name_cn = $request['name_cn'];
        $content->name_zh = $request['name_zh'];
        $content->cellphone = $request['cellphone'];
        $content->birthday = $request['birthday'];
        $content->wechat = $request['wechat'];
        $content->whatsapp = $request['whatsapp'];
        $content->lineid = $request['lineid'];
        // $token = users::genToken($request['account']);
        $content->token = "";
        $content->save();
        return "";
    }

    public static function getInfo($request)
    {
        $usr = DB::table('users') 
            -> where('account', $request['account']) 
            -> first();

        if ($usr && $usr->password == $request['password'])
            return $content = users::find($usr->id);
        return NULL;
    }

    public static function signup($request)
    {
        $usr = DB::table('users') 
            -> where('account', $request['account']) 
            -> first();

        if (!$usr)
            $content = new users;
        else if ($usr && $usr->password == $request['password'])
            $content = users::find($usr->id);
        else
            return "Account already taken / Wrong Password!";

        $content->authority = 1;
        $content->email = $request['email'];
        $content->account = $request['account'];
        $content->password = $request['password'];
        $content->school_cn = $request['school'];
        $content->school_zh = $request['school'];
        $content->name_cn = $request['chinese_name'];
        $content->name_zh = $request['chinese_name'];
        $content->name_en = $request['english_name'];
        $content->gender = $request['gender'];
        $content->birthday = $request['birthday'];
        $content->cellphone = $request['cellphone'];
        $content->wechat = $request['wechat'];
        $content->address = $request['address'];
        $content->mentor = $request['mentor'];
        
        // $content->whatsapp = $request['whatsapp'];
        // $content->lineid = $request['lineid'];
        // $token = users::genToken($request['account']);
        // $content->token = "";
        $content->save();

        $chk = DB::table('competition_log') 
            -> where('userId', $content->id) 
            -> first();
        if ($chk)
            return "Already signed up!";

        $log = new competition_log;
        $log->userId = $content->id;
        $log->groupId = $request['group'];
        $log->date =  json_encode($request['date']);
        $log->language = $request['language'];
        $log->invoice_name = $request['invoice_name'];
        $log->invoice_no = $request['invoice_no'];
        $log->proof = $request['proof'];
        $log->save();

        return NULL;
    }

    // getSignupLst
    public static function getSignupLst($request)
    {
        $lst = DB::table('competition_log') 
                    ->select('competition_log.*', 'users.id as user_id', 'groups.*', 'users.name_cn', 'users.name_zh', 'users.school_cn', 'users.school_zh')
                    -> where ('competition_log.competition_id', $request['competition_id'])
                    -> leftJoin('users', 'competition_log.userId', '=', 'users.id')
                    -> leftJoin('groups', 'competition_log.groupId', '=', 'groups.group_id')
                    -> get();

        return $lst;
    }

    //getSignupById
    public static function getSignupById($id)
    {
        $lst = DB::table('competition_log') 
                    ->select('competition_log.*', 'users.id as user_id', 'groups.*', 'users.name_cn', 'users.name_zh', 'users.school_cn', 'users.school_zh')
                    -> where ('competition_log.id', $id)
                    -> leftJoin('users', 'competition_log.userId', '=', 'users.id')
                    -> leftJoin('groups', 'competition_log.groupId', '=', 'groups.group_id')
                    -> first();

        return $lst;
    }

    //signUpApprove
    public static function signUpApprove($id)
    {
        $log = competition_log::find($id);
        if (!$log)
            return "No such record!";
        $log->approval = 1;
        $log->save();
        return NULL;
    }
    
    public static function updateById($id, $input)
    {
        $content = USERS::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('authority', $input)) $content->authority = $input['authority'];
        if (array_key_exists('email', $input)) $content->email = $input['email'];
        if (array_key_exists('account', $input)) $content->account = $input['account'];
        if (array_key_exists('password', $input)) $content->password = $input['password'];
        if (array_key_exists('school_cn', $input)) $content->school_cn = $input['school_cn'];
        if (array_key_exists('school_zh', $input)) $content->school_zh = $input['school_zh'];
        if (array_key_exists('name_cn', $input)) $content->name_cn = $input['name_cn'];
        if (array_key_exists('name_zh', $input)) $content->name_zh = $input['name_zh'];
        if (array_key_exists('cellphone', $input)) $content->cellphone = $input['cellphone'];
        if (array_key_exists('birthday', $input)) $content->birthday = $input['birthday'];
        if (array_key_exists('wechat', $input)) $content->wechat = $input['wechat'];
        if (array_key_exists('whatsapp', $input)) $content->whatsapp = $input['whatsapp'];
        if (array_key_exists('lineid', $input)) $content->lineid = $input['lineid'];
        $content->save();
        return true;
    }

    public static function getList()
    {
        return DB::table('users')
                -> get();
    }

    public static function getElementByRole($type)
    {
        if ($type != 1 && $type != 2 && $type != 7)
            return NULL;
        return  DB::table('users') -> where('authority', $type) -> get();
    }


    public static function getElementBySId($id)
    {
        return DB::table('users')
                        -> where('id', $id)
                        -> select ('id', 'name_cn', 'school_cn')
                        -> first();
    }

    public static function getElementById($id)
    {
        $row = DB::table('users') 
                    -> where('id', $id) 
                    -> first();
        return ($row);
    }
    
    public static function getEventListByUser($id)
    {
        $lst = DB::table('users') 
                    -> where('id', $id) 
                    -> first();
        if ($lst)
        {
            unset ($lst->password);
            unset ($lst->authority);
            unset ($lst->created_at);
            unset ($lst->updated_at);
            $lst->competition = SESSIONS::getListByUser($id);
            foreach ($lst->competition as $row)
            {
                unset($row->t_debate);
                unset($row->t_read);
                unset($row->t_write);
                unset($row->created_at);
                unset($row->updated_at);
                $op = DB::table('session')
                        -> where('roomid', $row->roomid)
                        -> where('cid', $row->cid)
                        -> leftJoin('users', 'session.mid', '=', 'users.id')
                        -> select ('session.id', 'session.mid', 'session.role', 'users.name_cn', 'users.name_zh', 'users.school_cn', 'users.school_zh')
                        -> get();
                $row->usr = $op;
                if ($row->status < 3)
                    unset ($row->title);
                    unset ($row->role);
            }
        }
        return ($lst);
    }

    public static function getJudgeListByUser($id)
    {
        $lst = DB::table('users') 
                    -> where('id', $id) 
                    -> first();
        if ($lst)
        {
            unset ($lst->password);
            unset ($lst->authority);
            unset ($lst->created_at);
            unset ($lst->updated_at);
            $lst->competition = SESSIONS::getListByUser($id);
            foreach ($lst->competition as $row)
            {
                unset($row->t_debate);
                unset($row->t_read);
                unset($row->t_write);
                unset($row->created_at);
                unset($row->updated_at);
            }
        }
        return ($lst);
    }

    public static function getlogin($request)
    {
        $row = DB::table('users') -> where('account', $request['account']) -> first();
        if (!$row || $row->password != $request['password'])
            return NULL;
        return $row->id;
    }

    public static function is_base64($s) {
        return ! (base64_decode($s, true) === false);
    }

    public static function checkToken($request)
    {
        if(!array_key_exists('token', $request))
            return NULL;
        $token = $request['token'];
        return USERS::validToken($token);
    }

    public static function genToken($username)
    {
        $row = DB::table('users')->where('account', $username)->first();
        $token = $row->authority . '_' . base64_encode($row->account) . '_' . base64_encode(time() . env("APP_TOKEN", "debateAsia"));
        $token = base64_encode($token);
        return $token;
    }

    public static function getauth($token)
    {
        if (USERS::is_base64($token))
        {
            $decode_token = base64_decode($token);
            if ($decode_token)
            {
                $decode_token = explode("_", base64_decode($token));
                if (count($decode_token) == 3)
                {
                    $auth = $decode_token[0];
                    return ($auth);
                }
            }
        }
        return NULL;        
    }

    public static function getId($token)
    {
        if (USERS::is_base64($token))
        {
            $decode_token = base64_decode($token);
            if ($decode_token)
            {
                $decode_token = explode("_", base64_decode($token));
                if (count($decode_token) == 3)
                {
                    $acc = base64_decode($decode_token[1]);
                    $row = DB::table('users')->where('account', $acc)->first();
                    return ($row->id);
                }
            }
        }
        return NULL;        
    }


    public static function getAcc($token)
    {
        if (USERS::is_base64($token))
        {
            $decode_token = base64_decode($token);
            if ($decode_token)
            {
                $decode_token = explode("_", base64_decode($token));
                if (count($decode_token) == 3)
                {
                    $acc = base64_decode($decode_token[1]);
                    return ($acc);
                }
            }
        }
        return NULL;        
    }

    public static function validToken($token)
    {
        if (USERS::is_base64($token))
        {
            $decode_token = base64_decode($token);
            if ($decode_token)
            {
                $decode_token = explode("_", base64_decode($token));
                if (count($decode_token) == 3)
                {
                    $acc = base64_decode($decode_token[1]);
                    $auth = $decode_token[0];
                    $decode_token = base64_decode($decode_token[2]);
                    if(strpos($decode_token, env("APP_TOKEN", "debateAsia")))
                    {
                        {
                            $token = USERS::genToken($acc);
                            return $token;
                        }
                    }
                }
            }
        }
        return NULL;        
    }

    public static function deleteById($id)
    {
        $row = DB::table('users') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        if ($row->locked == 1)
            return NULL;
        DB::table('users') -> where('id',$id) -> delete();
        return true;
    }

    public static function lockById($id)
    {
        $row = DB::table('users') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        DB::table('users') -> where('id',$id) -> update(['locked' => 1]);
        return true;
    }
}
