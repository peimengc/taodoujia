<?php


namespace App\Services;


use App\Models\TbkAuthorize;

class TbkAuthorizeService
{
    public function getAll($columns = ['*'])
    {
        return TbkAuthorize::query()->get($columns);
    }

    /**
     * 获取id
     * @param $token
     * @return mixed
     */
    public function getIdByToken($token)
    {
        return TbkAuthorize::query()->where('access_token', $token)->value('id');
    }

    /**
     * 失效
     * @param $token
     */
    public function accessTokenExpiredByToken($token)
    {
        TbkAuthorize::query()
            ->where('access_token', $token)
            ->update([
                'active' => false
            ]);
    }
}