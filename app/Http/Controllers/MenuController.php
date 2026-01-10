<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MenuController extends Controller
{
   public function menu(){
    $categories = Category::with(['foods' => function($query) {
        $query->where('is_active', true);
    }])->get();


    foreach ($categories as $category) {
        foreach ($category->foods as $food) {
            if ($food->photo_url) {
                $food->photo_url = asset('storage/foods/' . $food->photo_url);
            }
        }
    }

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
        'is_active' => 'boolean',
    ]);

    $food = new Food;
    $food->category_id = $request->category_id;
    $food->name = $request->name;
    $food->description = $request->description;
    $food->price = $request->price;
    $food->is_vegetarian = $request->is_vegetarian;
    $food->is_active = $request->is_active ?? true; 
    $food->save();   
        if ($request->hasFile('photo')) {
            $this->uploadPhoto($food, $request->file('photo'));
    }
    return response()->json(['message' => 'Food created','food' => $food]);
}
    public function updateCategory(Request $request, $id){
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    $category->name = $request->name;
    $category->description = $request->description;
    $category->save();

    return response()->json(['message' => 'Category updated successfully','category' => $category]);
}

    public function updateFood(Request $request, $id)
{
    $food = Food::find($id);

    if (!$food) {
        return response()->json(['message' => 'Food not found'], 404);
    }

    $food->name = $request->name;
    $food->price = $request->price;
    $food->description = $request->description;
    $food->category_id = $request->category_id;
    $food->is_active = $request->is_active ?? true; 

     if ($request->hasFile('photo')) {
        if ($food->photo_url && Storage::disk('public')->exists('foods/' . $food->photo_url)) {
            Storage::disk('public')->delete('foods/' . $food->photo_url);
        }
        
        $this->uploadPhoto($food, $request->file('photo'));
    }

    $food->save();
    return response()->json([
        'message' => 'Food updated successfully',
        'food' => $food
    ]);
}

    public function deleteCategory($id){
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
}


    public function deleteFood($id){
        $food = Food::find($id);

        if (!$food) {
            return response()->json(['message' => 'Food not found'], 404);
        }

        if ($food->photo_url && Storage::disk('public')->exists('foods/' . $food->photo_url)) {
        Storage::disk('public')->delete('foods/' . $food->photo_url);
    }

        $food->delete();

        return response()->json(['message' => 'Food deleted successfully']);
}


private function uploadPhoto(Food $food, $photoFile)
{
    $filename = 'food_' . Str::slug($food->name) . '_' . $food->id . '_' . time() . '.' . 
                $photoFile->getClientOriginalExtension();
    
    $photoFile->storeAs('foods', $filename, 'public');
    

    $food->photo_url = $filename;
    $food->save();

    return $filename;
}

}

