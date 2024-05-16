<?php
/**
 * Ejemplo 6
 * Como crear un customer usando Culqi PHP.
 */

try {
  // Cargamos Requests y Culqi PHP;
  require dirname(__FILE__) . '/../vendor/autoload.php';
  include_once '../settings.php';

  $culqi = new Culqi\Culqi(array('api_key' => SECRET_KEY));

  // Creando Cargo a una tarjeta
  $customer = $culqi->Customers->create(
    array(
      "address" => $_POST["address"],
      "address_city" => $_POST["address_city"],
      "country_code" => $_POST["country_code"],
      "email" => $_POST["email"],
      "first_name" => $_POST["first_name"],
      "last_name" => $_POST["last_name"],
      "metadata" => array("test" => "test"),
      "phone_number" => $_POST["phone_number"]
    )
  );

  // Respuesta
  echo json_encode($customer);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
}
