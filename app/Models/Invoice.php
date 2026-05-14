<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['service_order_id', 'number', 'total', 'status', 'issue_date'];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
