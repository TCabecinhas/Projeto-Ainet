<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TshirtImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tshirt_images';

    protected $fillable = [
        'customer_id',
        'category_id',
        'name',
        'description',
        'image_url',
        'extra_info',
    ];

    public function categoria(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function tshirts(){
        return $this->hasMany(Tshirt::class, 'tshirtimage_id', 'id');
    }
}
