<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidaturaEstatuto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'candidaturas_estatutos';
    protected $fillable = ['candidatura_id', 'estatuto', 'pretende'];

    public function candidatura(): BelongsTo
    {
        return $this->belongsTo(Candidatura::class, 'candidatura_id', 'id');
    }

    protected function estatutoDescription(): Attribute
    {
        return Attribute::make(
            get: function () {
                switch ($this->estatuto) {
                    case 'TE':
                        return 'Trabalhador Estudante';
                        break;
                    case 'NE':
                        return 'Necessidades Especiais';
                        break;
                    case 'E':
                        return 'Erasmus';
                        break;
                    default:
                        return '';
                        break;
                }
            }
        );
    }
}
