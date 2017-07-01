<?php

namespace Eqk\Cart;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Collection;
use Eqk\Cart\Discount\Discount;

class Cart
{

    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function get($itemId)
    {
        return $this->getAll()->get($itemId);
    }

    public function has($itemId): bool
    {
        return $this->getAll()->has($itemId);
    }

    public function add($id, $attributes): Cart
    {
        $cart = $this->getAll();
        if ($cart->has($id) && array_key_exists('quantity', $attributes)) {
            $this->updateQuantity($id, $attributes['quantity']);
        } else {
            $this->addItem($id, $attributes);
        }

        return $this;
    }

    public function remove($id)
    {
        $cart = $this->getAll();

        $cart->forget($id);

        $this->save($cart);
    }

    public function clear()
    {
        $this->save(new Collection());
    }

    public function updateQuantity($id, $change)
    {
        $cart = $this->getAll();
        $item = $cart->get($id);
        if (!empty($item['quantity']))
        {
            $item['quantity'] += $change;
            $cart->put($id, $item);
        }
        $this->save($cart);
    }

    public function getAll()
    {
        return (new Collection($this->getCartData()));
    }

    public function getTotal(Discount ...$discounts): float
    {
        $total = $this->getTotalWithoutDiscounts();
        foreach ($discounts as $discount)
        {
            $total = $discount->ApplyDiscount($total);
        }
        return $total;
    }

    public function isEmpty(): bool
    {
        $cart = new Collection($this->getCartData());

        return $cart->isEmpty();
    }

    protected function getTotalWithoutDiscounts() : float
    {
        $cart = $this->getAll();
        return $cart->sum(function ($item){
            return $item['price'] * $item['quantity'];
        });
    }

    protected function addItem($id, $item)
    {
        $cart = $this->getAll();

        $cart->put($id, $item);

        $this->save($cart);
    }

    protected function save(Collection $cart)
    {
        Redis::set('cart:'.$this->key, $cart->toJson());
    }

    protected function getCartData()
    {
        return json_decode(Redis::get('cart:'.$this->key), true);
    }

}
