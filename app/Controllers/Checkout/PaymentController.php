<?php
namespace App\Controllers\Checkout;
use Core\Session;

class PaymentController
{
  public function view()
  {
    // Renderiza la vista de pago
    view('checkout/payment.view.php', [
      'cartItems' => $_SESSION['cart'] ?? [],
      'errors' => Session::get('errors'),
      'title' => 'Pago',
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