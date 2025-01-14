<?php

namespace App\Config;

final class Config
{
  public const DATABASE_HOST = 'localhost';
  public const DATABASE_NAME = 'my_database';
  public const DATABASE_USER = 'root';
  public const DATABASE_PASSWORD = 'password';

  public const API_BASE_URL = '<<URL_API_CULQI_V2>>';
  public const APP_ENV = 'production';
  public const CHECKOUT_URL = '<<URL_CHECKOUT>>';

  // * Culqi Config
  public const PUBLIC_KEY = '<<LLAVE PúBLICA>>';
  public const SECRET_KEY = '<<LLAVE PRIVADA>>';
  public const RSA_ID = '<<RSA ID>>';
  public const RSA_PUBLIC_KEY = '<<LLAVE PúBLICA RSA>>';
  public const EMAIL_CUSTOMER = '<<EMAIL_CUSTOMER>>';
  public const ACTIVE_ENCRYPT = false;
}