<?php
/**
 * Ejemplo 6
 * Como crear un customer usando Culqi PHP.
 */

try {
  // Usando Composer (o puedes incluir las dependencias manualmente)
  include_once dirname(__FILE__) . '/../libraries/Requests/library/Requests.php';
  Requests::register_autoloader();
  include_once dirname(__FILE__) . '/../vendor/culqi/culqi-php/lib/culqi.php';
  include_once '../settings.php';

  $culqi = new Culqi\Culqi(array('api_key' => SECRET_KEY));

  // Creando Cargo a una tarjeta
  $customer = $culqi->Customers->create(
      array(
        "address" => $_POST["address"],
        "address_city" => $_POST["address_c"],
        "country_code" => $_POST["country"],
        "email" => $_POST["email"],
        "first_name" => $_POST["f_name"],
        "last_name" => $_POST["l_name"],
        "metadata" => array("test"=>"test"),
        "phone_number" => $_POST["phone"]
      )
  );

  // Respuesta
  echo json_encode($customer);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
}
