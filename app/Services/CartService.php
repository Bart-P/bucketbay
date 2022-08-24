<?php

namespace App\Services;

class CartService {

    const CART = 'shopping-cart';
    const CART_PRODUCTS = self::CART . '.products';
    const CART_ADDRESS = self::CART . '.delivery-address-id';
    const CART_GRAFICS = self::CART . '.grafic-ids';

    public function addOneProduct($id): void
    {
        if(session(self::CART_PRODUCTS)) {
            $currentCartProductIds = collect(session(self::CART_PRODUCTS));
            if($this->productIdIsInCart($id)) {
                $currentCartProductIds[$id] += 1;
            } else {
                $currentCartProductIds->put($id, 1);
            }
            session()->put(self::CART_PRODUCTS, $currentCartProductIds);
        } else {
            session()->put(self::CART_PRODUCTS, collect([$id => 1]));
        }
    }

    public function removeOneProduct($id): void
    {
        $currendCartProductIds = collect(session(self::CART_PRODUCTS));
        if($this->productIdIsInCart($id)) {
            $currendCartProductIds[$id] -= 1;
            if ($currendCartProductIds[$id] === 0) $currendCartProductIds->pull($id);

            session()->put(self::CART_PRODUCTS, $currendCartProductIds);
        }
    }

    public function productIdIsInCart($id): bool
    {
        return collect(session(self::CART_PRODUCTS))->has($id);
    }

    public function getQuantity($id): int
    {
        if($this->productIdIsInCart($id)) return collect(session(self::CART_PRODUCTS))[$id];

        return 0;
    }

    public function getAddressId(): int|null {
        return $this->addressIsSetInCart() ? session(self::CART_ADDRESS) : null;
    }

    public function addressIsSetInCart(): bool
    {
        return session(self::CART_ADDRESS) != null;
    }

    //TODO take all address functionality into the service then procede with grafics cart functionality
}
