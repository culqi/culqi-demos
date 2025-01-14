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
      'id' => 'card_live_9012zxcv',
      'card_number' => '41111111****1111',
      'token_id' => 'tkn_test_NfbNUAPP6Qat0oXC',
      'email' => 'test@gmail.com',
      'creation_date' => '03/01/2025 23:42:36',
      'user_id' => '676e1ccf0261d'
    ],
    [
      'id' => 'card_live_9012zxcv',
      'card_number' => '41111111****1111',
      'token_id' => 'tkn_test_NfbNUAPP6Qat0oXC',
      'email' => 'test@gmail.com',
      'creation_date' => '03/01/2025 23:42:36',
      'user_id' => '676e1ccf0261d'
    ],
    [
      'id' => 'card_live_9012zxcv',
      'card_number' => '41111111****1111',
      'token_id' => 'tkn_test_NfbNUAPP6Qat0oXC',
      'email' => 'test@gmail.com',
      'creation_date' => '03/01/2025 23:42:36',
      'user_id' => '676e1ccf0261d'
    ],
    [
      'id' => 'card_live_9012zxcv',
      'card_number' => '41111111****1111',
      'token_id' => 'tkn_test_NfbNUAPP6Qat0oXC',
      'email' => 'test@gmail.com',
      'creation_date' => '03/01/2025 23:42:36',
      'user_id' => '676e1ccf0261d'
    ],
    [
      'id' => 'card_live_9012zxcv',
      'card_number' => '41111111****1111',
      'token_id' => 'tkn_test_NfbNUAPP6Qat0oXC',
      'email' => 'test@gmail.com',
      'creation_date' => '03/01/2025 23:42:36',
      'user_id' => '676e1ccf0261d'
    ],
    [
      'id' => 'card_live_9012zxcv',
      'card_number' => '41111111****1111',
      'token_id' => 'tkn_test_NfbNUAPP6Qat0oXC',
      'email' => 'test@gmail.com',
      'creation_date' => '03/01/2025 23:42:36',
      'user_id' => '676e1ccf0261d'
    ],
  ]; 

  foreach ($cards as $card) {
    $record = $db->get(uniqid());
    $record->id = $card['id'];
    $record->card_number = $card['card_number'];
    $record->token_id = $card['token_id'];
    $record->email = $card['email'];
    $record->creation_date = $card['creation_date']; 
    $record->user_id = $card['user_id'];
    $record->save();

    echo "Card created: {$card['alias']}" . PHP_EOL;
  }
}

createDummyCards();