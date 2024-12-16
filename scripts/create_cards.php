<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filebase\Database;

function createDummyCards()
{
  $db = new Database([
    'dir' => __DIR__ . '/../storage/filebase/cards',
    'cache' => false,
  ]);

  $cards = [
    [
      'id' => 'card_live_asdf1234',
      'alias' => 'Card 1',
      'user_id' => '1',
    ],
    [
      'id' => 'card_live_qwer5678',
      'alias' => 'Card 2',
      'user_id' => '2',
    ],
    [
      'id' => 'card_live_zxcv9012',
      'alias' => 'Card 3',
      'user_id' => '3',
    ],
    [
      'id' => 'card_live_1234asdf',
      'alias' => 'Card 4',
      'user_id' => '1',
    ],
    [
      'id' => 'card_live_5678qwer',
      'alias' => 'Card 5',
      'user_id' => '2',
    ],
    [
      'id' => 'card_live_9012zxcv',
      'alias' => 'Card 6',
      'user_id' => '3',
    ],
  ];

  foreach ($cards as $card) {
    $record = $db->get(uniqid());
    $record->id = $card['id'];
    $record->alias = $card['alias'];
    $record->user_id = $card['user_id'];
    $record->save();

    echo "Card created: {$card['alias']}" . PHP_EOL;
  }
}

createDummyCards();