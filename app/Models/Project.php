<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'project_number', 'customer_id', 'assigned_to', 'title', 'description',
        'status', 'priority', 'site_address', 'sqft', 'estimated_value',
        'actual_value', 'start_date', 'target_date', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'sqft' => 'decimal:2',
            'estimated_value' => 'decimal:2',
            'actual_value' => 'decimal:2',
            'start_date' => 'date',
            'target_date' => 'date',
            'completed_at' => 'date',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
