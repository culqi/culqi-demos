<?php
/**
 * Ejemplo 6
 * Como crear un customer usando Culqi PHP.
 */

try {
  // Usando Composer (o puedes incluir las dependencias manualmente)
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
  $customer = $culqi->Customers->create(
    array(
      "address" => $data["address"],
      "address_city" => $data["address_city"],
      "country_code" => $data["country_code"],
      "email" => $data["email"],
      "first_name" => $data["first_name"],
      "last_name" => $data["last_name"],
      "metadata" => array("test" => "test"),
      "phone_number" => $data["phone_number"]
    )
  );

  // Enviamos la respuesta
  header("Content-Type: application/json");
  echo json_encode($customer);

} catch (Exception $e) {
  // Manejamos los errores
  http_response_code(500);
  error_log($e->getMessage());
  echo json_encode(array("error" => $e->getMessage()));
}

