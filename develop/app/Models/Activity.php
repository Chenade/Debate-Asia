<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activity';
    
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];

    public static function store($request)
    {
        $content = new activity;
        $content->category = $request['category'];
        $content->title = $request['title'];
        $content->content = $request['content'];
        $content->ts = (array_key_exists('ts', $request)) ? $request['ts'] : time();
        if (array_key_exists('image', $request)) $content->link = $request['image'];
        if (array_key_exists('ord', $request)) $content->ord = $request['ord'];
        $content->save();
    }

    public static function getByCategoryId($id)
    {
        if ($id > 4)
            return NULL;
        return  DB::table('activity') -> where('category', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('activity') -> where('id', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function deleteById($id)
    {
        $row = DB::table('activity') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        $input = [];
        $input['del'] = 1;
        DB::table('activity')-> where('id', $id)-> update($input);

        return true;
    }
}
