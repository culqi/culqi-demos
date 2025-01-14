<?php

namespace App\Services;

use App\Config\Config;
use Culqi\Culqi;

class CulqiService
{
  private Culqi $culqi;

  public function __construct()
  {    
    $this->culqi = new Culqi([
      'api_key' => Config::SECRET_KEY
    ]);
  }

  public function createCharge(array $data, ?array $encryptionParams = null): array
  {
    try {
      return $encryptionParams
        ? $this->culqi->Charges->create($data, $encryptionParams)
        : $this->culqi->Charges->create($data);
    } catch (\Exception $e) {
      throw new \Exception("Charge creation failed: " . $e->getMessage());
    }
  }
  public function createOrder(array $data): array
  {
    try {
      return $this->culqi->Orders->create($data);
    } catch (\Exception $e) {
      throw new \Exception("Order creation failed: " . $e->getMessage());
    }
  }
  public function createCustomer(array $data, ?array $encryptionParams = null)
  {
    try {
      $response = $encryptionParams
        ? $this->culqi->Customers->create($data, $encryptionParams)
        : $this->culqi->Customers->create($data);

      return $response;
    } catch (\Exception $e) {
      throw new \Exception("Customer creation failed: " . $e->getMessage());
    }
  }

  public function createCard(array $data): array
  {
    try {
      return $this->culqi->Cards->create($data);
    } catch (\Exception $e) {
      throw new \Exception("Customer creation failed: " . $e->getMessage());
    }
  }
  public function createToken(array $data, ?array $encryptionParams = null): array
  {
    try {
      return $encryptionParams
        ? $this->culqi->Tokens->create($data, $encryptionParams)
        : $this->culqi->Tokens->create($data);
    } catch (\Exception $e) {
      throw new \Exception("Customer creation failed: " . $e->getMessage());
    }
  }
}