<?php

namespace App\Models;
use App\Models\sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Awards extends Model
{
    use HasFactory;

    protected $table = 'rank';
    
    public $timestamps = true;

    protected $guarded = [];

    public static function store($request)
    {
        $content = new Awards;
        $content->name = $request['name'];
        $content->save();
        return $content->id;
    }
    
    public static function updateById($id, $input)
    {
        $content = Awards::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('name', $input)) $content->name = $input['name'];
        if (array_key_exists('tag', $input)) $content->tag = $input['tag'];
        $content->save();
        return $content->id;
    }

    public static function getList()
    {
        return DB::table('rank')
                -> get();
    }

    public static function getElementById($id)
    {
        $row = DB::table('rank') 
                    -> where('id', $id) 
                    -> first();
        return ($row);
    }

    public static function deleteById($id)
    {
        $row = DB::table('rank') -> where('id',$id) -> delete();
        return true;
    }
}
