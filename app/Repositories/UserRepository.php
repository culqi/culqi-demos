<?php
namespace App\Repositories;

use App\Providers\FilebaseProvider;

class UserRepository
{
  public function findByEmail(string $email): ?array
  {
    $db = FilebaseProvider::getInstance('users');

    $users = $db->query()->where('email', '=', $email)->results();
    if (count($users) === 0) {
      return null;
    }

    return $users;
  }
  public function create(array $data): void
  {
    $db = FilebaseProvider::getInstance('users');
    $record = $db->get(uniqid());
    $record->name = $data['name'];
    $record->email = $data['email'];
    $record->password = $data['password'];
    $record->save();
  }

  public function findByEmailAndPassword(string $email, string $password): ?array
  {
    $db = FilebaseProvider::getInstance('users');

    $users = $db->query()->where('email', '=', $email)->results();
    if (count($users) === 0) {
      return null;
    }

    $user = $users[0];

    if (password_verify($password, $user['password'])) {
      return $user;
    }

    return null;
  }
}
