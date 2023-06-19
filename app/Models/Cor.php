<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'colors';

    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function tshirts(){
        return $this->hasMany(Tshirt::class, 'color_code', 'code');
    }
}
