<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'order_date',
        'member_id',
        'product_id',
        'product_number',
        'appointment_date',
        'finish_date',
        'start',
        'end',
        'worker',
        'source',
        'memo',
        'user_id',
        'work_status',
        'fix_description',
        'fix_item',
        'fix_method',
        'special_price',
        'ttl_price',
        'service_id',
        'order_type',
        'order_descr',      
    ];
}
