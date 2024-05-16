<?php

/**
 * Crear un plan usando Culqi PHP.
 */

try {
    // Cargamos Requests y Culqi PHP;
    require dirname(__FILE__) . '/../vendor/autoload.php';
    include_once '../settings.php';

    $culqi = new Culqi\Culqi(["api_key" => SECRET_KEY]);

    // Creando Cargo a una tarjeta
    $subscription = $culqi->Subscriptions->create(
        array(
          "card_id" => $_POST["card_id"],
          "plan_id" => $_POST["plan_id"],
          "tyc" => true,
          "metadata" => json_decode('{}'),
        )
      );

    // Respuesta
    echo json_encode($subscription);
} catch (Exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo $e->getMessage();
}