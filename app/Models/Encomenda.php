<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'status',
        'customer_id',
        'date',
        'total_price',
        'notes',
        'nif',
        'address',
        'payment_type',
        'payment_ref',
        'receipt_url'
    ];

    public function tshirts(){
        return $this->hasMany(Tshirt::class, 'order_id', 'id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'customer_id', 'id');
    }
}
