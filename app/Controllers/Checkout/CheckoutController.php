<?php

namespace App\Controllers\Checkout;
use Core\Session;


class CheckoutController
{
  public function view()
  {
    if (isset($_SESSION['user'])) {
      view('checkout/checkout.view.php', [
        'cartItems' => $_SESSION['cart'] ?? [],
        'errors' => Session::get('errors'),
        'title' => 'Checkout',
      ]);
      return;
    }
    header('Location: /');
    view('index.view.php', [
      'title' => 'Login'
    ]);
  }
  
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
