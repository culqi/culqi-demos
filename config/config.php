<?php

namespace App\Config;

final class Config
{
  public const DATABASE_HOST = 'localhost';
  public const DATABASE_NAME = 'my_database';
  public const DATABASE_USER = 'root';
  public const DATABASE_PASSWORD = 'password';

  public const API_BASE_URL = 'https://api.example.com';
  public const APP_ENV = 'production';

  // * Culqi Config
  public const PUBLIC_KEY = '<<LLAVE PÚBLICA>>';
  public const SECRET_KEY = '<<LLAVE PRIVADA>>';
  public const RSA_ID = '<<RSA ID>>';
  public const RSA_PUBLIC_KEY = '<<LLAVE PúBLICA RSA>>';
  public const EMAIL_CUSTOMER = '<<EMAIL_CUSTOMER>>';
  public const ACTIVE_ENCRYPT = false;
}
