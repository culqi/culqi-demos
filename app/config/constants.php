<?php

namespace App\Config;

final class Constants
{
  public const EMAIL_REGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
  public const PASSWORD_MIN_LENGTH = 8;
  public const FORMAT_JSON = 'json';
}