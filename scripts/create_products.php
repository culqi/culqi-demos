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
      'name' => 'Wireless Audio',
      "image" => "./theme/assets/img/212X200/img1.jpg",
      'description' => 'Speakers',
      'price' => 100.00,
    ],
    [
      'id' => 2,
      'name' => 'Tablet White',
      "image" => "./theme/assets/img/212X200/img2.jpg",
      'description' => 'Tablets',
      'price' => 200.00,
    ],
    [
      'id' => 3,
      'name' => 'Purple Solo 2 Wireless',
      "image" => "./theme/assets/img/212X200/img3.jpg",
      'description' => 'Speakers',
      'price' => 300.00,
    ],
    [
      'id' => 4,
      'name' => 'Widescreen NX Mini F1 SMART NX',
      "image" => "./theme/assets/img/212X200/img4.jpg",
      'description' => 'Photographic camera',
      'price' => 400.00,
    ],
    [
      'id' => 5,
      'name' => 'Smartphone 6S 32GB LTE',
      "image" => "./theme/assets/img/212X200/img5.jpg",
      'description' => 'Smartphones',
      'price' => 500.00,
    ],
    [
      'id' => 6,
      'name' => 'Tablet White EliteBook Revolve 810 G2',
      "image" => "./theme/assets/img/212X200/img2.jpg",
      'description' => 'Tablets',
      'price' => 600.00,
    ],
    [
      'id' => 7,
      'name' => 'Wireless Audio System Multiroom 360 degree Full base audio',
      "image" => "./theme/assets/img/212X200/img1.jpg",
      'description' => 'Speakers',
      'price' => 700.00,
    ]
  ];

  foreach ($products as $product) {
    $record = $db->get(uniqid());
    $record->id = $product['id'];
    $record->name = $product['name'];
    $record->image = $product['image'];
    $record->description = $product['description'];
    $record->price = $product['price'];
    $record->save();

    echo "Product created: {$product['name']}" . PHP_EOL;
  }
}

createDummyProducts();