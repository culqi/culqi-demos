<?php
namespace Core;

class Container
{
  protected array $bindings = [];

  public function bind(string $abstract, callable $concrete)
  {
    $this->bindings[$abstract] = $concrete;
  }

  public function make(string $abstract)
  {
    if (isset($this->bindings[$abstract])) {
      return call_user_func($this->bindings[$abstract], $this);
    }

    throw new \Exception("No binding found for {$abstract}");
  }
}