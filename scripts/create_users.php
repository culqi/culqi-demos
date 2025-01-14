<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filebase\Database;

function createDummyUsersWithSettings()
{
  $userDb = new Database([
    'dir' => __DIR__ . '/../storage/filebase/users',
    'cache' => false,
  ]);

  $users = [
    [
      "id_user" => "676e1ccf0261d",
      'name' => 'John Doe',
      'email' => 'john.doe@example.com',
      'password' => password_hash('password123', PASSWORD_BCRYPT),
      'first_name' => '',
      'last_name' => '',
      'address' => '',
      'address_city' => '',
      'country_code' => '',
      'phone_number' => '',
      'customer_code' => '',
      'customer_email' => ''
    ],
    [
      "id_user" => "676e1ccf030fe",
      'name' => 'Jane Smith',
      'email' => 'jane.smith@example.com',
      'password' => password_hash('securepass456', PASSWORD_BCRYPT),
      'first_name' => '',
      'last_name' => '',
      'address' => '',
      'address_city' => '',
      'country_code' => '',
      'phone_number' => '',
      'customer_code' => '',
      'customer_email' => ''
    ],
    [
      "id_user" => "676e1ccf03d30",
      'name' => 'Alice Johnson',
      'email' => 'alice.johnson@example.com',
      'password' => password_hash('mypassword789', PASSWORD_BCRYPT),
      'first_name' => '',
      'last_name' => '',
      'address' => '',
      'address_city' => '',
      'country_code' => '',
      'phone_number' => '',
      'customer_code' => '',
      'customer_email' => ''
    ],
  ];

  foreach ($users as $user) {
    $userRecord = $userDb->get($user['id_user']);
    $userRecord->id_user = $user['id_user'];
    $userRecord->name = $user['name'];
    $userRecord->email = $user['email'];
    $userRecord->password = $user['password'];
    $userRecord->first_name = $user['first_name'];
    $userRecord->last_name = $user['last_name'];
    $userRecord->address = $user['address'];
    $userRecord->address_city = $user['address_city'];
    $userRecord->country_code = $user['country_code'];
    $userRecord->phone_number = $user['phone_number'];
    $userRecord->customer_code = $user['customer_code'];
    $userRecord->customer_email = $user['customer_email'];
    $userRecord->save();
  }

  echo "Dummy users and settings created successfully!" . PHP_EOL;
}

createDummyUsersWithSettings();