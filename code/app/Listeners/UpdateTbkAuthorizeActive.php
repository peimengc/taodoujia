<?php

namespace App\Listeners;

use App\Events\TbkAuthorizeExpired;
use App\Models\TbkAuthorize;
use App\Services\TbkAuthorizeService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateTbkAuthorizeActive
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param TbkAuthorizeExpired $event
     * @return void
     */
    public function handle(TbkAuthorizeExpired $event)
    {
        //access_token失效
        app(TbkAuthorizeService::class)->accessTokenExpiredByToken($event->token);
    }
}
