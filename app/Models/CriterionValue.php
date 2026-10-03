<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CriterionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'criterion_id',
        'label',
        'value',
        'description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'float',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Kriteria tempat nilai indikator ini berada.
     */
    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }
}
