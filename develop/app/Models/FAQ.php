<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faq';
    
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];

    public static function store($request)
    {
        $content = new FAQ;
        $content->question = $request['question'];
        $content->answer = $request['answer'];
        if (array_key_exists('ord', $request)) $content->ord = $request['ord'];
        $content->save();
    }

    public static function getList()
    {
        return DB::table('faq')
                -> where('del', 0)
                -> orderBy('ord', 'DESC') 
                -> get();
    }

    public static function getByCategoryId($id)
    {
        if ($id > 2)
            return NULL;
        return  DB::table('faq') -> where('category', $id) -> where('del', 0) -> orderBy('priority', 'DESC') -> get();
    }

    public static function getElementById($id)
    {
        return DB::table('faq') -> where('id', $id) -> where('del', 0) -> orderBy('ord', 'DESC') -> get();
    }

    public static function deleteById($id)
    {
        $row = DB::table('faq') -> where('id',$id) -> first();
        if (!$row)
            return NULL;
        DB::table('faq')-> where('id', $id)-> update(["del" => 1]);

        return true;
    }

    public static function updateById($id, $input)
    {
        $content = FAQ::find($id);
        if (!$content)
            return NULL;
        $content->timestamps = true;
        if (array_key_exists('question', $input)) $content->question = $input['question'];
        if (array_key_exists('answer', $input)) $content->answer = $input['answer'];
        if (array_key_exists('ord', $input)) $content->ord = $input['ord'];
        $content->save();
        return true;
    }
}
