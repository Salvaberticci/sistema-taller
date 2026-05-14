<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $fillable = ['vehicle_id', 'customer_id', 'status', 'total_amount', 'description', 'entry_date', 'delivery_date'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function workItems()
    {
        return $this->hasMany(WorkItem::class);
    }
}
