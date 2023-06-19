<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $table = 'categories';
    protected $fillable = [
        'name'
    ];

    public function images(){
        return $this->hasMany(TshirtImage::class);
    }
}
