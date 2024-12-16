<?php

namespace App\Controllers\Auth;
use Core\Session;
use App\Services\UserService;

class RegisterController
{
  private UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function view()
  {
    view('auth/register.view.php', [
      'title' => 'Register'
    ]);
  }

  public function register()
  {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;
    $name = $input['name'] ?? null;

    $user = !$email ? null : $this->userService->createUser($email, $password, $name);

    if ($email) {
      $_SESSION['user'] = $user;

      $response = array('isRegister' => true);
      return json_encode($response);
    }

    http_response_code(401);

    $response = array('isRegister' => false);
    return json_encode($response);
  }
}