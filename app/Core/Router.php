<?php

namespace Core;

use Middleware\Middleware;

class Router
{
  protected $routes = [];
  protected $container;

  public function __construct(Container $container)
  {
    $this->container = $container;
  }

  public function add($method, $uri, $controller, $action = 'index', $layout = 'layout.php')
  {
    $this->routes[] = [
      'uri' => $uri,
      'controller' => $controller,
      'action' => $action,
      'method' => $method,
      'middleware' => null,
      'layout' => $layout,
    ];

    return $this;
  }

  public function get($uri, $controller, $action = 'index', $layout = 'layout.php')
  {
    return $this->add('GET', $uri, $controller, $action, $layout);
  }

  public function post($uri, $controller, $action = 'store')
  {
    return $this->add('POST', $uri, $controller, $action);
  }

  public function delete($uri, $controller, $action = 'destroy')
  {
    return $this->add('DELETE', $uri, $controller, $action);
  }

  public function put($uri, $controller, $action = 'update')
  {
    // muestra $uri en la terminal donde se está ejecutando el proyecto
    // remueve el id de la ruta
    // echo $uri;

    // $uri = str_replace('{id}', '', $uri);
    return $this->add('PUT', $uri, $controller, $action);
  }

  public function patch($uri, $controller, $action = 'update')
  {
    return $this->add('PATCH', $uri, $controller, $action);
  }

  public function only($key)
  {
    $this->routes[array_key_last($this->routes)]['middleware'] = $key;

    return $this;
  }
  /*
    public function route($uri, $method)
    {
      foreach ($this->routes as $route) {
        // Convertir la URI de la ruta en un patrón de expresión regular
        $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<$1>[a-zA-Z0-9_-]+)', $route['uri']);
        $pattern = "#^" . $pattern . "$#";

        if (preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {
          Middleware::resolve($route['middleware']);

          // Cargar la clase del controlador desde su namespace
          $controllerName = "App\\Controllers\\" . str_replace('/', '\\', $route['controller']);

          if (class_exists($controllerName)) {
            $controller = new $controllerName();

            // Filtrar parámetros de la ruta (nombres de captura en el patrón)
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

            // Determinar el método a ejecutar
            $action = $route['action'];

            if (method_exists($controller, $action)) {
              if ($method === 'GET') {
                $layout = $route['layout'];
                ob_start();
                $controller->{$action}();
                $content = ob_get_clean();
                require base_path('resources/views/layouts/' . $layout);
              } else {
                echo json_encode(call_user_func_array([$controller, $action], $params)); // Pasar los parámetros al método
              }
            } else {
              $this->abort(404); // Método no encontrado
            }

            return;
          }

          $this->abort(404); // Clase no encontrada
        }
      }
      $this->abort(404); // Ruta no encontrada
    }
    */

  public function route($uri, $method)
  {
    foreach ($this->routes as $route) {
      $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<$1>[a-zA-Z0-9_-]+)', $route['uri']);
      $pattern = "#^" . $pattern . "$#";

      if (preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {
        Middleware::resolve($route['middleware']);

        $controllerName = "App\\Controllers\\" . str_replace('/', '\\', $route['controller']);

        if (class_exists($controllerName)) {
          $controller = $this->container->make($controllerName);

          $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

          $action = $route['action'];

          if (method_exists($controller, $action)) {
            if ($method === 'GET') {
              $layout = $route['layout'];
              ob_start();
              $controller->{$action}();
              $content = ob_get_clean();
              require base_path('resources/views/layouts/' . $layout);
            } else {
              echo json_encode(call_user_func_array([$controller, $action], $params));
            }
          } else {
            $this->abort(404);
          }

          return;
        }

        $this->abort(404);
      }
    }
    $this->abort(404);
  }
  protected function abort($code = 404)
  {
    http_response_code($code);
    require base_path("resources/views/{$code}.php");
    die();
  }
  public function previousUrl()
  {

    return $_SERVER['HTTP_REFERER'] ?? '/';

  }
}
