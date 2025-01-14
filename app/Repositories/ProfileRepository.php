<?php

namespace App\Repositories;

use App\Providers\FilebaseProvider;
use Exception;

class ProfileRepository
{
  public function updateProfile($user_id, $profile_details)
  {
    $db = FilebaseProvider::getInstance('users');
    $user = $db->get($user_id);

    if (!$user) {
      throw new Exception("Usuario no encontrado. $user_id", 404);
    }

    if (isset($profile_details['first_name'])) {
      $user->customer['details']['first_name'] = $profile_details['first_name'];
    }
    if (isset($profile_details['last_name'])) {
      $user->customer['details']['last_name'] = $profile_details['last_name'];
    }
    if (isset($profile_details['email'])) {
      $user->customer['details']['email'] = $profile_details['email'];
    }
    if (isset($profile_details['address'])) {
      $user->customer['details']['address'] = $profile_details['address'];
    }
    if (isset($profile_details['address_city'])) {
      $user->customer['details']['address_city'] = $profile_details['address_city'];
    }
    if (isset($profile_details['country_code'])) {
      $user->customer['details']['country_code'] = $profile_details['country_code'];
    }
    if (isset($profile_details['phone_number'])) {
      $user->customer['details']['phone_number'] = $profile_details['phone_number'];
    }

    if (isset($profile_details['customer_code'])) {
      $user->customer['customer_code'] = $profile_details['customer_code'];
    }

    if (isset($profile_details['customer_email'])) {
      $user->customer['customer_email'] = $profile_details['customer_email'];
    }

    $user->save();

    $_SESSION['user']['customer']['details'] = $user->customer['details'];

    $_SESSION['user']['customer_code'] = $user->customer['customer_code'];
    $_SESSION['user']['customer_email'] = $user->customer['customer_email'];
  }
}
