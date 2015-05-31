# Glue

# Glue

> Glue is a WordPress plugin to allow easy manage of templates (views) and data from anywhere in the site.

## Usage

Set the usage of the `View` class on top of the file where a new View it's going to be used.

```php
<?php use \glue\View; ?>
```

To load a view you can simply use:

```php
<?php
View::make('shared/head')
  ->with('brand', 'Businness Casual')
  ->with('address', '3481 Melrose Place | Beverly Hills, CA 90210 | 123.456.7890')
  ->render();
?>
```

```php
View::make('shared/head')
```

Creates a new view using the location of the current theme and the views/ directory inside of the folder so the structure it's like follows:

```
current-theme
  |- views
    |- shared
      |- head.php
```

With the method `with` you can pass any data to the view to load, you can use `set` instead of `with` if you wish, like:

```php
View::make('shared/head')
    ->set('brand', 'Businness Casual')
    ->render();
```

In any case the view has access to a `$brand` variable or `$view->brand`, if you prefer. A view using the brand and adress data can be constructed as follows:

```php
<?php if ( $view->get('brand') ): ?>
<div class="brand"><?php $view->brand; ?></div>
<?php endif; ?>

<?php if( $view->has( $address ) ): ?>
<div class="address-bar"><?php echo $address; ?></div>
<?php endif; ?>
```

## Methods

Inside of a view you have access to some special methods like:

### $view instance

You have accees in the view to a variable `$view` that variable holds the state of the current view and allows you to access to some methods and variables as well.


#### get

This mehtod retrieves the value of the data passed to the view, so for example if you pass 'brand' data you can retrieve that with:

```
$view->get('brand')
```

**There is a magic get method as well that outputs directly the data if it's a string or a number withoth need of use an echo before of the variable, as follows:**

```php
<?php $view->brand; ?>
```

That outputs the value of $brand directly into the view.

#### has

This methods receives a variable as an argument and returns true if the variable exist inside of the data passed to the view and test if the value has content (string), is not zero (numeric)  and if is not empty (array).

Example:

```php
<?php $view->has( $address ); ?>
```



