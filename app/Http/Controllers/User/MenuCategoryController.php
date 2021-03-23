<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ConsumerService;
use App\Services\MenuCategoryService;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.food_order.index');
    }

    /**
     * Get all categories.
     *
     * @param MenuCategoryService $categoryService
     * @param ConsumerService     $consumerService
     * @return \App\Http\Resources\MenuCategoryResource
     */
    public function getAll(MenuCategoryService $categoryService, ConsumerService $consumerService)
    {
       return $categoryService->getByLocationId(optional($consumerService->getCurrentConsumer()->location)->id);
    }
}
