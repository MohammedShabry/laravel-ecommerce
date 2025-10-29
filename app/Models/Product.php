<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'seller_id',
        'unit',
        'weight',
        'short_description',
        'description',
        'barcode',
        'refundable',
        'refund_note',
        'featured',
        'todays_deal',
        'flash_deal',
        'flash_start',
        'flash_end',
        'flash_discount',
        'flash_discount_type',
        'discount',
        'discount_type',
        'low_stock_quantity',
        'stock_visibility',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'cash_on_delivery',
        'free_shipping',
        'flat_rate',
        'shipping_cost',
        'shipping_days',
        'warranty_enabled',
        'warranty_duration',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'refundable' => 'boolean',
        'featured' => 'boolean',
        'todays_deal' => 'boolean',
        'flash_deal' => 'boolean',
        'flash_start' => 'datetime',
        'flash_end' => 'datetime',
        'flash_discount' => 'decimal:2',
        'discount' => 'decimal:2',
        'published_at' => 'datetime',
        'cash_on_delivery' => 'boolean',
        'free_shipping' => 'boolean',
        'flat_rate' => 'boolean',
        'shipping_cost' => 'decimal:2',
        'warranty_enabled' => 'boolean',
        'low_stock_quantity' => 'integer',
        'shipping_days' => 'integer',
    ];

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Convenience relation to get all variant attribute values for this product.
     * Uses hasManyThrough from Product -> ProductVariant -> ProductVariantValue
     */
    public function variantValues()
    {
        return $this->hasManyThrough(
            ProductVariantValue::class,
            ProductVariant::class,
            'product_id', // Foreign key on product_variants table
            'variant_id', // Foreign key on product_variant_values table
            'id', // Local key on products table
            'id'  // Local key on product_variants table
        );
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function tags()
    {
        return $this->hasMany(ProductTag::class);
    }
}
