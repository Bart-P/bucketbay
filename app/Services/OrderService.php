<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;

class OrderService
{
    public function saveOrder(int $deliveryAddressId, int $printPriceInCent, int $shipmentPriceInCent)
    {
        $order = new Order;

        $order['user_id'] = auth()->user()->id;
        $order['delivery_address_id'] = $deliveryAddressId;
        $order['print_price_in_cent'] = $printPriceInCent;
        $order['shipment_price_in_cent'] = $shipmentPriceInCent;
        $order['status'] = OrderStatusEnum::OPEN->value;

        $order->save();
    }
}