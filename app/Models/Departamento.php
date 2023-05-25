<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;
    protected $primaryKey = 'abreviatura';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['abreviatura', 'nome'];

    public function docentes(): HasMany
    {
        return $this->hasMany(Docente::class, 'departamento', 'abreviatura');
    }
}
