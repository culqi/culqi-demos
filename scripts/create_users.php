<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filebase\Database;

function createDummyUsers()
{
  $db = new Database([
    'dir' => __DIR__ . '/../storage/filebase/users',
    'cache' => false,
  ]);

  $users = [
    [
      'name' => 'John Doe',
      'email' => 'john.doe@example.com',
      'password' => password_hash('password123', PASSWORD_BCRYPT), // Contraseña segura
    ],
    [
      'name' => 'Jane Smith',
      'email' => 'jane.smith@example.com',
      'password' => password_hash('securepass456', PASSWORD_BCRYPT),
    ],
    [
      'name' => 'Alice Johnson',
      'email' => 'alice.johnson@example.com',
      'password' => password_hash('mypassword789', PASSWORD_BCRYPT),
    ],
  ];

  foreach ($users as $user) {
    $record = $db->get(uniqid());
    $record->name = $user['name'];
    $record->email = $user['email'];
    $record->password = $user['password'];
    $record->save();

    echo "User created: {$user['email']}" . PHP_EOL;
  }

  echo "Dummy users created successfully!" . PHP_EOL;
}

createDummyUsers();
