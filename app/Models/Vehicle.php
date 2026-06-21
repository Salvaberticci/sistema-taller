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
 * @property int|null $mileage
 * @property string|null $fuel_level
 * @property int|null $assigned_mechanic_id
 * @property int|null $make_id
 * @property int|null $model_id
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ServiceOrder[] $serviceOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VehiclePhoto[] $photos
 */
class Vehicle extends Model
{
    protected $fillable = [
        'customer_id', 'make', 'model', 'year', 'license_plate', 'vin', 'color',
        'mileage', 'fuel_level', 'assigned_mechanic_id', 'make_id', 'model_id',
    ];

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

    public function assignedMechanic()
    {
        return $this->belongsTo(User::class, 'assigned_mechanic_id');
    }

    public function vehicleMake()
    {
        return $this->belongsTo(VehicleMake::class, 'make_id');
    }

    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class, 'model_id');
    }

    public function setLicensePlateAttribute($value)
    {
        $this->attributes['license_plate'] = strtoupper($value);
    }

    public function setVinAttribute($value)
    {
        $this->attributes['vin'] = $value ? strtoupper($value) : null;
    }
}
