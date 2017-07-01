# shopping-cart

## Install via composer:

```composer config repositories.eqk git https://github.com/eqk/shopping-cart.git```

```composer require eqk/shopping-cart @dev```

## Configure for Laravel 5.4:

1. Add service provider
```php
  Eqk\Cart\CartServiceProvider::class
  ```
2. Add Facade
```php
  'Cart' => Eqk\Cart\CartFacade::class
  ```
## Usage

```php
        //Clears cart
        Cart::clear();

        //Add item with id 12
        Cart::add(12, array(
            'price' => 2,
            'quantity' => 10,
            'name' => 'Item name',
            'properties' => array('Item', 'for' , 'anything')
        ));

        //Update item quantity
        Cart::add(12, array(
            'quantity' => -2,
        ));

        //Check if cart has item
        if(Cart::has(2)){

        };

        //Check the cart is empty
        if (Cart::isEmpty()){

        }

        //Remove item
        Cart::remove(12);

        //Get all items (returns Illuminate\Collection
        $allItems = Cart::getAll();

        //Get total
        $total = Cart::getTotal(new PercentDiscount(20));
  ```
