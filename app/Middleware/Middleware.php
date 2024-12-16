<?php

namespace Middleware;

class Middleware
{
  public const MAP = [
    'guest' => Guest::class,
    'auth' => Authenticated::class
  ];

  public static function resolve($key)
  {
    if (!$key || !is_string($key)) {
      return;
    }

    $middleware = static::MAP[$key] ?? false;

    if (!$middleware) {
      throw new \Exception("No matching middleware found for key '{$key}'.");
    }

    (new $middleware)->handle();
  }
}