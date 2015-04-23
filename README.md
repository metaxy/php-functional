php-functional
==============

## Examples

### Map
How map looks like in Haskell:
```haskell
mult2 = map((*) 2)
f = mult2 5
```
And how it looks like in php with php-functional:
```php
$mult2 = map(function($x){return $x*2});
$f = $mult2(5);
```
