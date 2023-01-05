<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    use HasFactory;

    protected $table = 'course';
    
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];

    public static function store($request)
    {
        $content = new course;
        $content->title = $request['title'];
        $content->content = $request['content'];
        if (array_key_exists('ord', $request)) $content->ord = $request['ord'];
        $content->save();
    }

    public static function getList()
    {
        return DB::table('course')
                -> where('del', 0)
                -> orderBy('ord', 'DESC') 
                -> get();
    }

    public static function getByCategoryId($id)
    {
        if ($id > 2)
            return NULL;
        return  DB::table('course') -> where('category', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('course') -> where('id', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function deleteById($id)
    {
        $row = DB::table('course') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        $input = [];
        $input['del'] = 1;
        DB::table('course')-> where('id', $id)-> update($input);

        return true;
    }

    public static function updateById($id, $input)
    {
        $content = course::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('title', $input)) $content->title = $input['title'];
        if (array_key_exists('content', $input)) $content->content = ($input['content']);
        if (array_key_exists('ord', $input)) $content->ord = $input['ord'];
        $content->save();
        return true;
    }

    public static function get()
    {
        return DB::table('course') -> first();
    }

    public static function updateContent($input)
    {
        $content = COURSE::find(1);
        if (!$content)
        {
            $content = new COURSE;
            $content->content = $input['content'];
            $content->save();
        }
        else{
            $content->timestamps = true;
            if (array_key_exists('content', $input)) $content->content = ($input['content']);
            $content->save();
        }
        return true;
    }
}
