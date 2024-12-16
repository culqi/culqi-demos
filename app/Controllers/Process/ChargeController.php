<?php

namespace App\Controllers;

use App\Services\CulqiService;
use App\Config\Config;

class ChargeController
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
        "capture" => true,
        "email" => $data["email"],
        "source_id" => $data["token"],
        "description" => $data["description"] ?? "Default Description",
        "antifraud_details" => $data["antifraud_details"] ?? [],
        "metadata" => $data["metadata"] ?? []
      ];

      if (isset($data["authentication_3DS"])) {
        $reqBody["authentication_3DS"] = $data["authentication_3DS"];
      }

      $encryptionParams = Config::ACTIVE_ENCRYPT
        ? [
          "rsa_public_key" => Config::RSA_PUBLIC_KEY,
          "rsa_id" => Config::RSA_ID
        ]
        : null;

      $response = $this->culqiService->createCharge($reqBody, $encryptionParams);

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
