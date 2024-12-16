<?php
namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function findByEmail(string $email, string $password): ?array
  {
    return $this->userRepository->findByEmailAndPassword($email, $password);
  }

  public function login(string $email, string $password)
  {
    $user = $this->userRepository->findByEmailAndPassword($email, $password);

    if (!$user) {
      return null;
    }
    return $user;
  }

  public function authenticate($email, $password)
  {

    $user = $this->findUserByEmail($email);

    if ($user && password_verify($password, $user['password'])) {

      return $user;

    }

    return null;
  }

  private function findUserByEmail($email)
  {

    return $this->userRepository->findByEmail($email);
  }

  public function createUser($email, $password, $name)
  {
    $user = [
      'email' => $email,
      'password' => password_hash($password, PASSWORD_DEFAULT),
      'name' => $name
    ];

    $this->userRepository->create($user);

    return $user;
  }
}
