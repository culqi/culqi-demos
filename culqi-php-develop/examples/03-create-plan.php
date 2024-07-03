<?php
/**
 * Ejemplo 3
 * Como crear un plan usando Culqi PHP.
 */
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

  require dirname(__FILE__) . '/../vendor/autoload.php';


 use Culqi\Culqi;

  // Configurar tu API Key y autenticación
$SECRET_API_KEY = 'sk_test_04aff21ada451a4c';
$culqi = new Culqi(array('api_key' => $SECRET_API_KEY));

try {
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