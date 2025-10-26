<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

