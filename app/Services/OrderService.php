<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderObject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function saveOrder(int $deliveryAddressId, int $printPriceInCent, int $shipmentPriceInCent, Collection $orderObjects): bool
    {
        if (!$deliveryAddressId || count($orderObjects) < 1) {
            return false;
        }

        $order = new Order;

        $order['user_id'] = auth()->user()->id;
        $order['delivery_address_id'] = $deliveryAddressId;
        $order['print_price_in_cent'] = $printPriceInCent;
        $order['shipment_price_in_cent'] = $shipmentPriceInCent;
        $order['status'] = OrderStatusEnum::OPEN->value;

        try {
            DB::transaction(function () use ($orderObjects, $order) {
                $order->save();
                $this->saveOrderObjects($order['id'], $orderObjects);
                session()->forget('shopping-cart');
            });

        }
        catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function saveOrderObjects(int $orderId, Collection $orderObjects): void
    {
        $orderObjects->each(function ($orderObject) use ($orderId) {
            $newOrderObject = new OrderObject(
                [
                    'order_id'      => $orderId,
                    'product_id'    => $orderObject['product_id'],
                    'product_price' => $orderObject['product_price'],
                    'grafics'       => json_encode($orderObject['grafics']),
                    'quantity'      => $orderObject['quantity'],
                ]
            );
            $newOrderObject->save();
        });
    }
}