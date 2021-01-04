<?php

function create($class, $attributes = [], $times = null)
{
    return factory($class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}

function makeFakeModels($models)
{
    foreach ($models as $model) {

    }
}


function someExample(){
    factory(\App\Order::class)->make([]);
    factory(\App\Order::class)->make();
    factory(\App\Order::class)->make();
}
