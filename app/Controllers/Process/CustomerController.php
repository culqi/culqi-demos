<?php

namespace App\Controllers\Process;

use App\Services\CulqiService;
use App\Config\Config;
use App\Repositories\ProfileRepository;
use App\Services\ProfileService;

class CustomerController
{
    private CulqiService $culqiService;
    private ProfileService $profileService;

    public function __construct()
    {
        $this->culqiService = new CulqiService();
        $this->profileService = new ProfileService(new ProfileRepository);
    }

    public function handleRequest(): void
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                throw new \Exception("Invalid request method");
            }

            $data = $this->getJsonInput();

            $reqBody = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'address' => $data['address'],
                'address_city' => $data['address_city'],
                'country_code' => $data['country_code'],
                'phone_number' => $data['phone_number'],
            ];


            $encryptionParams = Config::ACTIVE_ENCRYPT
                ? [
                    "rsa_public_key" => Config::RSA_PUBLIC_KEY,
                    "rsa_id" => Config::RSA_ID
                ]
                : null;

            $response = $this->culqiService->createCustomer($reqBody, $encryptionParams);

            $user = $_SESSION['user'];
            $user_id = $user['id_user'];

            $customerDetail = [
                'first_name' => $response->antifraud_details->first_name,
                'last_name' => $response->antifraud_details->last_name,
                'email' => $response->email,
                'address' => $response->antifraud_details->address,
                'address_city' => $response->antifraud_details->address_city,
                'country_code' => $response->antifraud_details->country_code,
                'phone_number' => $response->antifraud_details->phone,
                'customer_code' => $response->id,
                'customer_email' => $response->email,
            ];


            $this->profileService->updateProfile($user_id, $customerDetail);

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

    private function sendJsonResponse($data): void
    {
        $json = json_encode($data);

        if ($json === false) {
            throw new \Exception("Error encoding JSON: " . json_last_error_msg());
        }

        header("Content-Type: application/json");
        echo $json;
        exit;
    }

    private function handleError(\Exception $e): void
    {
        error_log($e->getMessage());
        http_response_code(400);
        echo json_encode(["error" => $e->getMessage()]);
    }
}
