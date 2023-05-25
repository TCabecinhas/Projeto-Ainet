<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Docente extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['user_id', 'departamento', 'gabinete', 'extensao', 'cacifo'];

    public function departamentoRef(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento', 'abreviatura');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function disciplinas(): BelongsToMany
    {
        return $this->belongsToMany(Disciplina::class, 'docentes_disciplinas', 'docente_id', 'disciplina_id');
    }
}
