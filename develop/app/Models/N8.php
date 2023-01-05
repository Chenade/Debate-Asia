<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class N8 extends Model
{
    use HasFactory;

    protected $table = 'n8';
    
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];

    public static function store($request)
    {
        $content = new N8;
        $content->title = $request['title'];
        $content->content = $request['content'];
        if (array_key_exists('link', $request)) $content->link = $request['link'];
        if (array_key_exists('ord', $request)) $content->ord = $request['ord'];
        $content->save();
    }

    public static function getList()
    {
        return DB::table('n8')
                -> where('del', 0)
                -> orderBy('ord', 'DESC') 
                -> get();
    }

    public static function getByCategoryId($id)
    {
        if ($id > 2)
            return NULL;
        return  DB::table('n8') -> where('category', $id) -> where('del', 0) -> orderBy('priority', 'DESC') -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('n8') -> where('id', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function deleteById($id)
    {
        $row = DB::table('n8') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        DB::table('n8')-> where('id', $id)-> update(["del" => 1]);

        return true;
    }

    public static function updateById($id, $input)
    {
        $content = N8::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('title', $input)) $content->title = $input['title'];
        if (array_key_exists('content', $input)) $content->content = $input['content'];
        if (array_key_exists('link', $input)) $content->link = strlen($input['link']) ? $input['link'] : null;
        if (array_key_exists('ord', $input)) $content->link = $input['ord'];
        $content->save();
        return true;
    }

    public static function uploadThumbnail($request, $id){
        $row = DB::table('n8') -> where('id', $id) -> first();
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
            DB::table('n8')-> where('id', $id)-> update(['image' => $filename]);
        }
        return $filename;
    }
}
