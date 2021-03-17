<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
     * @param Request             $request
     * @param MenuCategoryService $categoryService
     * @return \App\Http\Resources\MenuCategoryResource
     */
    public function getAll(Request $request, MenuCategoryService $categoryService)
    {
       return $categoryService->getByLocationId($request->consumer->location->id);
    }
}
