<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkItem extends Model
{
    protected $fillable = ['service_order_id', 'description', 'type', 'quantity', 'unit_price', 'total'];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class);
    }
}
