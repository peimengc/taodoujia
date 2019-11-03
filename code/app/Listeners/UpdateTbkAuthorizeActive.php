<?php

namespace App\Listeners;

use App\Events\TbkAuthorizeExpired;
use App\Models\TbkAuthorize;
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
        TbkAuthorize::query()
            ->where('access_token', $event->token)
            ->update([
                'active' => false
            ]);
    }
}
