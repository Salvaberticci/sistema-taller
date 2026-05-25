<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $customer_id
 * @property string $make
 * @property string $model
 * @property int $year
 * @property string $license_plate
 * @property string|null $vin
 * @property string|null $color
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceOrder[] $serviceOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VehiclePhoto[] $photos
 */
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
