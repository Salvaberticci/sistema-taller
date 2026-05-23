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

    public function photos()
    {
        return $this->hasMany(VehiclePhoto::class);
    }

    /**
     * Mutator to ensure license plates are always stored in uppercase.
     */
    public function setLicensePlateAttribute($value)
    {
        $this->attributes['license_plate'] = strtoupper($value);
    }
}
