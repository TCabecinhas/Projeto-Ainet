<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'code';
    public $incrementing = false;    
    protected $table = 'colors';
    protected $fillable = ['name'];
    public $timestamps = false;

}

