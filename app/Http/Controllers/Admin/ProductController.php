<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    /**
     * Show the add product form.
     */
    public function create()
    {
        $brands = \App\Models\Brand::orderBy('name')->get();
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.addproduct', compact('brands', 'categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation using Validator facade
        $validator = Validator::make($request->all(), [
            // Required core fields
            'name' => 'required|string|max:255',
            'seller_id' => 'nullable|integer|exists:users,id',
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric',
            // main_category is required (marked with *) in the form
            'main_category' => 'required|integer|exists:categories,id',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'short_description' => 'nullable|string',
            // description is required
            'description' => 'required|string',
            'barcode' => 'nullable|string|max:255',
            // refund note becomes required only when refundable toggle is on
            'refund_note' => 'nullable|required_if:refundable,1|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            // shipping_cost is required when flat_rate is selected
            'shipping_cost' => 'required_if:flat_rate,1|numeric',
            'shipping_days' => 'required|integer|min:0',
            'low_stock_quantity' => 'nullable|integer',
            // discount fields: optional (Price & Stock section)
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:flat,percent',
            'tags' => 'nullable|string',
            // Flash deal fields: ONLY required when flash deal toggle is enabled
            'flash_start' => 'nullable|required_if:flash_deal_enabled,1|date',
            'flash_end' => 'nullable|required_if:flash_deal_enabled,1|date',
            'flash_discount' => 'nullable|required_if:flash_deal_enabled,1|numeric',
            'flash_discount_type' => 'nullable|required_if:flash_deal_enabled,1|in:flat,percent',
            'published_at' => 'nullable|date',
            'cash_on_delivery' => 'nullable|boolean',
            'free_shipping' => 'nullable|boolean',
            'flat_rate' => 'nullable|boolean',
            'warranty_enabled' => 'nullable|boolean',
            'warranty_duration' => 'nullable|string',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // gallery images marked required in the form (at least one)
            'gallery_images' => 'required|array|min:1',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // colours field is required (at least one)
            'colours' => 'required|array|min:1',
            // Variants: require at least one variant and all per-variant fields
            'variants' => 'required|array|min:1',
            'variants.*.sku' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            // stock visibility is optional
            'stock_visibility' => 'nullable|in:quantity,text_only,hidden',
        ]);

        // 2. Check validation
        if ($validator->fails()) {
            // Check if flash deal is enabled but required fields are missing
            if ($request->boolean('flash_deal_enabled')) {
                if (!$request->filled('flash_start') || !$request->filled('flash_end') || !$request->filled('flash_discount')) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error', 'Flash Deal is enabled. Please provide Start Date, End Date, and Discount amount.');
                }
            }
            
            // Return with validation errors (will be displayed as toast messages)
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fill all required fields correctly.');
        }

        DB::beginTransaction();
        try {
            // 3. Prepare product data safely
            $productData = [
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')) ?: Str::random(8),
                'category_id' => $request->input('main_category'),
                'brand_id' => $request->input('brand_id'),
                'short_description' => $request->input('short_description'),
                'description' => $request->input('description'),
                'barcode' => $request->input('barcode'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
                'shipping_cost' => $request->input('shipping_cost'),
                'shipping_days' => $request->input('shipping_days'),
                'low_stock_quantity' => $request->input('low_stock_quantity'),
                'stock_visibility' => $request->input('stock_visibility', 'quantity'),
                'discount' => $request->input('discount'),
                'discount_type' => $request->input('discount_type'),
                'seller_id' => $request->input('seller_id') ?: (auth()->check() ? auth()->id() : null),
                'unit' => $request->input('unit'),
                'weight' => $request->input('weight'),
                'refund_note' => $request->input('refund_note'),
                'flash_deal' => $request->boolean('flash_deal_enabled'),
                'flash_start' => $request->input('flash_start') ? Carbon::parse($request->input('flash_start')) : null,
                'flash_end' => $request->input('flash_end') ? Carbon::parse($request->input('flash_end')) : null,
                'flash_discount' => $request->input('flash_discount'),
                'flash_discount_type' => $request->input('flash_discount_type'),
                'published_at' => $request->input('published_at') ? Carbon::parse($request->input('published_at')) : null,
                'cash_on_delivery' => $request->boolean('cash_on_delivery'),
                'free_shipping' => $request->boolean('free_shipping'),
                'flat_rate' => $request->boolean('flat_rate'),
                'warranty_duration' => $request->input('warranty_duration'),
                'warranty_enabled' => $request->boolean('warranty_enabled'),
                'refundable' => $request->boolean('refundable'),
                'featured' => $request->boolean('featured'),
                'todays_deal' => $request->boolean('todays_deal'),
                'is_visible' => $request->has('is_visible') ? $request->boolean('is_visible') : true,
            ];

            $product = Product::create($productData);

            // 4. Save thumbnail
            if ($request->hasFile('thumbnail_image')) {
                $file = $request->file('thumbnail_image');
                if ($file->isValid()) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_thumbnail' => true,
                        'position' => 0,
                    ]);
                }
            }

            // 5. Save gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $idx => $f) {
                    if (!$f || !$f->isValid()) continue;
                    $path = $f->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_thumbnail' => false,
                        'position' => $idx + 1,
                    ]);
                }
            }

            // 6. Save tags
            $tagsInput = $request->input('tags');
            if ($tagsInput) {
                $parts = array_filter(array_map('trim', explode(',', $tagsInput)));
                foreach ($parts as $t) {
                    ProductTag::create(['product_id' => $product->id, 'tag' => $t]);
                }
            }

            // 7. Save variants (your existing logic)
            $this->saveVariants($product, $request->input('variants', []));

            DB::commit();

            flash()->success('Product created successfully');
            return redirect()->route('admin.productslist');

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to save product: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Handle product variants logic (kept your original logic cleanly)
     */
    private function saveVariants(Product $product, array $variants)
    {
        if (empty($variants)) return;

        foreach ($variants as $v) {
            $sku = isset($v['sku']) && $v['sku'] !== '' ? $v['sku'] : Str::upper(Str::random(8));
            $basePrice = isset($v['price']) && $v['price'] !== '' ? (float)$v['price'] : 0;
            $stock = isset($v['stock']) && $v['stock'] !== '' ? intval($v['stock']) : 0;

            $values = isset($v['values']) && is_array($v['values']) ? $v['values'] : [];
            $colourEntries = [];
            $otherAttrMappings = [];
            foreach ($values as $attrId => $attrValueId) {
                if ($attrId === 'colour') {
                    $colourEntries = is_array($attrValueId) ? $attrValueId : [$attrValueId];
                } else {
                    $otherAttrMappings[$attrId] = $attrValueId;
                }
            }

            $normalizeColour = function ($cv) {
                $value = $code = null;
                $price = null;
                if (is_array($cv)) {
                    $value = $cv['value'] ?? $cv['name'] ?? ($cv['color'] ?? null);
                    foreach (['code','hex','color_code','colour_code'] as $k) {
                        if (!empty($cv[$k])) { $code = $cv[$k]; break; }
                    }
                    foreach (['price','price_delta','extra_price','cost','amount'] as $k) {
                        if (isset($cv[$k])) { $price = $cv[$k]; break; }
                    }
                } elseif (is_string($cv)) {
                    if (strpos($cv, '|') !== false) {
                        [$val, $p] = explode('|', $cv, 2);
                        $value = trim($val);
                        $price = is_numeric($p) ? (float)$p : null;
                    } else {
                        $value = $cv;
                    }
                }
                if ($value && preg_match('/(?P<hex>#(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6}))/i', $value, $m)) {
                    $code = $m['hex'];
                    $value = trim(str_replace($m['hex'], '', $value));
                }
                return [trim((string)($value ?? '')), $price !== null ? (float)$price : null, $code ? trim((string)$code) : null];
            };

            $anyColourHasPrice = false;
            foreach ($colourEntries as $ce) {
                [$_, $pd, $_c] = $normalizeColour($ce);
                if ($pd !== null) { $anyColourHasPrice = true; break; }
            }

            if (!empty($colourEntries) && $anyColourHasPrice) {
                foreach ($colourEntries as $ce) {
                    [$colourVal, $priceDelta, $colourCode] = $normalizeColour($ce);
                    $finalPrice = $basePrice + ($priceDelta ?: 0);
                    $variantModel = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => $sku . '-' . Str::upper(substr(preg_replace('/[^A-Z0-9]/', '', (string)$colourVal), 0, 6)) . Str::upper(Str::random(3)),
                        'price' => $finalPrice,
                        'stock' => $stock,
                        'color' => $colourVal ?: null,
                        'color_code' => $colourCode ?: null,
                    ]);

                    foreach ($otherAttrMappings as $oaId => $oaValue) {
                        if (is_numeric($oaId)) {
                            $valueId = is_array($oaValue) ? (int)($oaValue[0] ?? 0) : (int)$oaValue;
                            if ($valueId <= 0) continue;
                            ProductVariantValue::create([
                                'variant_id' => $variantModel->id,
                                'attribute_id' => intval($oaId),
                                'attribute_value_id' => $valueId,
                            ]);
                        }
                    }
                }
            } else {
                $variantModel = ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $sku,
                    'price' => $basePrice,
                    'stock' => $stock,
                ]);

                if (!empty($colourEntries)) {
                    [$firstColourVal, $_, $firstColourCode] = $normalizeColour($colourEntries[0]);
                    $variantModel->update([
                        'color' => $firstColourVal ?: null,
                        'color_code' => $firstColourCode ?: null,
                    ]);
                }

                foreach ($otherAttrMappings as $attrId => $attrValueId) {
                    if (is_numeric($attrId)) {
                        $valueId = is_array($attrValueId) ? (int)($attrValueId[0] ?? 0) : (int)$attrValueId;
                        if ($valueId <= 0) continue;
                        ProductVariantValue::create([
                            'variant_id' => $variantModel->id,
                            'attribute_id' => intval($attrId),
                            'attribute_value_id' => $valueId,
                        ]);
                    }
                }
            }
        }
    }
}
