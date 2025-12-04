<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function menu(){
        
        $categories = Category::with('foods')->get();

        return response()->json($categories, 200);
    }

    public function addCategory(Request $request){
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();   

        return response()->json(['message' => 'Category created','category' => $category]);
}

    public function addFood(Request $request){
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:150',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'is_vegetarian' => 'boolean',
    ]);

    $food = new Food;
    $food->category_id = $request->category_id;
    $food->name = $request->name;
    $food->description = $request->description;
    $food->price = $request->price;
    $food->is_vegetarian = $request->is_vegetarian;
    $food->save();   

    return response()->json(['message' => 'Food created','food' => $food]);
}
    public function update(Request $request, $id){
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    $category->name = $request->name;
    $category->description = $request->description;
    $category->save();

    return response()->json(['message' => 'Category updated successfully','category' => $category]);
}

    public function update(Request $request, $id)
{
    $food = Food::find($id);

    if (!$food) {
        return response()->json(['message' => 'Food not found'], 404);
    }

    $food->name = $request->name;
    $food->price = $request->price;
    $food->description = $request->description;
    $food->category_id = $request->category_id;
    $food->save();

    return response()->json([
        'message' => 'Food updated successfully',
        'food' => $food
    ]);
}


}

