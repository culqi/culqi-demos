<?php
/**
 * Ejemplo 2
 * Como crear un charge a una tarjeta usando Culqi PHP.
 */
header('Content-Type: application/json');

// require '../Requests-master/library/Requests.php';
// Requests::register_autoloader();
// require '../lib/culqi.php';
 include_once dirname(__FILE__) . '/../vendor/culqi/culqi-php/lib/culqi.php';
 require dirname(__FILE__) . '/../vendor/autoload.php';
 include_once '../settings.php';

 use Culqi\Culqi;

// Configurar tu API Key y autenticación
 $culqi = new Culqi(array('api_key' => SECRET_API_KEY));
 try {
   // Creando Cargo a una tarjeta
   $card = $culqi->Cards->create(
      array(
        "customer_id" =>  $_POST["idCustomer"],
        "token_id" =>  $_POST["token"]
      )
   );
  
   // Respuesta
   echo json_encode($card);
 } catch (Exception $e) {
   echo json_encode($e->getMessage());
 }
