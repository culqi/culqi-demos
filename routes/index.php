<?php

$router->get('/', 'HomeController', 'view', 'layout.php');
// $router->get('/login', 'Auth/LoginController', 'view', 'layout.php');
// $router->get('/register', 'Auth/RegisterController', 'view', 'layout.php');
// $router->get('/profile', 'Auth/ProfileController', 'view', 'layout.php');
$router->get('/store', 'Store/ProductsController', 'view');
$router->get('/cart', 'Checkout/CartController', 'view');
$router->get('/checkout', 'Checkout/CheckoutController', 'view');
$router->get('/payment', 'Checkout/PaymentController', 'view');

// API routes

$router->post('/auth/login', 'Auth/LoginController', 'login');
$router->post('/auth/logout', 'Auth/LoginController', 'logout');
$router->post('/auth/register', 'Auth/RegisterController', 'register');

$router->post('/api/card', 'Card/CardController', 'create');
$router->post('/api/card/list', 'Card/CardController', 'list');
$router->delete('/api/card/{cardId}', 'Card/CardController', 'delete');
$router->post('/api/cart', 'Checkout/CartController', 'add');
$router->put('/api/cart/{id}', 'Checkout/CartController', 'update');
$router->post('/api/cart/clear', 'Checkout/CartController', 'clear');
$router->post('/api/cart', 'Checkout/CartController', 'list');

$router->post('/api/checkout', 'CheckoutController', 'process');
$router->delete('/api/cart/{id}', 'Checkout/CartController', 'delete');

$router->post('/api/customer', 'Auth/ProfileController', 'update');