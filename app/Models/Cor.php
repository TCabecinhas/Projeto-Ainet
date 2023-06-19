<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cores';

    protected $primaryKey = 'codigo';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nome'
    ];

    public function tshirts(){
        return $this->hasMany(Tshirt::class, 'cor_codigo', 'codigo');
    }
}
