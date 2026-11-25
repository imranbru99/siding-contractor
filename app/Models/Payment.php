<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id', 'amount', 'method', 'reference', 'paid_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'date',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function booted(): void
    {
        $sync = function (Payment $payment): void {
            $invoice = $payment->invoice;
            if (! $invoice) {
                return;
            }

            $paid = (float) $invoice->payments()->sum('amount');
            $invoice->update([
                'amount_paid' => $paid,
                'status' => $paid <= 0
                    ? ($invoice->status === 'void' ? 'void' : $invoice->status)
                    : ($paid >= (float) $invoice->total ? 'paid' : 'partial'),
            ]);
        };

        static::saved($sync);
        static::deleted($sync);
    }
}
