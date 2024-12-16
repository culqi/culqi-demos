<?php

namespace App\Controllers;

use Core\Session;


class HomeController
{

  public function view(): void
  {
    view('index.view.php', [
      'title' => 'Home',
      'user' => $_SESSION['user']
    ]);
  }
}
