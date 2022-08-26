<?php

namespace App\Services;

class CartService
{
    private const CART = 'shopping-cart';
    private const CART_PRODUCTS = self::CART . '.products';
    private const CART_ADDRESS = self::CART . '.delivery-address-id';
    private const CART_GRAFICS = self::CART . '.grafic-ids';

    public function addOneProduct($id): void
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

    public function productIdIsSet($id): bool
    {
        return collect(session(self::CART_PRODUCTS))->has($id);
    }

    public function removeOneProduct($id): void
    {
        $currendCartProductIds = collect(session(self::CART_PRODUCTS));
        if ($this->productIdIsSet($id)) {
            $currendCartProductIds[$id] -= 1;
            if ($currendCartProductIds[$id] === 0) $currendCartProductIds->pull($id);

            session()->put(self::CART_PRODUCTS, $currendCartProductIds);
        }
    }

    public function getQuantity($id): int
    {
        if ($this->productIdIsSet($id)) return collect(session(self::CART_PRODUCTS))[$id];

        return 0;
    }

    public function getAddressId(): int|null
    {
        return $this->addressIsSet() ? session(self::CART_ADDRESS) : null;
    }

    public function addressIsSet(): bool
    {
        return session(self::CART_ADDRESS) != null;
    }

    public function addAddressId($id): void
    {
        session()->put(self::CART_ADDRESS, $id);
    }
}