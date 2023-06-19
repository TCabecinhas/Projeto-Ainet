<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nif',
        'endereco',
        'tipo_pagamento',
        'ref_pagamento',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function images(){
        return $this->hasMany(TshirtImage::class, 'cliente_id', 'id');
    }

    public function encomendas(){
        return $this->hasMany(Encomenda::class, 'cliente_id', 'id');
    }
}
