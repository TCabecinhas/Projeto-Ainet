<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidatura extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['curso', 'nome', 'email', 'telefone1', 'telefone2', 'genero', 'media', 'm23', 'origem', 'obs'];

    protected function origemDescription(): Attribute
    {
        return Attribute::make(
            get: function () {
                switch ($this->origem) {
                    case 'P':
                        return 'Portugal';
                        break;
                    case 'UE':
                        return 'União Europeia';
                        break;
                    default:
                        return 'Outros';
                        break;
                }
            }
        );
    }

    protected function generoDescription(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->genero == 'F' ? 'Feminino' : 'Masculino';
            },
        );
    }

    protected function estatutosArray(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->estatutos()->pluck('pretende', 'estatuto')->toArray();
            }
        );
    }


    public function cursoRef(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso', 'abreviatura');
    }

    public function estatutos(): HasMany
    {
        return $this->hasMany(CandidaturaEstatuto::class, 'candidatura_id', 'id');
    }
}
