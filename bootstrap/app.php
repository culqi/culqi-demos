<?php

use App\Controllers\Card\CardController;
use Core\Container;

use App\Services\UserService;
use App\Services\ProductsService;

use App\Repositories\UserRepository;
use App\Repositories\ProductsRepository;

use App\Controllers\HomeController;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\ProfileController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Checkout\CartController;
use App\Controllers\Checkout\CheckoutController;
use App\Controllers\Checkout\PaymentController;
use App\Controllers\Process\CustomerController;
use App\Controllers\Store\ProductsController;
use App\Repositories\CardRepository;
use App\Repositories\ProfileRepository;
use App\Services\CardService;
use App\Services\CulqiService;
use App\Services\ProfileService;

$container = new Container();

// * Services

$container->bind(ProductsService::class, function ($container) {
  return new ProductsService(new ProductsRepository());
});

$container->bind(UserService::class, function ($container) {
  return new UserService(new UserRepository());
});

$container->bind(ProfileService::class, function ($container) {
  return new ProfileService(new ProfileRepository());
});

$container->bind(CardService::class, function ($container) {
  return new CardService(new CardRepository());
});

$container->bind(CulqiService::class, function ($container) {
  return new CulqiService();
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

$container->bind(CheckoutController::class, function ($container) {
  return new CheckoutController();
});

// Registra el LoginController en el contenedor
$container->bind(LoginController::class, function ($container) {
  return new LoginController($container->make(UserService::class));
});

// Registra el RegisterController en el contenedor
$container->bind(RegisterController::class, function ($container) {
  return new RegisterController($container->make(UserService::class));
});

// Registra el ProfileController en el contenedor
$container->bind(ProfileController::class, function ($container) {
  return new ProfileController($container->make(ProfileService::class));
});

$container->bind(CardController::class, function ($container) {
  return new CardController($container->make(CardService::class));
});

$container->bind(CustomerController::class, function ($container) {
  return new CustomerController($container->make(CulqiService::class));
});

$container->bind(PaymentController::class, function ($container) {
  return new PaymentController();
});