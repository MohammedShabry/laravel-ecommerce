<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Auth;

class AttributeController extends Controller
{
    /**
     * Show the attributes admin page.
     */
    public function index()
    {
        $userId = Auth::id();
        $attributes = Attribute::with('values')->where('user_id', $userId)->orderBy('id')->get();
        return view('admin.attributes', compact('attributes'));
    }

    /**
     * Return attributes as JSON (used by AJAX refresh).
     */
    public function data()
    {
        $userId = Auth::id();
        return response()->json(Attribute::with('values')->where('user_id', $userId)->orderBy('id')->get());
    }

    /**
     * Store a new attribute with values.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'nullable|array',
            'values.*' => 'required|string|max:255',
        ]);

    $userId = Auth::id();
    $attribute = Attribute::create(['name' => $data['name'], 'user_id' => $userId]);

        if (!empty($data['values'])) {
            $toCreate = array_map(fn($v) => ['value' => $v], $data['values']);
            $attribute->values()->createMany($toCreate);
        }

        return response()->json(['success' => true, 'attribute' => $attribute->load('values')]);
    }

    /**
     * Update an attribute and replace its values.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'nullable|array',
            'values.*' => 'required|string|max:255',
        ]);

        // ensure owner
        if ($attribute->user_id !== Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $attribute->update(['name' => $data['name']]);

        // replace values - simple approach: delete and recreate
        $attribute->values()->delete();
        if (!empty($data['values'])) {
            $toCreate = array_map(fn($v) => ['value' => $v], $data['values']);
            $attribute->values()->createMany($toCreate);
        }

        return response()->json(['success' => true, 'attribute' => $attribute->load('values')]);
    }

    /**
     * Remove the attribute and its values.
     */
    public function destroy(Attribute $attribute)
    {
        if ($attribute->user_id !== Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $attribute->values()->delete();
        $attribute->delete();
        return response()->json(['success' => true]);
    }
}
