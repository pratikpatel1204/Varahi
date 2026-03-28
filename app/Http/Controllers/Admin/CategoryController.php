<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category_list()
    {
        $categories = Category::latest()->get();
        return view('admin.category.list', compact('categories'));
    }

    public function category_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        Category::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully'
        ]);
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $category = Category::find($request->id);

        $category->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully'
        ]);
    }
}
