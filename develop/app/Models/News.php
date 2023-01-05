<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';
    
    public $timestamps = true;

    protected $guarded = [];

    // protected $casts = [
    //     'content' => 'array'
    // ];

    public static function store($request)
    {
        $content = new News;
        $content->category = $request['category'];
        $content->title = $request['title'];
        $content->content = json_encode($request['content']);
        $content->start_at = $request['start_at'];
        $content->end_at = $request['end_at'];
        $content->ts = (array_key_exists('ts', $request)) ? $request['ts'] : time();
        if (array_key_exists('link', $request)) $content->link = strlen($request['link']) ? $request['link'] : null;
        if (array_key_exists('link_alt', $request)) $content->link_alt = strlen($request['link_alt']) ? $request['link_alt'] : null;
        if (array_key_exists('ord', $request)) $content->ord = $request['ord'];
        $content->save();
        return $content->id;
    }

    public static function getList()
    {
        return DB::table('news')
                -> where('del', 0)
                -> orderBy('ord', 'DESC') 
                -> get();
    }

    public static function getindexList()
    {
        $time = time();
        return DB::table('news')
                -> where('del', 0)
                -> where('start_at', '<=', $time)
                -> where('end_at', '>=', $time)
                -> orderBy('ord', 'DESC') 
                -> get();
    }

    public static function getByCategoryId($id)
    {
        if ($id > 2)
            return NULL;
        return  DB::table('news') -> where('category', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('news') -> where('id', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function deleteById($id)
    {
        $row = DB::table('news') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        $input = [];
        $input['del'] = 1;
        DB::table('news')-> where('id', $id)-> update($input);

        return true;
    }

    public static function updateById($id, $input)
    {
        $content = NEWS::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('category', $input)) $content->category = $input['category'];
        if (array_key_exists('title', $input)) $content->title = $input['title'];
        if (array_key_exists('content', $input)) $content->content = '"' . ($input['content']) . '"';
        if (array_key_exists('link', $input)) $content->link = $input['link'];
        if (array_key_exists('link_alt', $input)) $content->link_alt = $input['link_alt'];
        if (array_key_exists('ord', $input)) $content->ord = $input['ord'];
        if (array_key_exists('start_at', $input)) $content->start_at = $input['start_at'];
        if (array_key_exists('end_at', $input)) $content->end_at = $input['end_at'];
        $content->save();
        return true;
    }

    public static function uploadThumbnail($request, $id){
        
        $row = DB::table('news') -> where('id', $id) -> first();
        if (!$row)
            return NULL;
        
        $filename = NULL;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= Uuid::uuid4().'.'.$file->extension();
            $file-> move(public_path('upload/Image'), $filename);
        }
        
        if ($filename){
            if ($row->image != '')
                unlink($_SERVER['DOCUMENT_ROOT']."/upload/Image/".$row->image);
            DB::table('news')-> where('id', $id)-> update(['image' => $filename]);
        }

        return $filename;
    }
}
