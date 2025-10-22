<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KpiData extends Model
{
    protected $fillable = [
        'kpi_id',
        'user_id',
        'value',
        'recorded_date',
        'notes'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'recorded_date' => 'date',
    ];

    public function kpi(): BelongsTo
    {
        return $this->belongsTo(Kpi::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
