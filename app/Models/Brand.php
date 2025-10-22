<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'status',
    ];

    // Optional: Mutator to auto-generate slug when creating/updating
    public static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            $brand->slug = \Str::slug($brand->name);
        });

        static::updating(function ($brand) {
            $brand->slug = \Str::slug($brand->name);
        });
    }
}
