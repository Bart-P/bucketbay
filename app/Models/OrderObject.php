<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderObject extends Model
{
    use HasFactory;

    public int $productId;
    public array $grafics;
    public int $quantity;

    protected $fillable = ['productId',
                           'grafics',
                           'quantity'];
}