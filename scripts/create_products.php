<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filebase\Database;

function createDummyProducts()
{
  $db = new Database([
    'dir' => __DIR__ . '/../storage/filebase/products',
    'cache' => false,
  ]);

  $products = [
    [
      'id' => 1,
      'name' => 'Product 1',
      'description' => 'Description for product 1',
      'price' => 100.00,
    ],
    [
      'id' => 2,
      'name' => 'Product 2',
      'description' => 'Description for product 2',
      'price' => 200.00,
    ],
    [
      'id' => 3,
      'name' => 'Product 3',
      'description' => 'Description for product 3',
      'price' => 300.00,
    ],
    [
      'id' => 4,
      'name' => 'Product 4',
      'description' => 'Description for product 4',
      'price' => 400.00,
    ]
  ];

  foreach ($products as $product) {
    $record = $db->get(uniqid());
    $record->id = $product['id'];
    $record->name = $product['name'];
    $record->description = $product['description'];
    $record->price = $product['price'];
    $record->save();

    echo "Product created: {$product['name']}" . PHP_EOL;
  }
}

createDummyProducts();