<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';
    protected $fillable = [
        'nif',
        'address',
        'default_payment_type',     
        'default_payment_ref',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function images(){
        return $this->hasMany(TshirtImage::class, 'customer_id', 'id');
    }

    public function encomendas(){
        return $this->hasMany(Encomenda::class, 'customer_id', 'id');
    }
}
