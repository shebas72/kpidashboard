<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kpi extends Model
{
    protected $fillable = [
        'name',
        'description',
        'kpi_category_id',
        'user_id',
        'unit',
        'measurement_type',
        'target_value',
        'current_value',
        'start_date',
        'end_date',
        'frequency',
        'is_active'
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'current_value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(KpiCategory::class, 'kpi_category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kpiData(): HasMany
    {
        return $this->hasMany(KpiData::class);
    }

    public function getProgressPercentageAttribute(): float
    {
        if (!$this->target_value || !$this->current_value) {
            return 0;
        }

        return ($this->current_value / $this->target_value) * 100;
    }
}
