<?php

namespace App\Controllers\Checkout;
use Core\Session;


class CheckoutController
{
  public function process()
  {
    $input = json_decode(file_get_contents('php://input'), true);
    $paymentMethod = $input['paymentMethod'] ?? null;

    if ($paymentMethod) {
      Session::put('paymentMethod', $paymentMethod);
    }

    return ['paymentMethod' => Session::get('paymentMethod')];
  }
}

view('checkout/products.view.php', [
  'errors' => Session::get('errors')
]);
