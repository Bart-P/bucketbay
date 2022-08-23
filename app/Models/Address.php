<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function search($search)
    {
        static::$searchTerm = $search;
        $query = static::whereBelongsTo(auth()->user());

        return empty($search)
            ? $query
            : $query
                ->where(function ($q) {
                 $q->where('name1', 'like', '%' . static::$searchTerm . '%')
                    ->orwhere('name2', 'like', '%' . static::$searchTerm . '%')
                    ->orwhere('name3', 'like', '%' . static::$searchTerm . '%');
                });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
