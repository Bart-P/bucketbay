<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{

    public function saveOrder(Order $order)
    {
        $order->save();
    }
}