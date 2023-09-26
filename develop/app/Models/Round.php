<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Round extends Model
{
    use HasFactory;

    protected $table = 'rounds';
    
    public $timestamps = true;

    protected $guarded = [];



}
