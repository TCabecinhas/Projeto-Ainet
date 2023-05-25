<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Aluno extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['user_id', 'numero', 'curso'];

    public function cursoRef(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso', 'abreviatura');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function disciplinas(): BelongsToMany
    {
        return $this->belongsToMany(Disciplina::class, 'alunos_disciplinas');
    }
}
