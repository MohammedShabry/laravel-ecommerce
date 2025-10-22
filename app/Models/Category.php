<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'slug',
        'status',
        'order_level',
        'image',
        'featured',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);

            // Optional: automatically calculate order level
            if ($category->parent_id) {
                $parent = Category::find($category->parent_id);
                $category->order_level = $parent ? $parent->order_level + 1 : 0;
            } else {
                $category->order_level = 0;
            }
        });
    }

    // Parent relationship
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Children relationship
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }
}
