<?php

namespace App\Services;

use App\Models\OrderObject;
use App\Models\Product;
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

    public function addProduct(int $id, int $priceInCent): void
    {
        $cartProducts = session(self::CART_PRODUCTS);
        if ($cartProducts) {
            if (!$this->productIdIsSet($id)) {
                session()->put(self::CART_PRODUCTS, collect($cartProducts)->put($id, 1));
            }
        } else {
            session()->put(self::CART_PRODUCTS, collect([])->put($id, 1));
        }

        if (!$this->getOrderObjects()->contains('product_id', $id)) {
            $this->addOrderObject($this->createEmptyOrderObject($id, $priceInCent));
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
            if ($order['product_id'] === $productId) {
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
            if ($order['product_id'] === $productId) {
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

    public function removeAddressId(): void
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

    public function createEmptyOrderObject(int $productId, int $priceInCent): OrderObject
    {
        return new OrderObject([
                                   'product_id'    => $productId,
                                   'product_price' => $priceInCent,
                                   'grafics'       => [],
                                   'quantity'      => 1,
                               ]);
    }

    public function createOrderObject(int $productId, int $priceInCent, array $grafics, int $quantity): OrderObject
    {
        return new OrderObject([
                                   'product_id'    => $productId,
                                   'product_price' => $priceInCent,
                                   'grafics'       => $grafics,
                                   'quantity'      => $quantity,
                               ]);
    }

    public function updateOrderObjectQuantity(int $key, int $quantity): void
    {
        $orderObjectsInCart = collect($this->getOrderObjects());

        $objectToUpdate = collect($orderObjectsInCart->get($key));
        $objectToUpdate->put('quantity', $quantity);
        $orderObjectsInCart->put($key, $objectToUpdate);
        session()->put(self::CART_ORDER_OBJECTS, $orderObjectsInCart);

        $currentProductInCart = 0;
        foreach ($orderObjectsInCart as $orderObject) {
            if ($objectToUpdate['product_id'] === $orderObject['product_id']) {
                $currentProductInCart += $orderObject['quantity'];
            }
        }

        $this->updateProductQuantity($objectToUpdate['product_id'], $currentProductInCart);
    }

    public function updateProductQuantity(int $productId, int $quantity): void
    {
        // TODO - need a way to recalculate all quantities, so products array updates the quantities included in product_list if it is there.
        // if not there everything is fine.
        // so orderObjects have to be updated here again? -> logic still lacks..

        $products = $this->getProducts();
        $productList = json_decode(Product::find($productId, ['product_list'])['product_list']);
        if ($productList) {
            foreach ($productList as $productId) {
                // get current quantity in cart if the item is in cart separatelly
                // if not the parent products quantity should be added to products in cart
                $this->updateProductQuantity($productId, $quantity);
            }
            return;
        }

        $productsInCart = $products->put($productId, $quantity);
        session()->put(self::CART_PRODUCTS, $productsInCart);
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

    public function calculatePrintAmount($orderObjects): int
    {
        $printAmount = 0;
        foreach ($orderObjects as $orderObject) {
            if ($orderObject['grafics']) {
                $printAmount += count($orderObject['grafics']);
            }
        }

        return $printAmount;
    }
}