<?php

namespace App\Services;

use App\Repositories\CardRepository;

class CardService
{
    private CardRepository $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function createCard($user_id, $card_details)
    {
        $this->cardRepository->createCard($user_id, $card_details);
    }

    public function listCards($user_id)
    {
        return $this->cardRepository->listCards($user_id);
    }

    public function deleteCard($cardId, $user_id)
    {
        return $this->cardRepository->deleteCard($cardId, $user_id);
    }
}
