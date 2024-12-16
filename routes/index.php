<?php

$router->get('/', 'HomeController', 'view', 'layout.empty.php');
$router->get('/login', 'Auth/LoginController', 'view', 'layout.empty.php');
$router->get('/register', 'Auth/RegisterController', 'view', 'layout.empty.php');
$router->get('/store', 'Store/ProductsController', 'view', 'layout.php');
$router->get('/cart', 'Checkout/CartController', 'view');

// API routes

$router->post('/auth/login', 'Auth/LoginController', 'login');
$router->post('/auth/logout', 'Auth/LoginController', 'logout');
$router->post('/auth/register', 'Auth/RegisterController', 'register');

$router->post('/api/cart', 'Checkout/CartController', 'add');
$router->put('/api/cart/{id}', 'Checkout/CartController', 'update');
$router->post('/api/cart/clear', 'Checkout/CartController', 'clear');
$router->post('/api/cart', 'Checkout/CartController', 'list');

$router->post('/api/checkout', 'CheckoutController', 'process');
$router->delete('/api/cart/{id}', 'Checkout/CartController', 'delete');