<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderObject extends Model
{
    use HasFactory;

    public int $order_id;
    public int $product_id;
    public int $product_price;
    public array $grafics;
    public int $quantity;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_price',
        'grafics',
        'quantity',
    ];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function grafics(): HasMany
    {
        return $this->hasMany(Grafic::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}