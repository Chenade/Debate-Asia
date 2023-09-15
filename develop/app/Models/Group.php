<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    
    public $timestamps = true;

    protected $guarded = [];

    // getGroupByCid
    public static function getGroupByCid($competition_id)
    {
        return DB::table('groups')
                -> where('competition_id', $competition_id)
                -> get();
    }

}
