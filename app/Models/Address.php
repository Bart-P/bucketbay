<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    private static string $searchTerm;

    protected $fillable = [
        'name1',
        'name2',
        'name3',
        'street',
        'street_nr',
        'city',
        'city_code',
        'country',
        'address_info',
        'user_id'
    ];

    public function setSearchTerm($searchTerm)
    {
        $this->searchTerm = $searchTerm;
    }

    public static function search($search)
    {
        Address::$searchTerm = $search;
        $query = static::query()->whereBelongsTo(auth()->user());

        return empty($search)
            ? $query
            : $query
                ->where(function ($q) {
                    $q->where('name1', 'like', '%' . Address::$searchTerm . '%')
                    ->orwhere('name2', 'like', '%' . Address::$searchTerm . '%')
                    ->orwhere('name3', 'like', '%' . Address::$searchTerm . '%');
                });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
