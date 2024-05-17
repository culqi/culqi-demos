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
  $encryption_params = array(
    "rsa_public_key" => RSA_PUBLIC_KEY,
    "rsa_id" => RSA_ID
  );

  // Preparamos los datos para Culqi
  $req_body = array(
    "amount" => $data["amount"],
    "currency_code" => $data["currency_code"],
    "capture" => true,
    "email" => $data["email"],
    "source_id" => $data["token"],
    "description" => "PRUEBA BILLETERA 1",
    "antifraud_details" => array(
      "address" => "Andres Reyes 338",
      "address_city" => "Lima",
      "country_code" => "PE",
      "first_name" => "Roberto",
      "last_name" => "Beretta",
      "phone_number" => 123456789,
      "device_finger_print_id" => $data["device_finger_print_id"]
    ),
    "metadata" => array(
      "order_id" => "COD00001",
      "user_id" => "42052001",
      "sponsor" => "MiTienda"   //solo partners
    )
  );

  // Si se envió authentication_3DS, lo agregamos a los datos
  if (isset($data["authentication_3DS"])) {
    $req_body["authentication_3DS"] = $data["authentication_3DS"];
  }

  // Creamos el cargo con Culqi
  if (ACTIVE_ENCRYPT) {
    $charge = $culqi->Charges->create($req_body, $encryption_params);
  } else {
    $charge = $culqi->Charges->create($req_body);
  }

  // Enviamos la respuesta
  header("Content-Type: application/json");
  echo json_encode($charge);

} catch (Exception $e) {
  // Manejamos los errores
  error_log($e->getMessage());
  http_response_code(400);
  echo json_encode(array("error" => $e->getMessage()));
}

