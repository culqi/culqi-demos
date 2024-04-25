<?php

/**
 * Crear un charge a una tarjeta usando Culqi PHP.
 */

try {
  // Cargamos Requests y Culqi PHP
  require '../vendor/autoload.php';
  include_once dirname(__FILE__) . '/../vendor/culqi/culqi-php/lib/culqi.php';
  include_once '../settings.php';

  $culqi = new Culqi\Culqi(array('api_key' => SECRET_KEY));

  // Creando Cargo a una tarjeta
  $order = $culqi->Orders->create(
    array(
      "amount" => $_POST["amount"], //minimo de 6 soles
      "currency_code" => $_POST["currency_code"],
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
  // Respuesta
  echo json_encode($order);//return $order;
} catch (Exception $e) {
  http_response_code(500);
  error_log($e->getMessage());
  echo $e->getMessage();
}
