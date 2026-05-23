<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'id_card', 'email', 'phone', 'address'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
