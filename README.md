# Senfenico PHP bindings

The Senfenico PHP library provides convenient access to the Stripe API from
applications written in the PHP language.

## Requirements

PHP 7.3.0 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require senfenico/senfenico-php
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once 'vendor/autoload.php';
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/senfenico/senfenico-php/releases). Then, to use the bindings, include the `init.php` file.

```php
require_once '/path/to/senfenico-php/init.php';
```

## Getting Started

Simple usage looks like:

```php
$senfenico = new \Senfenico\Senfenico('sk_test_...');
$charge = $senfenico->charge->create([
    'amount' => 1000,
    'phone' => '76xxxxxx',
    'provider' => 'orange_bf'
]);
echo $charge;
```

## Documentation

See the [PHP API docs](https://docs.senfenico.com/).
