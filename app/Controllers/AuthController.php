<?php
namespace App\Controllers;

use App\Services\UserService;

class AuthController
{
  private UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function login()
  {
    // Procesar inicio de sesión
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'secret') {
      $_SESSION['user'] = ['username' => 'admin'];
      header('Location: /ordenes');
    } else {
      echo "Invalid credentials";
    }
  }

  public function logout()
  {
    unset($_SESSION['user']);
    session_destroy();
    header('Location: /');
    exit();
  }
}