<?php
namespace App\Repositories;

use App\Providers\FilebaseProvider;

class ProductsRepository
{
  public function all(): array
  {
    $db = FilebaseProvider::getInstance('products');
    return $db->query()->results();
  }

  public function find(int $id): ?array
  {
    $db = FilebaseProvider::getInstance('products');
    $products = $db->query()->where('id', '=', $id)->results();
    if (count($products) === 0) {
      return null;
    }

    return $products[0];
  }
}