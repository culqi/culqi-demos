<?php
header('Content-Type: application/json');

require dirname(__FILE__) . '/../vendor/autoload.php';

use Culqi\Culqi;


$SECRET_API_KEY = 'INSERTE_SU_LLAVE_PRIVADA';
$culqi = new Culqi(array('api_key' => $SECRET_API_KEY));
try {
// Creando Cargo a una tarjeta
$subscription = $culqi->Subscriptions->create(
    array(
    "plan_id" => $_POST["idPlan"],
    "card_id"=> $_POST["idCard"],
    "tyc" => true,
    )
);
// Response
echo json_encode($subscription);

} catch (Exception $e) {
echo json_encode($e->getMessage());
}
?>
