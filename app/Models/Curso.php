<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    use HasFactory;
    protected $primaryKey = 'abreviatura';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['abreviatura', 'nome', 'tipo', 'semestres', 'ECTS', 'vagas', 'contato', 'objetivos'];

    public function disciplinas(): HasMany
    {
        return $this->hasMany(Disciplina::class, 'curso', 'abreviatura')
            ->orderBy('ano')
            ->orderBy('semestre')
            ->orderBy('nome');
    }

    public function alunos(): HasMany
    {
        return $this->hasMany(Aluno::class, 'curso', 'abreviatura');
    }

    public function candidaturas(): HasMany
    {
        return $this->hasMany(Candidatura::class, 'curso', 'abreviatura');
    }
}
