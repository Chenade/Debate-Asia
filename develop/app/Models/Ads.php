<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ads extends Model
{
    use HasFactory;

    protected $table = 'ads';
    
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];

    public static function store($request)
    {
        $content = new Ads;
        $content->title = $request['title'];
        $content->start_at = $request['start_at'];
        $content->end_at = $request['end_at'];
        if (array_key_exists('link', $request)) $content->link = $request['link'];
        if (array_key_exists('priority', $request)) $content->priority = $request['priority'];
        $content->save();
    }

    public static function getList()
    {
        return DB::table('ads')
                -> where('del', 0)
                -> orderBy('priority', 'DESC') 
                -> get();
    }

    public static function getByCategoryId($id)
    {
        if ($id > 2)
            return NULL;
        return  DB::table('ads') -> where('category', $id) -> where('del', 0) -> orderBy('priority', 'DESC') -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('ads') -> where('id', $id) -> where('del', 0) -> orderBy('priority', 'DESC') -> get();
    }

    public static function deleteById($id)
    {
        $row = DB::table('ads') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        DB::table('ads')-> where('id', $id)-> update(["del" => 1]);

        return true;
    }

    public static function updateById($id, $input)
    {
        $content = BANNER::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('title', $input)) $content->title = $input['title'];
        if (array_key_exists('link', $input)) $content->link = $input['link'];
        if (array_key_exists('priority', $input)) $content->priority = $input['priority'];
        if (array_key_exists('start_at', $input)) $content->start_at = $input['start_at'];
        if (array_key_exists('end_at', $input)) $content->end_at = $input['end_at'];
        $content->save();
        return true;
    }
}
