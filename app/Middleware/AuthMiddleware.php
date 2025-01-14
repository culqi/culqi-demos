<?php

namespace App\Middleware;

class AuthMiddleware
{
  public static function check()
  {
    if (!isset($_SESSION['user'])) {
      header('Location: /');
      exit();
    }
  }
  public static function run(string $url, array $routes): void
  {
    $uri = parse_url($url);
    $path = $uri['path'];

    if (false === array_key_exists($path, $routes)) {
      return;
    }
    $callback = $routes[$path];
    $callback();
  }
}