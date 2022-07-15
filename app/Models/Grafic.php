<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grafic extends Model
{
    use HasFactory;

    public static function search($search)
    {
        $query = static::query()->whereBelongsTo(auth()->user());
        return empty($search) ? $query
        : $query->where('name', 'like', '%' . $search . '%');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // TODO data upload via spatie laravel media package?
}
