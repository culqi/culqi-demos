<?php

namespace App\Repositories;

use App\Providers\FilebaseProvider;
use Exception;

class CardRepository
{
    public function createCard($user_id, $card_details)
    {
        try {
            $db = FilebaseProvider::getInstance('cards');
            $record = $db->get(uniqid());
            $record->id = $card_details['id'];
            $record->card_number = $card_details['card_number'];
            $record->token_id = $card_details['token_id'];
            $record->email = $card_details['email'];
            $record->creation_date = $card_details['creation_date'];
            $record->user_id = $user_id;
            $record->save();

            error_log('Registro creado exitosamente: ' . json_encode($record));
        } catch (Exception $e) {
            error_log('Error creando el registro: ' . $e->getMessage());
        }
    }
    public function deleteCard($cardId, $user_id)
    {
        try {
            $db = FilebaseProvider::getInstance('cards');
            $card = $db->query()
                ->where('id', '=', $cardId)
                ->andWhere('user_id', '=', $user_id);
            $card->delete();

            error_log('Registro eliminado exitosamente');
        } catch (Exception $e) {
            error_log('Error creando el registro: ' . $e->getMessage());
        }
    }
    public function listCards($user_id)
    {
        try {
            $db = FilebaseProvider::getInstance('cards');

            $cards = $db->query()->where('user_id', '=', $user_id)->results(true);

            return $cards ?: [];
        } catch (Exception $e) {
            error_log('Error listando los registros: ' . $e->getMessage());
            throw $e;
        }
    }
}
