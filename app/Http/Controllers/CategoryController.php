<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        if (Category::where('name', $validated['name'])->exists()) {
            return back()->with([
                'message' => 'Another category name already exists with this name.',
                'operationSuccessful' => false,
            ]);
        }

        Category::create($validated);
        return back()->with([
            'message' => 'Category created successfully!',
            'operationSuccessful' => true,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        if (Category::where('name', $validated['name'])->where('id', '!=', $category->id)->exists()) {
            return back()->with([
                'message' => 'Another category name already exists with this name.',
                'operationSuccessful' => false,
            ]);
        }

        $category->update($validated);
        
        return back()->with([
            'message' => 'Category updated successfully!',
            'operationSuccessful' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with([
            'message' => 'Category deleted successfully!',
            'operationSuccessful' => true,
        ]);
    }
}
