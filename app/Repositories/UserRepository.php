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
  public function create(array $data): ?array
  {
    $db = FilebaseProvider::getInstance('users');
    $record = $db->get($data['id_user']);
    $record->id_user = $data['id_user'];
    $record->name = $data['first_name'];
    $record->email = $data['email'];
    $record->password = $data['password'];

    $record->customer_code = $data['customer_code'];
    $record->customer_email = $data['customer_email'];

    $record->first_name = $data['first_name'];
    $record->last_name = $data['last_name'];
    $record->address = $data['address'];
    $record->address_city = $data['address_city'];
    $record->country_code = $data['country_code'];
    $record->phone_number = $data['phone_number'];
    $record->save();

    $user = $db->query()->where('email', '=', $data['email'])->results();

    return $user;
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