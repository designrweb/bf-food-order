<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ConsumerCompose
{
    public function compose(View $view)
    {
         $view->with('consumer', request()->consumer);
    }
}
