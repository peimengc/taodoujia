<?php


namespace App\Services;


use App\Models\DouAccount;

class DouAccountService
{
    /**
     * 获取所有adzone_id做key  id做value
     * [
     *  adzone_id => id
     * ]
     * @return array
     */
    public function getAllAdzoneIdKeyIsId()
    {
        return DouAccount::query()
            ->pluck('id', 'adzone_id')
            ->toArray();
    }

}