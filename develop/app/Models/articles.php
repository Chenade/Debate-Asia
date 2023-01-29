<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class articles extends Model
{
    use HasFactory;

    protected $table = 'article';
    
    public $timestamps = true;

    protected $guarded = [];

    // protected $casts = [
    //     'content' => 'array'
    // ];

    public static function store($request)
    {
        $article = DB::table('article')-> where('sid', $request['sid']) -> first();
        if ($article)
            return (NULL);
        $content = new articles;
        $content->sid = $request['sid'];
        $content->type = $request['type'];
        $content->save();
        return $content->id;
    }

    public static function initArticle($sid)
    {
        $content = DB::table('article')
                    -> where('sid', $sid) 
                    -> where('type', 0) 
                    -> first();
        if (!$content)
        {
            $content = new articles;
            $content->sid = $sid;
            $content->type = 0;
            $content->save();
        }
        
        $content = DB::table('article')
                    -> where('sid', $sid) 
                    -> where('type', 1) 
                    -> first();
        if (!$content)
        {
            $content = new articles;
            $content->sid = $sid;
            $content->type = 1;
            $content->save();
        }
        return DB::table('article')
                    -> where('sid', $sid) 
                    -> orderBy('type', 'ASC') 
                    -> get();
    }

    public static function getArticlebySID($sid)
    {
        $content = DB::table('article')
                    -> where('sid', $sid) 
                    -> orderBy('type', 'ASC') 
                    -> get();
        if (count($content) < 2)
            return (ARTICLES::initArticle($sid));
        return ($content);
    }

    public static function getElementById($id)
    {
        return DB::table('article') 
                -> where('id', $id) 
                -> get();
    }

    public static function deleteById($id)
    {
        $row = DB::table('article') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        $input = [];
        $input['del'] = 1;
        DB::table('article')-> where('id', $id)-> update($input);

        return true;
    }

    public static function updateById($id, $input)
    {
        $content = articles::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('content', $input)) $content->content = json_encode($input['content'], JSON_UNESCAPED_UNICODE);
        $content->save();
        return true;
    }
    
    public static function pairsRoom($cid, $mid, $room, $role)
    {
        DB::table('article')
            -> where('cid', $cid)
            -> where('mid', $mid)
            -> update(['roomid' => $room, 'role' => $role]);
        return true;
    }
}
