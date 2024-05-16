<?php

/**
 * Crear un plan usando Culqi PHP.
 */

try {
    // Cargamos Requests y Culqi PHP;
    require dirname(__FILE__) . '/../vendor/autoload.php';
    include_once '../settings.php';

    $culqi = new Culqi\Culqi(["api_key" => SECRET_KEY]);

    //Obtener planes por filtro
    $plan = $culqi->Plans->get(
        $_POST["plan_id"]
    );

    // Respuesta
    echo json_encode($plan);
} catch (Exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo $e->getMessage();
}