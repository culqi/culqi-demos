<?php

/**
 * Crear un charge a una tarjeta usando Culqi PHP.
 */

try {
  // Cargamos Requests y Culqi PHP;
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
  $order = $culqi->Orders->create(
    array(
      "amount" => $data["amount"], //minimo de 6 soles
      "currency_code" => $data["currency_code"],
      "description" => 'Prueba Orden 1',
      "order_number" => "#id-" . time(),
      "client_details" => array(
        "first_name" => "Beco",
        "last_name" => "Orden",
        "email" => EMAIL_CUSTOMER,
        "phone_number" => "999145221"
      ),
      "expiration_date" => time() + 24 * 60 * 60,
      "confirm" => false,
      // Orden con (01) dia de validez (hora-min-seg)
    )
  );

  // Enviamos la respuesta
  header("Content-Type: application/json");
  echo json_encode($order);

} catch (Exception $e) {
  // Manejamos los errores
  http_response_code(500);
  error_log($e->getMessage());
  echo json_encode(array("error" => $e->getMessage()));
}

