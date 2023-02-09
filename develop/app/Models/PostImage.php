<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\True_;
use phpDocumentor\Reflection\Types\Null_;
use Ramsey\Uuid\Uuid;
use App\Models\sessions;


class PostImage extends Model
{
    use HasFactory;

    protected $table = 'image';
    
    public $timestamps = true;

    protected $guarded = [];

    public static function store(Request $request){
        $content = SESSIONS::find($request->sid);
        if (!$content)
            return NULL;
        return $request->id;
        $content->timestamps = true;
        $content->camera = $request->dataURI;
        $content->save();
        return true;
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
