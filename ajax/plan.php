<?php
/**
 * Ejemplo 3
 * Como crear un plan usando Culqi PHP.
 */
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require dirname(__FILE__) . '/../vendor/autoload.php';
include_once '../settings.php';

 use Culqi\Culqi;

  // Configurar tu API Key y autenticación
$culqi = new Culqi(array('api_key' => SECRET_API_KEY));

// Lista de campos requeridos
$requiredFields = ['name', 'short_name', 'description', 'currency', 'amount', 'interval_count', 'initial_cycles', 'interval_unit_time'];

// Verificación de campos vacíos
foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || $_POST[$field] === '') {
        http_response_code(400);
        echo json_encode(["error" => "El campo '$field' es obligatorio"]);
        exit();
    }
}

try {

  // Validación conjunta para amount, initial_cycles y interval_count
  $invalidField = null;
  $errorMessage = "";

  // Validación para amount que debe estar entre 300 y 5000
  if ((int)$_POST["amount"] < 300 || (int)$_POST["amount"] > 5000) {
      $invalidField = 'amount';
      $errorMessage = "El campo amount debe estar entre 300 y 5000.";
  }
  // Validación para initial_cycles que debe ser 0 o mayor
  elseif ((int)$_POST["initial_cycles"] < 0) {
      $invalidField = 'initial_cycles';
      $errorMessage = "El campo initial_cycles debe ser 0 o mayor.";
  }
  // Validación para interval_count que debe ser 0 o mayor
  elseif ((int)$_POST["interval_count"] < 0) {
      $invalidField = 'interval_count';
      $errorMessage = "El campo interval_count debe ser 0 o mayor.";
  }

  // Enviar error si alguno de los campos es inválido
  if ($invalidField) {
      http_response_code(400);
      echo json_encode(["error" => $errorMessage]);
      exit();
  }
  
  // Creando el plan en Culqi
  $plan = $culqi->Plans->create([
    "name" => $_POST["name"]. uniqid(),
    "short_name" => $_POST["short_name"]. uniqid(),
    "description" => $_POST["description"],
    "image" => "https://culqi.com/assets/images/brand/brand.svg",
    "amount" => (int) $_POST["amount"], //monto
    "currency" => (string)$_POST["currency"], //tipo PEN o USD
    "interval_count" => (int) $_POST["interval_count"], //intervalos entre cargo
    "interval_unit_time" => (int)$_POST["interval_unit_time"], //frecuencia mensual, diario
    "initial_cycles" => [
        "count" => 0,
        "amount" => 0, // Ajusta según sea necesario
        "has_initial_charge" => false,
        "interval_unit_time" => 1,
    ],
    "metadata" => json_decode("{}"),
    // Otros campos opcionales como image, pay_info, etc.
]);

  echo json_encode($plan);

} catch (Exception $e) {
  echo json_encode($e->getMessage());
}
?>