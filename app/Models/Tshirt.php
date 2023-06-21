<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tshirt extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'tshirt_image_id',
        'color_code',
        'size',
        'qty',
        'unit_price',
        'sub_total'
    ];

    public $timestamps = false;

    public function tshirtImage(){
        return $this->belongsTo(TshirtImage::class);
    }

    public function encomenda(){
        return $this->belongsTo(Encomenda::class);
    }

    public function cor(){
        return $this->belongsTo(Cor::class, 'code', 'color_code');
    }


}
