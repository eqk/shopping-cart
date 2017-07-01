# shopping-cart

Install via composer:

```composer config repositories.eqk git https://github.com/eqk/shopping-cart.git```
```composer require eqk/shopping-cart @dev```

Configure for Laravel 5.4:

1. Add service provider
```php
  Eqk\Cart\CartServiceProvider::class
  ```
2. Add Facade
```php
  'Cart' => Eqk\Cart\CartFacade::class,
  ```
