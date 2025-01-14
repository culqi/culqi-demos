<?php

namespace App\Controllers\Auth;

use App\Services\ProfileService;
use Exception;

class ProfileController
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }


    public function view()
    {
        if (isset($_SESSION['user'])) {
            view('auth/profile.view.php', [
                'title' => 'Profile'
            ]);
            return;
        }
        header('Location: /');
        view('index.view.php', [
            'title' => 'Home'
        ]);
    }

    public function update()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!isset($_SESSION['user'])) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado']);
                return;
            }

            $user = $_SESSION['user'];
            $user_id = $user['id_user'];

            $customerDetail = [
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'address' => $input['address'],
                'address_city' => $input['address_city'],
                'country_code' => $input['country_code'],
                'phone_number' => $input['phone_number'],
                'customer_code' => $input['customer_code'],
                'customer_email' => $input['customer_email'],
            ];


            $this->profileService->updateProfile($user_id, $customerDetail);

            http_response_code(200);
            return  ['message' => 'Customer updated successfully'];
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
