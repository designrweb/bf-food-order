<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ConsumerCompose
{
    public function compose(View $view)
    {
        $consumer = null;

        if (request()->user() && request()->user()->consumer) {
            $consumer = request()->user()->consumer;
        }

        $view->with('consumer', $consumer);
    }
}
