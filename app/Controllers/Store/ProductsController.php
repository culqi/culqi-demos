<?php

namespace App\Controllers\store;
use Core\Session;
use App\Services\ProductsService;

class ProductsController
{
  private ProductsService $productsService;


  public function __construct(ProductsService $productsService)
  {
    $this->productsService = $productsService;
  }

  public function view()
  {
    if (isset($_SESSION['user'])) {
      // obtener todos los productos
      $products = $this->productsService->all();

      // Renderiza la vista store
      view('store/products.view.php', [
        'cartItems' => $_SESSION['cart'] ?? [],
        'products' => $products,
        'errors' => Session::get('errors'),
        'title' => 'Products',
      ]);
      return;
    }
    header('Location: /');
    view('index.view.php', [
      'title' => 'Home'
    ]);
  }
}