<?php

namespace App\Services;

use Culqi\Culqi;
use App\Config\Config;

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
}
