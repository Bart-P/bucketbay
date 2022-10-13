<?php

namespace App\Services;

use App\Models\OrderObject;
use Illuminate\Support\Collection;

class CartService
{
    private const CART = 'shopping-cart';
    private const CART_PRODUCTS = self::CART . '.products';
    private const CART_ADDRESS = self::CART . '.delivery-address-id';
    private const CART_ORDER_OBJECTS = self::CART . '.order-objects';

    public function getProducts(): Collection
    {
        return session(self::CART_PRODUCTS) ? session(self::CART_PRODUCTS) : collect([]);
    }

    public function addProduct(int $id): void
    {
        $cartProducts = session(self::CART_PRODUCTS);
        if ($cartProducts) {
            if (!$this->productIdIsSet($id)) {
                session()->put(self::CART_PRODUCTS, collect($cartProducts)->put($id, 1));
            }
        } else {
            session()->put(self::CART_PRODUCTS, collect([])->put($id, 1));
        }

        if (!$this->getOrderObjects()->contains('productId', $id)) {
            $this->addOrderObject($this->createEmptyOrderObject($id));
        }
    }

    public function productIdIsSet(int $id): bool
    {
        return collect(session(self::CART_PRODUCTS))->has($id);
    }

    public function getQuantityInCart(int $productId): int
    {
        $quantityInCart = 0;
        $currentOrderObjects = $this->getOrderObjects();
        foreach ($currentOrderObjects as $order) {
            if ($order['productId'] === $productId) {
                $quantityInCart += $order['quantity'];
            }
        }

        return $quantityInCart;
    }

    public function removeProductFromCart(int $productId): void
    {
        $orderObjects = collect($this->getOrderObjects());
        $keysToRemove = [];

        foreach ($orderObjects as $key => $order) {
            if ($order['productId'] === $productId) {
                $orderObjects = $orderObjects->forget($key);
            }
        }

        $this->removeProduct($productId);
        session()->put(self::CART_ORDER_OBJECTS, $orderObjects->forget($keysToRemove));
    }

    public function removeProduct($id): void
    {
        $productsInCart = collect(session(self::CART_PRODUCTS));
        session()->put(self::CART_PRODUCTS, $productsInCart->forget($id));
    }

    public function addAddressId(int $id): void
    {
        session()->put(self::CART_ADDRESS, $id);
    }

    public function removeAddressId(int $id): void
    {
        session()->forget(self::CART_ADDRESS);
    }

    public function getAddressId(): ?int
    {
        return $this->addressIsSet() ? session(self::CART_ADDRESS) : null;
    }

    public function addressIsSet(): bool
    {
        return session(self::CART_ADDRESS) != null;
    }

    public function addOrderObject(OrderObject $orderObject): void
    {
        $orderObjectsCollection = collect(session(self::CART_ORDER_OBJECTS));
        $orderObjectsCollection->add($orderObject);
        session()->put(self::CART_ORDER_OBJECTS, $orderObjectsCollection);
    }

    public function createEmptyOrderObject(int $productId): OrderObject
    {
        return new OrderObject(['productId' => $productId, 'grafics' => [], 'quantity' => 1]);
    }

    public function createOrderObject(int $productId, array $grafics, int $quantity): OrderObject
    {
        return new OrderObject(['productId' => $productId, 'grafics' => $grafics, 'quantity' => $quantity]);
    }

    public function updateOrderObjectQuantity($key, $quantity): void
    {
        $orderObjectsInCart = collect($this->getOrderObjects());
        $objectToUpdate = collect($orderObjectsInCart->get($key));
        $objectToUpdate->put('quantity', $quantity);
        $orderObjectsInCart->put($key, $objectToUpdate);

        session()->put(self::CART_ORDER_OBJECTS, $orderObjectsInCart);
    }

    public function getOrderObjects(): Collection
    {
        $orderObjectsCollection = collect(session(self::CART_ORDER_OBJECTS));
        return $orderObjectsCollection ? : collect([]);
    }

    public function removeOrderObject(int $key): void
    {
        $orderObjectsCollection = collect(session(self::CART_ORDER_OBJECTS));
        $orderObjectsCollection->forget($key);
        session()->put(self::CART_ORDER_OBJECTS, $orderObjectsCollection);
    }

    public function setGraficForOrderObject(int $orderObjectKey, int $graficId): void
    {
        $orderObjects = $this->getOrderObjects();
        if ($orderObjects->has($orderObjectKey)) {
            $orderObject = collect($orderObjects->get($orderObjectKey));
            $grafics = $orderObject['grafics'];
            if (count($grafics) < 2) {
                $grafics[] = $graficId;
                $orderObject->put('grafics', $grafics);
                $this->updateOrderObject($orderObjectKey, new OrderObject($orderObject->toArray()));
            }
        }
    }

    public function removeGraficFromOrderObject(int $orderObjectKey, int $graficArrayKey): void
    {
        $orderObjects = $this->getOrderObjects();
        if ($orderObjects->has($orderObjectKey)) {
            $orderObject = collect($orderObjects->get($orderObjectKey));
            $grafics = $orderObject['grafics'];
            if (count($grafics) < 3) {
                if ($graficArrayKey === 0) {
                    array_shift($grafics);
                }
                if ($graficArrayKey === 1) {
                    array_pop($grafics);
                }
                $orderObject->put('grafics', $grafics);
                $this->updateOrderObject($orderObjectKey, new OrderObject($orderObject->toArray()));
            }
        }
    }

    public function removeGraficFromAllOrderObjects(int $graficId): void
    {
        $orderObjectsInCart = $this->getOrderObjects()->each(function ($orderObject) use ($graficId) {
            if ($orderObject['grafics']) {
                $newGrafics = [];
                foreach ($orderObject['grafics'] as $currentGraficId) {
                    if ($currentGraficId !== $graficId) {
                        $newGrafics[] = $currentGraficId;
                    }
                }
                $orderObject['grafics'] = $newGrafics;
            }
        });

        session()->put(self::CART_ORDER_OBJECTS, $orderObjectsInCart);
    }

    public function updateOrderObject(int $orderObjectKey, OrderObject $newOrderObject): void
    {
        $orderObjects = collect(session(self::CART_ORDER_OBJECTS));
        $orderObjects->put($orderObjectKey, $newOrderObject);
        session()->put(self::CART_ORDER_OBJECTS, $orderObjects);
    }


}