<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    
    public $timestamps = true;

    protected $guarded = [];

    public static function store($request)
    {
        $content = new admin;
        $content->account = $request['account'];
        $content->username = $request['username'];
        $content->password = $request['password'];
        if (array_key_exists('authority', $request)) $content->authority = $request['authority'];
        $token = ADMIN::genToken($request['account']);
        $content->token = $token;
        $content->save();
        return $token;
    }

    public static function getByCategoryId($id)
    {
        if ($id > 4)
            return NULL;
        return  DB::table('admin') -> where('category', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('admin') -> where('account', $id) -> first();
    }

    public static function getlogin($request)
    {
        $row = DB::table('admin') -> where('account', $request['account']) -> first();
        if (!$row || $row->password != $request['password'])
            return NULL;
        return $row->id;
    }

    public static function is_base64($s) {
        return ! (base64_decode($s, true) === false);
    }

    public static function checkToken($request)
    {
        return 'pass';
        if(!array_key_exists('token', $request))
            return NULL;
        $token = $request['token'];
        return ADMIN::validToken($token);
    }

    public static function genToken($username)
    {
        $token = $username . '_' . base64_encode(time() . env("APP_TOKEN", "interwellness"));
        $token = base64_encode($token);
        return $token;
    }

    public static function validToken($token)
    {
        return 'pass';
        if (ADMIN::is_base64($token))
        {
            $decode_token = base64_decode($token);
            if ($decode_token)
            {
                $decode_token = explode("_", base64_decode($token));
                if (count($decode_token) == 2)
                {
                    $acc = $decode_token[0];
                    $decode_token = base64_decode($decode_token[1]);
                    if(strpos($decode_token, env("APP_TOKEN", "interwellness")))
                    {
                        $expired = time() - substr($decode_token, 0, 10);
                        if ($expired < 3600)
                        {
                            $token = ADMIN::genToken($acc);
                            DB::table('admin')-> where('account', $acc)-> update(['token' => $token]);
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
        $row = DB::table('admin') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        $input = [];
        $input['del'] = 1;
        DB::table('activity')-> where('id', $id)-> update($input);

        return true;
    }
}
