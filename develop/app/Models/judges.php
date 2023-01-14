<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class judges extends Model
{
    use HasFactory;

    protected $table = 'judge';
    
    public $timestamps = true;

    protected $guarded = [];

    // protected $casts = [
    //     'content' => 'array'
    // ];

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

    public static function getListbyCID($cid)
    {
        return DB::table('judge')
                -> where('cid', $cid) 
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
        $content = judge::find($id);
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
}
