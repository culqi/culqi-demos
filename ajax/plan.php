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
    $plan = $culqi->Plans->create([
        "interval_unit_time" => 1,
        "interval_count" => 1,
        "image" => "https://culqi.com/assets/images/brand/brand.svg",
        "amount" => 300,
        "name" => "Plan mensual" . uniqid(),
        "description" => "Plan mensual con 1 solo cobro.",
        "short_name" => "pln-" . uniqid(),
        "currency" => "PEN",
        "metadata" => json_decode("{}"),
        "initial_cycles" => [
            "count" => 0,
            "amount" => 0,
            "has_initial_charge" => false,
            "interval_unit_time" => 1,
        ],
    ]);
    // Respuesta
    echo json_encode($plan);
} catch (Exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo $e->getMessage();
}
