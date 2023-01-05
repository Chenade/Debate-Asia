<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';
    
    public $timestamps = true;

    protected $guarded = [];

    // protected $casts = [
    //     'content' => 'array'
    // ];

    public static function store($request)
    {
        $content = new Media;
        $content->type = $request['type'];
        $content->link = $request['link'];
        $content->content = json_encode($request['content']);
        if (array_key_exists('ord', $request)) $content->ord = $request['ord'];
        $content->save();
    }

    public static function getList()
    {
        return DB::table('media')
                -> where('del', 0)
                -> orderBy('ord', 'DESC') 
                -> get();
    }

    public static function getindexList()
    {
        $time = time();
        return DB::table('media')
                -> where('del', 0)
                -> orderBy('ord', 'DESC') 
                -> get();
    }

    public static function getByCategoryId($id)
    {
        if ($id > 2)
            return NULL;
        return  DB::table('media') -> where('category', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('media') -> where('id', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function deleteById($id)
    {
        $row = DB::table('media') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        $input = [];
        $input['del'] = 1;
        DB::table('media')-> where('id', $id)-> update($input);

        return true;
    }

    public static function updateById($id, $input)
    {
        $content = MEDIA::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('type', $input)) $content->type = $input['type'];
        if (array_key_exists('content', $input)) $content->content = '"' . ($input['content']) . '"';
        if (array_key_exists('link', $input)) $content->link = $input['link'];
        if (array_key_exists('link_alt', $input)) $content->link_alt = $input['link_alt'];
        if (array_key_exists('ord', $input)) $content->ord = $input['ord'];
        $content->save();
        return true;
    }

    public static function uploadThumbnail($request, $id){
        
        $row = DB::table('media') -> where('id', $id) -> first();
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
            DB::table('media')-> where('id', $id)-> update(['image' => $filename]);
        }

        return $filename;
    }
}
