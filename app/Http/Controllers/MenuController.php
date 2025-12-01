<?php

namespace App\Http\Controllers;

use App\Models\Category;

class MenuController extends Controller
{
    public function menu()
    {
        
        $categories = Category::with('foods')->get();

        return response()->json($categories, 200);
    }
}
