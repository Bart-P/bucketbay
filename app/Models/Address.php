<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;

  protected $fillable = [
    'name1',
    'name2',
    'name3',
    'street',
    'street_nr',
    'city',
    'city_code',
    'country',
    'address_info'
  ];

  public static function search($search)
  {
    return empty($search) ? static::query()
      : static::query()
      ->where('name1', 'like', '%' . $search . '%')
      ->orWhere('name2', 'like', '%' . $search . '%')
      ->orWhere('name3', 'like', '%' . $search . '%');
  }
}
