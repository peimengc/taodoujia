<?php


namespace App\Services;


use App\Models\TbkAuthorize;

class TbkAuthorizeService
{

    /**
     * 获取所有
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
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