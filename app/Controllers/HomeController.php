<?php

namespace App\Controllers;

use Core\Session;


class HomeController
{
  public function view(): void
  {
    if (isset($_SESSION['user'])) {
      header('Location: /store');
      view('store/products.view.php', [
        'title' => 'Store'
      ]);
    }
    $user = Session::get('user');
    view('index.view.php', [
      'title' => 'Home',
      'user' => $user
    ]);
  }
}