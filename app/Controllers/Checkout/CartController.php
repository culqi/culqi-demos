<?php

namespace App\Controllers\Checkout;
use Core\Session;
use App\Services\ProductsService;

class CartController
{
  private ProductsService $productsService;

  public function __construct(ProductsService $productsService)
  {
    $this->productsService = $productsService;
  }


  public function view()
  {
    if (isset($_SESSION['user'])) {
      view('checkout/cart.view.php', [
        'cartItems' => $_SESSION['cart'] ?? [],
        'errors' => Session::get('errors'),
        'title' => 'Carrito de Compras',
      ]);
      return;
    }
    header('Location: /');
    view('index.view.php', [
      'title' => 'Login'
    ]);
  }

  public function calculateTotal()
  {
    $total = 0;
    $items = [];
    foreach ($_SESSION['cart'] as $id => $item) {
      $itemTotal = $item['quantity'] * $item['price'];
      $total += $itemTotal;
      $items[] = [
        'name' => $item['name'],
        'image' => $item['image'],
        'quantity' => $item['quantity'],
        'total' => $itemTotal,
        'id' => $id
      ];
    }
    return ['items' => $items, 'total' => $total];
  }
  public function add()
  {
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['productId'] ?? null;

    $product = !$productId ? null : $this->productsService->find($productId);

    if ($productId && isset($product)) {
      if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = [
          'id' => $product['id'],
          'name' => $product['name'],
          'image' => $product['image'],
          'price' => $product['price'],
          'quantity' => 0,
        ];
      }
      $_SESSION['cart'][$productId]['quantity']++;
    }

    return $this->calculateTotal();
  }

  public function delete($id)
  {
    if (isset($_SESSION['cart'][$id])) {
      unset($_SESSION['cart'][$id]);
    }
    return $this->calculateTotal();
  }

  public function update($id)
  {
    $input = json_decode(file_get_contents('php://input'), true);
    $quantity = $input['quantity'] ?? null;
    $isIncrement = $input['isIncrement'] ?? false;

    if ($quantity === null || $quantity < 0) {
      return ['error' => 'Invalid quantity'];
    }

    $cart = $_SESSION['cart'] ?? [];

    foreach ($cart as &$item) {
      if ($item['id'] == $id) {
        if ($isIncrement) {
          $item['quantity'] += $quantity;
        } else {
          $item['quantity'] -= $quantity;
          if ($item['quantity'] <= 0) {
            $cart = $this->delete($id);
            break;
          }
        }
        break;
      }
    }

    $_SESSION['cart'] = $cart;
    return ['cart' => $cart];
  }
  public function clear()
  {
    $_SESSION['cart'] = [];
    return $this->calculateTotal();
  }

  public function list()
  {
    return $this->calculateTotal();
  }
}