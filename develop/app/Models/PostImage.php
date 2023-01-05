<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\True_;
use phpDocumentor\Reflection\Types\Null_;
use Ramsey\Uuid\Uuid;

class PostImage extends Model
{
    use HasFactory;

    protected $table = 'image';
    
    public $timestamps = true;

    protected $guarded = [];
    
    public static function store(Request $request, $type, $id){
        $data= new PostImage();
        $filename = NULL;

        if($request->file('image')){
            $file= $request->file('image');
            $filename= Uuid::uuid4().'.'.$file->extension();
            $file-> move(public_path('upload/Image'), $filename);
            $data['filename']= $file->getClientOriginalName();
            $data['uuid_name']= $filename;
            $data['type'] = $type;
            $data['linked_id']= $id;
        }
        $data->save();
        return $filename;
    }

    public static function getList($type, $id)
    {
        $row = DB::table('image')
                    -> select (['id', 'uuid_name'])
                    -> where('del', 0)
                    -> where('type', $type)
                    -> where('linked_id', $id)
                    -> get();
        $image = [];
        foreach ($row as &$value) {
            array_push($image, $value->uuid_name);
        }
        return $row;
    }

    public static function deleteById($id)
    {
        $row = DB::table('image') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        unlink($_SERVER['DOCUMENT_ROOT']."/upload/Image/".$row->uuid_name);
        DB::table('image')-> where('id', $id)-> update(['del' => 1]);
        return true;
    }

}
