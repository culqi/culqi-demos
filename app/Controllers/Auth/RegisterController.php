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
    $customerCode = $input['customer_code'] ?? null;
    $customerEmail = $input['customer_email'] ?? null;

    if (!$customerEmail || !$customerCode) {
      http_response_code(400);
      $response = array('isRegister' => false, 'message' => 'Invalid data received');
      return json_encode($response);
    }

    $password = $input['password'] ?? null;
    $firstName = $input['first_name'] ?? null;
    $lastName = $input['last_name'] ?? null;
    $email = $input['email'] ?? null;
    $address = $input['address'] ?? null;
    $addressCity = $input['address_city'] ?? null;
    $countryCode = $input['country_code'] ?? null;
    $phoneNumber = $input['phone_number'] ?? null;


    $user = !$email ? null : $this->userService->createUser(
      $password,
      $firstName,
      $lastName,
      $email,
      $address,
      $addressCity,
      $countryCode,
      $phoneNumber,
      $customerCode,
      $customerEmail
    );

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