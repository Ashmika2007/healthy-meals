<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meal;

class MealApiController extends Controller
{
    public function index()
    {
        return response()->json(Meal::with('category')->get());
    }

    public function show($id)
    {
        return response()->json(Meal::with('category')->findOrFail($id));
    }
}
