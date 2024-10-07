<?php
/**
 * Ejemplo 1
 * Como crear un token a una tarjeta Culqi PHP.
 */

try {
  // Usando Composer (o puedes incluir las dependencias manualmente)
  //  require '../Requests-master/library/Requests.php';
  // Requests::register_autoloader();
  // require '../lib/culqi.php';
  include_once dirname(__FILE__) . '/../vendor/culqi/culqi-php/lib/culqi.php';
  include_once '../settings.php';

  $culqi = new Culqi\Culqi(array('api_key' => PUBLIC_KEY));

  // Creando Cargo a una tarjeta
  $token = $culqi->Tokens->create(
      array(
        "card_number" => "4111111111111111",
        "cvv" => "123",
        "email" => "soporte.culqi".uniqid()."@culqi.com", //email must not repeated
        "expiration_month" => 9,
        "expiration_year" => 2025,
        "fingerprint" => uniqid()
      )
  );
  // Respuesta
  echo json_encode("Token: ".$token->id);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
}
