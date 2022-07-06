<?php

namespace App\Http\Controllers;

use App\Models\Grafic;

class GraficController extends Controller
{
  public function grafics()
  {
    return view('grafics.index');
  }
}
