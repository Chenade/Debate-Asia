<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $user = DB::table('session')-> where('mid', $request['mid']) -> first();
        if ($user)
            return (NULL);
        $content = new sessions;
        $content->mid = $request['mid'];
        $content->cid = $request['cid'];
        if (array_key_exists('role', $request))  $content->role = $request['role'];
        $content->save();
        return $content->id;
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

    public static function getElementById($id)
    {
        $row = DB::table('session')
                -> where('id', $id)
                -> select ('id', 'status', 'updated_at', 'mid')
                -> first();
        $row->user = USERS::getElementBySId($row->mid);
        return $row;
    }

    public static function deleteById($id)
    {
        $row = DB::table('session') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        $input = [];
        $input['del'] = 1;
        DB::table('session')-> where('id', $id)-> update($input);

        return true;
    }

    public static function updateById($id, $input)
    {
        $content = session::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('tag', $input)) $content->tag = $input['tag'];
        if (array_key_exists('title', $input)) $content->title = $input['title'];
        if (array_key_exists('date', $input)) $content->date = $input['date'];
        if (array_key_exists('t_write', $input)) $content->t_write = $input['t_write'];
        if (array_key_exists('t_read', $input)) $content->t_read = $input['t_read'];
        if (array_key_exists('t_debate', $input)) $content->t_debate = $input['t_debate'];
        $content->save();
        return true;
    }
    
    public static function pairsRoom($cid, $mid, $room, $role)
    {
        DB::table('session')
            -> where('cid', $cid)
            -> where('mid', $mid)
            -> update(['roomid' => $room, 'role' => $role]);
        return true;
    }
}
