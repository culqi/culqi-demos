<?php

namespace App\Controllers\Card;

use App\Services\CardService;
use DateTime;
use Exception;

class CardController
{
    private CardService $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    public function create()
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

            $creationDate = new DateTime('@' . $input['creation_date'] / 1000);
            $formattedDate = $creationDate->format('d/m/Y H:i:s');

            $cardDetail = [
                'id' => $input['id'],
                'card_number' => $input['source']['card_number'],
                'token_id' => $input['source']['id'],
                'email' => $input['source']['email'],
                'creation_date' => $formattedDate,
            ];

            $this->cardService->createCard($user_id, $cardDetail);

            http_response_code(200);
            echo json_encode(['message' => 'Card creado exitosamente' . $input]);
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function list()
    {
        try {
            if (!isset($_SESSION['user'])) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado']);
                return;
            }

            $user = $_SESSION['user'];
            $user_id = $user['id_user'];

            return $this->cardService->listCards($user_id);
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function delete($cardId)
    {
        try {
            if (!isset($_SESSION['user'])) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado']);
                return;
            }

            $user = $_SESSION['user'];
            $user_id = $user['id_user'];

            return $this->cardService->deleteCard($cardId, $user_id);
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
