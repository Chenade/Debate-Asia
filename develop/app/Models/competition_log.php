<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class competition_log extends Model
{
    use HasFactory;

    protected $table = 'competition_log';
    
    public $timestamps = true;

    protected $guarded = [];

    // getGroupByCid
    public static function getGroupByCid($competition_id)
    {
        return DB::table('competition')
                -> where('competition_id', $competition_id)
                -> get();
    }

}
