<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
	// Show all brands
	public function index()
	{
		$brands = Brand::orderBy('id', 'desc')->get();
		return view('admin.brands', compact('brands'));
	}

	// Store a new brand
	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		// Check for duplicate name and show an error toast (or JSON error for AJAX)
		if (Brand::where('name', $validated['name'])->exists()) {
			if ($request->ajax() || $request->wantsJson()) {
				return response()->json(['success' => false, 'message' => 'Brand name already exists.'], 422);
			}
			return redirect()->route('admin.brands')->with('error', 'Brand name already exists!');
		}

		$brand = new Brand();
		$brand->name = $validated['name'];
		$brand->status = 1; // Default to active

		if ($request->hasFile('image')) {
			$imageName = time().'.'.$request->image->extension();
			$request->image->move(public_path('assetsbackend/imgs/brands'), $imageName);
			$brand->image = 'assetsbackend/imgs/brands/' . $imageName;
		}

		$brand->save();

		return redirect()->route('admin.brands')->with('success', 'Brand added successfully!');
	}

	// Update an existing brand
	public function update(Request $request, Brand $brand)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		// If another brand already uses this name, show an error toast (or JSON error for AJAX)
		if (Brand::where('name', $validated['name'])->where('id', '!=', $brand->id)->exists()) {
			if ($request->ajax() || $request->wantsJson()) {
				return response()->json(['success' => false, 'message' => 'Brand name already exists.'], 422);
			}
			return redirect()->route('admin.brands')->with('error', 'Brand name already exists!');
		}

		$brand->name = $validated['name'];

		if ($request->hasFile('image')) {
			// Delete old image if exists
			if ($brand->image && file_exists(public_path($brand->image))) {
				@unlink(public_path($brand->image));
			}
			$imageName = time().'.'.$request->image->extension();
			$request->image->move(public_path('assetsbackend/imgs/brands'), $imageName);
			$brand->image = 'assetsbackend/imgs/brands/' . $imageName;
		}

		$brand->save();

		if ($request->ajax() || $request->wantsJson()) {
			return response()->json(['success' => true, 'message' => 'Brand updated successfully.', 'brand' => $brand]);
		}
		return redirect()->route('admin.brands')->with('success', 'Brand updated successfully!');
	}

	// Delete a brand
	public function destroy(Brand $brand, Request $request)
	{
		// Optionally, delete image file from storage
		if ($brand->image && file_exists(public_path($brand->image))) {
			@unlink(public_path($brand->image));
		}
		$brand->delete();
		if ($request->ajax() || $request->wantsJson()) {
			return response()->json(['success' => true, 'message' => 'Brand deleted successfully.']);
		}
		return redirect()->route('admin.brands')->with('success', 'Brand deleted successfully!');
	}
}
