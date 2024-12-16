<?php

namespace App\Controllers;

use App\Services\CulqiService;

class OrderController
{
  private CulqiService $culqiService;

  public function __construct()
  {
    $this->culqiService = new CulqiService();
  }

  public function handleRequest(): void
  {
    try {
      if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new \Exception("Invalid request method");
      }

      $data = $this->getJsonInput();

      $reqBody = [
        "amount" => $data["amount"],
        "currency_code" => $data["currency_code"],
        "description" => $data["description"] ?? "Default Order Description",
        "order_number" => $data["order_number"] ?? ("#id-" . time()),
        "client_details" => $data["client_details"] ?? [],
        "expiration_date" => $data["expiration_date"] ?? (time() + 24 * 60 * 60),
        "confirm" => $data["confirm"] ?? false
      ];

      $response = $this->culqiService->createOrder($reqBody);

      $this->sendJsonResponse($response);
    } catch (\Exception $e) {
      $this->handleError($e);
    }
  }

  private function getJsonInput(): array
  {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
      throw new \Exception("Invalid JSON data");
    }

    return $data;
  }

  private function sendJsonResponse(array $data): void
  {
    header("Content-Type: application/json");
    echo json_encode($data);
  }

  private function handleError(\Exception $e): void
  {
    error_log($e->getMessage());
    http_response_code(400);
    echo json_encode(["error" => $e->getMessage()]);
  }
}
