<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class competition extends Model
{
    use HasFactory;

    protected $table = 'competition';
    
    public $timestamps = true;

    protected $guarded = [];

    // protected $casts = [
    //     'content' => 'array'
    // ];

    public static function store($request)
    {
        // $content->content = json_encode($request['content']);
        $content = new Competition;
        $content->tag = $request['tag'];
        $content->title = $request['title'];
        $content->date = $request['date'];
        $content->t_write = $request['t_write'];
        $content->t_read = $request['t_read'];
        $content->t_debate = $request['t_debate'];
        $content->save();
        return $content->id;
    }

    public static function getList()
    {
        return DB::table('competition')
                -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('competition') 
                -> where('id', $id) 
                -> get();
    }

    public static function deleteById($id)
    {
        $content = competition::find($id);
        if (!$content)
            return (NULL);
        
            $lst = DB::table('session') -> where('cid', $id)  ->get();
            foreach ($lst as $key => $value) {
                if ($value->camera)
                    unlink($_SERVER['DOCUMENT_ROOT']."/camera//" . $value->camera);
                $deleted = DB::table('article') -> where('sid', $value->id)  ->delete();
            }
            $deleted = DB::table('session') -> where('cid', $id)  ->delete();
            $deleted = DB::table('competition') -> where('id',$id)  ->delete();
        return true;
    }

    public static function updateById($id, $input)
    {
        $content = competition::find($id);
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

    
    public static function getInfoBySid($sid)
    {
        $row = DB::table('session')
            -> where('id', $sid)
            -> first();
        $row2 = DB::table('competition')
            -> where('id', $row->cid)
            -> first();
        return $row2;
    }

}
