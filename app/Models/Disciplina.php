<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disciplina extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['curso', 'ano', 'semestre', 'abreviatura', 'nome', 'ECTS', 'horas', 'opcional'];

    protected function semestreStr(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->semestre == '0' ? 'Anual' : $this->semestre . 'º';
            },
        );
    }

    public function cursoRef(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso', 'abreviatura');
    }

    public function docentes(): BelongsToMany
    {
        return $this->belongsToMany(Docente::class, 'docentes_disciplinas');
    }

    public function alunos(): BelongsToMany
    {
        return $this->belongsToMany(Aluno::class, 'alunos_disciplinas');
    }
}
