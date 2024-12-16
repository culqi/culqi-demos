<?php

use Core\ValidationException;
use Core\Session;

const BASE_PATH = __DIR__ . '/..';
const APP_PATH = BASE_PATH . '/app';

session_start();

require BASE_PATH . '/vendor/autoload.php';

require APP_PATH . '/Core/functions.php';
require APP_PATH . '/Core/Router.php';
require BASE_PATH . '/bootstrap/app.php';

$router = new \Core\Router($container);

require BASE_PATH . '/routes/index.php';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
  $router->route($uri, $method);
} catch (ValidationException $exception) {
  Session::flash('errors', $exception->errors);
  Session::flash('old', $exception->old);

  return redirect($router->previousUrl());
}

Session::unflash();