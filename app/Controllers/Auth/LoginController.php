<?php

namespace App\Controllers\Auth;
use Core\Session;
use App\Services\UserService;


class LoginController
{
  private UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function view()
  {
    view('auth/login.view.php', [
      'title' => 'Login'
    ]);
  }

  public function login()
  {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;


    $user = !$email ? null : $this->userService->login($email, $password);

    if ($email) {
      $_SESSION['user'] = $user;

      $response = array('isLogin' => true);
      return json_encode($response);
    }

    http_response_code(401);

    $response = array('isLogin' => false);
    return json_encode($response);
  }

  public function logout()
  {
    unset($_SESSION['user']);
    header('Location: /login');
  }
}

