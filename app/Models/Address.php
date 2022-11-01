<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static whereBelongsTo(Authenticatable|null $user)
 * @method static create(array $form_fields)
 * @method static find(int|null $getAddressId)
 */
class Address extends Model
{
    use HasFactory;

    private static string $searchTerm;

    protected $fillable = [
        'user_id',
        'name1',
        'name2',
        'name3',
        'street',
        'street_nr',
        'city',
        'city_code',
        'country',
        'address_info',
    ];

    public static function search($search): Address|Builder
    {
        static::$searchTerm = $search;
        $query = static::whereBelongsTo(auth()->user());

        return empty($search)
            ? $query
            : $query->where(function ($q) {
                $q->where('name1', 'like', '%' . static::$searchTerm . '%')
                  ->orwhere('name2', 'like', '%' . static::$searchTerm . '%')
                  ->orwhere('name3', 'like', '%' . static::$searchTerm . '%');
            });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);

    }
}