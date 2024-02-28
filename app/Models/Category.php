<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image'
    ];

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/category/' . $value)
        );
    }
}
