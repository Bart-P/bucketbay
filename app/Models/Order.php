<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static join(string $string, string $string1, string $string2, string $string3)
 * @method static where(mixed $searchField, string $string, string $string1)
 */
class Order extends Model
{
    use HasFactory;

    public int $user_id;
    public string $status;
    public int $delivery_address_id;
    public int $print_price_in_cent;
    public int $shipment_price_in_cent;

    protected $fillable = [
        'user_id',
        'delivery_address_id',
        'print_price_in_cent',
        'shipment_price_in_cent',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderObjects(): HasMany
    {
        return $this->hasMany(OrderObject::class);
    }

    public function deliveryAddress(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}