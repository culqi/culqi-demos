<?php
use Core\Container;

use App\Services\UserService;
use App\Services\ProductsService;

use App\Repositories\UserRepository;
use App\Repositories\ProductsRepository;

use App\Controllers\HomeController;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Checkout\CartController;
use App\Controllers\Store\ProductsController;

$container = new Container();

// * Services

$container->bind(ProductsService::class, function ($container) {
  return new ProductsService(new ProductsRepository());
});

$container->bind(UserService::class, function ($container) {
  return new UserService(new UserRepository());
});

// * Controllers

// Registra el CartController en el contenedor
$container->bind(CartController::class, function ($container) {
  return new CartController($container->make(ProductsService::class));
});

// Registra el ProductsController en el contenedor
$container->bind(ProductsController::class, function ($container) {
  return new ProductsController($container->make(ProductsService::class));
});

// Registra el HomeController en el contenedor
$container->bind(HomeController::class, function ($container) {
  return new HomeController();
});

// Registra el LoginController en el contenedor
$container->bind(LoginController::class, function ($container) {
  return new LoginController($container->make(UserService::class));
});

// Registra el RegisterController en el contenedor
$container->bind(RegisterController::class, function ($container) {
  return new RegisterController($container->make(UserService::class));
});