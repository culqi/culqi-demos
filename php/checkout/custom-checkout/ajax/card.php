<?php

/**
 * Crear un charge a una tarjeta usando Culqi PHP.
 */

try {
  // Cargamos Requests y Culqi PHP
  include_once dirname(__FILE__) . '/../libraries/Requests/library/Requests.php';
  Requests::register_autoloader();
  include_once dirname(__FILE__) . '/../vendor/culqi/culqi-php/lib/culqi.php';
  include_once '../settings.php';

  $culqi = new Culqi\Culqi(array('api_key' => SECRET_KEY));

  //3ds object, la primera vez que se consume el servicio no se debe enviar los parámetros 3ds
  $tds = array();
  if (isset($_POST["eci"])) {
    $tds_xid = $_POST["xid"];
    $tds = array("authentication_3DS" => array(
      "eci" => $_POST["eci"],
      "xid" => $tds_xid,
      "cavv" => $_POST["cavv"],
      "protocolVersion" => $_POST["protocolVersion"],
      "directoryServerTransactionId" => $_POST["directoryServerTransactionId"]
    ));
}

  $req_body = array(
    "customer_id" => $_POST["customer_id"],
    "token_id" => $_POST["token"]
  );

  $with_tds = ($req_body) + (isset($tds_xid) ? $tds : array());
  $card = $culqi->Cards->create($with_tds);
  echo json_encode($card);
} catch (Exception $e) {

  error_log($e->getMessage());

  echo $e->getMessage();
}