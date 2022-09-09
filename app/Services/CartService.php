<?php

namespace App\Services;

use App\Models\OrderObject;
use Illuminate\Support\Collection;

class CartService
{
    private const CART = 'shopping-cart';
    private const CART_PRODUCTS = self::CART . '.products';
    private const CART_ADDRESS = self::CART . '.delivery-address-id';
    private const CART_GRAFICS = self::CART . '.grafic-ids';
    private const CART_ORDER_OBJECTS = self::CART . '.order-objects';

    public function getProducts(): Collection
    {
        return session(self::CART_PRODUCTS) ? session(self::CART_PRODUCTS) : collect([]);
    }

    public function addOneProduct(int $id): void
    {
        $cartProducts = session(self::CART_PRODUCTS);
        if ($cartProducts) {
            $currentCartProductIds = collect($cartProducts);
            if ($this->productIdIsSet($id)) {
                $currentCartProductIds[$id] += 1;
            } else {
                $currentCartProductIds->put($id, 1);
            }
            session()->put(self::CART_PRODUCTS, $currentCartProductIds);
        } else {
            session()->put(self::CART_PRODUCTS, collect([$id => 1]));
        }

        $this->addOrderObject($this->createEmptyOrderObject($id));
    }

    public function productIdIsSet(int $id): bool
    {
        return collect(session(self::CART_PRODUCTS))->has($id);
    }

    public function addOrderObject(OrderObject $orderObject): void
    {
        $orderObjectsCollection = collect(session(self::CART_ORDER_OBJECTS));
        $orderObjectsCollection->add($orderObject);
        $orderObjectsCollection = $orderObjectsCollection->sortBy('productId');
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

    public function removeProduct($id): void
    {
        $productsInCart = collect(session(self::CART_PRODUCTS));
        session()->put(self::CART_PRODUCTS, $productsInCart->forget($id));
    }

    public function removeOneProduct($id): void
    {
        $currendCartProductIds = collect(session(self::CART_PRODUCTS));
        if ($this->productIdIsSet($id)) {
            $currendCartProductIds[$id] -= 1;
            if ($currendCartProductIds[$id] <= 0) $currendCartProductIds->pull($id);

            session()->put(self::CART_PRODUCTS, $currendCartProductIds);
        }
    }

    public function updateOrderObjectQuantity($key, $quantity): void
    {
        // TODO need to update the quantity of 1 orderObject in cart... Did not test this
        $orderObjectsInCart = $this->getOrderObjects();
        $objectToUpdate = collect($orderObjectsInCart->get($key));
        $objectToUpdate->put('quantity', $quantity);
        $orderObjectsInCart->put($key, $objectToUpdate);

        dd($orderObjectsInCart);
    }

    public function addAddressId(int $id): void
    {
        session()->put(self::CART_ADDRESS, $id);
    }

    public function getAddressId(): ?int
    {
        return $this->addressIsSet() ? session(self::CART_ADDRESS) : null;
    }

    public function addressIsSet(): bool
    {
        return session(self::CART_ADDRESS) != null;
    }

    /**
     * Add or remove the grafics ID in the Cart:
     *  - if the ID is present it will remove it
     *  - if the ID is not present it will add it
     *
     * @param int $id
     * @return void
     */
    public function addOrRemoveGraficsId(int $id): void
    {
        if ($graficsCartArray = session(self::CART_GRAFICS)) {
            if (!in_array($id, $graficsCartArray)) {
                array_unshift($graficsCartArray, $id);
            } else {
                array_splice($graficsCartArray, array_search($id, $graficsCartArray), 1);
            }
        } else {
            $graficsCartArray = [$id];
        }

        session()->put(self::CART_GRAFICS, $graficsCartArray);
    }

    public function getAllGrafics(): ?array
    {
        return session(self::CART_GRAFICS);
    }

    public function getOrderObjects(): Collection
    {
        $orderObjectsCollection = collect(session(self::CART_ORDER_OBJECTS));
        return $orderObjectsCollection->sortBy('productId') ? : collect([]);
    }

    public function removeOrderObject(int $key): void
    {

        $orderObjectsCollection = collect(session(self::CART_ORDER_OBJECTS));
        $orderObjectsCollection->forget($key);
        session()->put(self::CART_ORDER_OBJECTS, $orderObjectsCollection);
    }
}