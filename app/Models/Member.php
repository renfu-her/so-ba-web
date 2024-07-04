<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sex',
        'mobile',
        'phone',
        'county',
        'district',
        'zipcode',
        'address',
        'memo',
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'sex' => 'boolean', 
    ];

    public function memberAddresses()
    {
        return $this->hasMany(MemberAddress::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    


}
