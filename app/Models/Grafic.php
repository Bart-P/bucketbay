<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(array|null $getGraficIdsInCartArray)
 */
class Grafic extends Model
{
    use HasFactory;

    protected $fillable = ['user_id',
                           'name',
                           'file',
                           'type',
                           'size_in_mb',];

    public static function search($search)
    {
        $query = static::whereBelongsTo(auth()->user());
        return empty($search) ? $query : $query->where('name', 'like', '%' . $search . '%');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}