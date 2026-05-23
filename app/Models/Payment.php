<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['invoice_id', 'amount', 'method', 'payment_date', 'status', 'confirmed_at', 'reference', 'notes'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payment_date' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Verificar si el pago está confirmado
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmado';
    }

    /**
     * Verificar si el pago está pendiente
     */
    public function isPending(): bool
    {
        return $this->status === 'pendiente';
    }

    /**
     * Confirmar el pago
     */
    public function confirm(): void
    {
        $this->update([
            'status' => 'confirmado',
            'confirmed_at' => now(),
        ]);
    }
}
