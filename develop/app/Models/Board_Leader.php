<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Board_Leader extends Model
{
    use HasFactory;

    protected $table = 'board_leader';
    
    public $timestamps = true;

    public static function getFirst()
    {
        return DB::table('board_leader')->first();
    }
}
