<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    // Store a newly created category in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        try {
            Category::create($validated);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'categories_slug_unique')) {
                return redirect()->back()->withInput()->with('error', 'Category slug already exists.');
            }
            throw $e;
        }
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    // Update an existing category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // prevent selecting self as parent
            'parent_id' => ['nullable', 'exists:categories,id', 'not_in:' . $id],
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle image upload and deletion of old image
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        // Update slug and check uniqueness
        $slug = Str::slug($validated['name']);
        $exists = Category::where('slug', $slug)->where('id', '!=', $category->id)->exists();
        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Category slug already exists.');
        }

        $category->name = $validated['name'];
        $category->description = $validated['description'] ?? $category->description;
        $category->parent_id = $validated['parent_id'] ?? null;
        if (isset($validated['image'])) {
            $category->image = $validated['image'];
        }
        $category->slug = $slug;

        // Recalculate order_level
        if ($category->parent_id) {
            $parent = Category::find($category->parent_id);
            $category->order_level = $parent ? $parent->order_level + 1 : 0;
        } else {
            $category->order_level = 0;
        }

        try {
            $category->save();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'categories_slug_unique')) {
                return redirect()->back()->withInput()->with('error', 'Category slug already exists.');
            }
            throw $e;
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // Optionally, delete the image from storage
        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }
        $category->delete();
        // If AJAX, return JSON, else redirect
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
