<?php
/**
 * Ejemplo 2
 * Como crear un charge a una tarjeta usando Culqi PHP.
 */


 header('Content-Type: application/json');

   require '../Requests-master/library/Requests.php';
   Requests::register_autoloader();
   require '../lib/culqi.php';
   include_once '../../settings.php';

 use Culqi\Culqi;

  // Configurar tu API Key y autenticación
  $culqi = new Culqi(array('api_key' => SECRET_API_KEY));
try {
  // Creando Cargo a una tarjeta
  $card = $culqi->Cards->getList();
  // RespuestaA
  echo json_encode($card);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
}
?>