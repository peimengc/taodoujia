<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbkAuthorize extends Model
{
    protected $fillable = [
        'active',
        'tb_user_id',
        'tb_user_nick',
        'access_token',
        'expire_time',
        'auth_json',
    ];

    protected $casts = [
        'active' => 'boolean',
        'auth_json' => 'json'
    ];

    public function tbkOrders()
    {
        return $this->hasMany(TbkOrder::class, 'authorize_id');
    }
}
