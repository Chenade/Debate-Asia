<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Peter extends Model
{
    use HasFactory;

    protected $table = 'peter';
    
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];

    public static function get()
    {
        return DB::table('peter') -> first();
    }

    public static function updateContent($input)
    {
        $content = Peter::find(1);
        if (!$content)
        {
            $content = new Peter;
            $content->content = stripslashes($input['content']);
            $content->save();
        }
        else{
            $content->timestamps = true;
            if (array_key_exists('content', $input)) $content->content = stripslashes($input['content']);
            $content->save();
        }
        return true;
    }
}
