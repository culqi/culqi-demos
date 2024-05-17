<?php

/**
 * Crear un charge a una tarjeta usando Culqi PHP.
 */

try {
  // Cargamos Requests y Culqi PHP
  include_once dirname(__FILE__) . '/../vendor/autoload.php';
  include_once dirname(__FILE__) . '/../vendor/culqi/culqi-php/lib/culqi.php';
  include_once '../settings.php';

  // Verificamos si la solicitud es POST
  if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    throw new Exception("Invalid request method");
  }

  // Obtenemos los datos JSON del cuerpo de la solicitud
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);

  // Verificamos si los datos son válidos
  if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    throw new Exception("Invalid JSON data");
  }

  // Inicializamos Culqi
  $culqi = new Culqi\Culqi(array('api_key' => SECRET_KEY));

  // Preparamos los datos para Culqi
  $req_body = array(
    "customer_id" => $data["customer_id"],
    "token_id" => $data["token_id"]
  );

  // Si se envió authentication_3DS, lo agregamos a los datos
  if (isset($data["authentication_3DS"])) {
    $req_body["authentication_3DS"] = $data["authentication_3DS"];
  }

  // Creamos la tarjeta con Culqi
  $card = $culqi->Cards->create($req_body);

  // Enviamos la respuesta
  header("Content-Type: application/json");
  echo json_encode($card);

} catch (Exception $e) {
  // Manejamos los errores
  http_response_code(500);
  error_log($e->getMessage());
  echo json_encode(array("error" => $e->getMessage()));
}

