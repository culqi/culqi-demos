<?php

namespace App\Controllers;

use App\Services\CulqiService;
use App\Config\Config;

class CardController
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
                'customer_id' => $data['customer_id'],
                'token_id' => $data['token_id'],
            ];

            if (!empty($data['xid'])) {
                $reqBody['authentication_3DS'] = [
                    'eci' => $data['eci'] ?? '',
                    'xid' => $data['xid'],
                    'cavv' => $data['cavv'] ?? '',
                    'protocolVersion' => $data['protocolVersion'] ?? '',
                    'directoryServerTransactionId' => $data['directoryServerTransactionId'] ?? '',
                ];
            }

            $response = $this->culqiService->createCard($reqBody);

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
