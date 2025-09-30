<?php

namespace App\Http\Controllers;

use App\Models\Meal;

class HomeController extends Controller
{
    public function index()
    {
        // fetch exactly 4 featured plans (choose your logic)
        $meals = Meal::with('category')->take(4)->get();
        return view('pages.home', compact('meals'));
    }
}
