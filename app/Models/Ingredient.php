<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'threshold',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
