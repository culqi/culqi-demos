<?php

namespace App\Controllers;

use Core\Session;


class HomeController
{
  public function view(): void
  {
    $user = Session::get('user');
    view('index.view.php', [
      'title' => 'Home',
      'user' => $user
    ]);
  }
}
