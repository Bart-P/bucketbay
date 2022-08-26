<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(\Illuminate\Support\Collection|null $getProducts)
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'items';
}