# Usage of the `Request` Class

The `Request` class within the `Philum\HTTP` namespace provides various methods to handle and access HTTP request data. Below is the usage guide.

## Initializing the Class

To use the `Request` class, you need to initialize it first:

```php
use Philum\HTTP\Request;

$request = new Request();
```

## Getting the HTTP Request Method

You can check the HTTP request method (GET, POST, PUT, DELETE, PATCH) using the following methods:

```php
if ($request->isGet()) {
    // The request is a GET request
}

if ($request->isPost()) {
    // The request is a POST request
}

if ($request->isPut()) {
    // The request is a PUT request
}

if ($request->isDelete()) {
    // The request is a DELETE request
}

if ($request->isPatch()) {
    // The request is a PATCH request
}
```

## Accessing HTTP Headers

To get all HTTP headers:

```php
$headers = $request->getHeaders();
```

To get a specific HTTP header:

```php
$authHeader = $request->getHeader('Authorization');
```

## Accessing the Request Body

To get the raw request body:

```php
$body = $request->getBody();
```

To get the JSON-decoded request body:

```php
$jsonBody = $request->getJsonBody();
```

## Accessing Query and POST Parameters

To get all query parameters:

```php
$queryParams = $request->getQueryParams();
```

To get a specific query parameter:

```php
$param = $request->getQueryParam('paramName');
```

To get all POST parameters:

```php
$postParams = $request->getPostParams();
```

To get a specific POST parameter:

```php
$postParam = $request->getPostParam('paramName');
```

## Accessing Request Parameters

To get all request parameters:

```php
$requestParams = $request->getRequestParams();
```

To get a specific request parameter:

```php
$requestParam = $request->getRequestParam('paramName');
```

## Accessing File Parameters

To get all file parameters:

```php
$fileParams = $request->getFileParams();
```

To get a specific file parameter:

```php
$fileParam = $request->getFileParam('paramName');
```

## Accessing the Request URI

To get the request URI:

```php
$uri = $request->getUri();
```

## Accessing Server Variables

To get a specific `$_SERVER` variable by key:

```php
$serverVar = $request->getServer('SERVER_NAME');
```

To get all `$_SERVER` variables:

```php
$serverVars = $request->getServers();
```

## Example Usage

Here is a complete example of how to use the `Request` class in a script:

```php
<?php

use Philum\HTTP\Request;

$request = new Request();

if ($request->isPost()) {
    $data = $request->getPostParam('data');
    echo 'Received data: ' . htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
} else {
    echo 'This is not a POST request';
}
```

With the `Request` class, you can easily access and manipulate HTTP request data in your PHP application in a safe and structured manner.