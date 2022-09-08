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

    ///// PRODUCT

    public function addOneProduct(int $id): void
    {
        if (session(self::CART_PRODUCTS)) {
            $currentCartProductIds = collect(session(self::CART_PRODUCTS));
            if ($this->productIdIsSet($id)) {
                $currentCartProductIds[$id] += 1;
            } else {
                $currentCartProductIds->put($id, 1);
            }

            session()->put(self::CART_PRODUCTS, $currentCartProductIds);
        } else {
            session()->put(self::CART_PRODUCTS, collect([$id => 1]));
        }
    }

    public function productIdIsSet(int $id): bool
    {
        return collect(session(self::CART_PRODUCTS))->has($id);
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

    public function getQuantity(int $id): int
    {
        if ($this->productIdIsSet($id)) return (int) collect(session(self::CART_PRODUCTS))[$id];

        return 0;
    }

    public function updateQuantity($id, $quantity): void
    {
        if (gettype($quantity) === "integer" && $quantity > 0) {
            $productsInCart = $this->getProducts();
            $productsInCart[$id] = $quantity;
        } else {
            $this->removeProduct($id);
        }
    }

    public function getProducts(): Collection
    {
        return session(self::CART_PRODUCTS) ? session(self::CART_PRODUCTS) : collect([]);
    }

    public function removeProduct($id): void
    {
        $productsInCart = collect(session(self::CART_PRODUCTS));
        session()->put(self::CART_PRODUCTS, $productsInCart->forget($id));
    }

    ///// ADDRESS

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

    ///// GRAFIC

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

    public function createOrderObject(int $productId, array $grafics, int $quantity): OrderObject
    {
        return new OrderObject(['productId' => $productId, 'grafics' => $grafics, 'quantity' => $quantity]);
    }

    public function addOrderObject(OrderObject $orderObject): void
    {
        $orderObjectsCollection = collect(session(self::CART_ORDER_OBJECTS));
        $orderObjectsCollection->add($orderObject);
        session()->put(self::CART_ORDER_OBJECTS, $orderObjectsCollection);
    }

    public function getOrderObjects(): Collection
    {
        return session(self::CART_ORDER_OBJECTS) ? : collect([]);
    }

    public function removeOrderObject(int $key): void
    {

        $orderObjectsCollection = collect(session(self::CART_ORDER_OBJECTS));
        $orderObjectsCollection->forget($key);
        session()->put(self::CART_ORDER_OBJECTS, $orderObjectsCollection);
    }
}