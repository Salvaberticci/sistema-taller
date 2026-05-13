<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['customer_id', 'make', 'model', 'year', 'license_plate', 'vin', 'color'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }
}
