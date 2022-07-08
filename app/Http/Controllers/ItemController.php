<?php

namespace App\Http\Controllers;

use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        return view('index', ['items' => Item::all()]);
    }
}
