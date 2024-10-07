<?php
header('Content-Type: application/json');
include_once dirname(__FILE__) . '/../vendor/culqi/culqi-php/lib/culqi.php';
require dirname(__FILE__) . '/../vendor/autoload.php';
include_once '../settings.php';

use Culqi\Culqi;

$culqi = new Culqi(array('api_key' => SECRET_API_KEY));
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
