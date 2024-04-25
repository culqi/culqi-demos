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
  $encryption_params = array(
    "rsa_public_key" => RSA_PUBLIC_KEY,
    "rsa_id" => RSA_ID
  );

  // Creando Cargo a una tarjeta
  $tds = array();
  if (isset($_POST["eci"])) {
    $tds = array("authentication_3DS" => array(
      "eci" => $_POST["eci"],
      "xid" => $_POST["xid"],
      "cavv" => $_POST["cavv"],
      "protocolVersion" => $_POST["protocolVersion"],
      "directoryServerTransactionId" => $_POST["directoryServerTransactionId"]
    ));
}

  $req_body = array(
    "amount" => $_POST["amount"],
    "currency_code" => $_POST["currency_code"],
    "capture" => true,
    "email" => $_POST["email"],
    "source_id" => $_POST["token"],
    "description" => "PRUEBA BILLETERA 1",
    "antifraud_details" => array(
      "address" => "Andres Reyes 338",
      "address_city" => "Lima",
      "country_code" => "PE",
      "first_name" => "Roberto",
      "last_name" => "Beretta",
      "phone_number" => 123456789,
      "device_finger_print_id" => $_POST["deviceId"]
    ),
    "metadata" => array(
      "order_id" => "COD00001",
      "user_id" => "42052001",
      "sponsor" => "MiTienda"   //solo partners
    )
  );
  $with_tds = ($req_body) + $tds;
  
  if (ACTIVE_ENCRYPT){
    $charge = $culqi->Charges->create($with_tds,$encryption_params);
  }else{
    $charge = $culqi->Charges->create($with_tds);
  }
  echo json_encode($charge);
} catch (Exception $e) {

  error_log($e->getMessage());

  echo $e->getMessage();
}
