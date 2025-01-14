<?php
namespace App\Providers;

use Filebase\Database;

class FilebaseProvider
{
  private static array $instances = [];

  public static function getInstance(string $folder): Database
  {
    if (!isset(self::$instances[$folder])) {
      self::$instances[$folder] = new Database([
        'dir' => __DIR__ . '/../../storage/filebase/' . $folder,
        'format' => \Filebase\Format\Json::class,
        'cache' => false,
      ]);
    }

    return self::$instances[$folder];
  }
}