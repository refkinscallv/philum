# Philum\App\Routes Class Documentation

This documentation provides an overview of the `Philum\App\Routes` class and its methods.

## Introduction

The `Philum\App\Routes` class is responsible for defining and setting up the routes for your application using the `Philum\Router\Router` class.

## Properties

- **$route**: An instance of the `Philum\Router\Router` class used to define and manage the application's routes.

## Methods

### __construct()

The constructor initializes the `SysRouter` instance and assigns it to the `$route` property.

```php
public function __construct() {
    $this->route = new SysRouter();
}
```

### set()

The `set` method is used to define the various routes and controller settings for the application.

```php
public function set() {
    $this->route->setMaintenance("Page@maintenance");
    $this->route->setDefault("Welcome@index", false);
    $this->route->setNotFound("Page@notFound");
    $this->route->set("/about", "Page@about", true);
    $this->route->run();
}
```

#### setMaintenance()

Sets the controller to handle maintenance mode.

- **Parameter**: 
  - `string`: The controller and method to handle maintenance (e.g., `Page@maintenance`).

```php
$this->route->setMaintenance("Page@maintenance");
```

#### setDefault()

Sets the default controller for the application.

- **Parameters**: 
  - `string`: The default controller and method (e.g., `Welcome@index`).
  - `boolean`: Whether to allow parameters or not.

```php
$this->route->setDefault("Welcome@index", false);
```

#### setNotFound()

Sets the controller for handling 404 errors (page not found).

- **Parameter**: 
  - `string`: The controller and method to handle 404 errors (e.g., `Page@notFound`).

```php
$this->route->setNotFound("Page@notFound");
```

#### set()

Sets a URL path for a specific controller and method.

- **Parameters**: 
  - `string`: The URL path (e.g., `/about`).
  - `string`: The controller and method to handle the path (e.g., `Page@about`).
  - `boolean`: Whether to allow parameters or not.

```php
$this->route->set("/about", "Page@about", true);
```

## Usage Example

```php
use Philum\App\Routes;

$routes = new Routes();
$routes->set();
```

This example demonstrates how to create an instance of the `Routes` class and set up the application routes.
```

This documentation script provides a clear and concise overview of the class, its properties, methods, and usage.