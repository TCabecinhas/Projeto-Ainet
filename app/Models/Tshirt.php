<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tshirt extends Model
{
    use HasFactory;

    protected $fillable = [
        'encomenda_id',
        'tshirtImage_id',
        'cor_codigo',
        'tamanho',
        'quantidade',
        'preco_un',
        'subtotal'
    ];

    public $timestamps = false;

    public function tshirtImage(){
        return $this->belongsTo(TshirtImage::class);
    }

    public function encomenda(){
        return $this->belongsTo(Encomenda::class);
    }

    public function cor(){
        return $this->belongsTo(Cor::class, 'codigo', 'cor_codigo');
    }


}
