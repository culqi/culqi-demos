<?php
namespace App\Providers;

use Filebase\Database;

class FilebaseProvider
{
  private static ?Database $instance = null;

  public static function getInstance($folder): Database
  {
    if (self::$instance === null) {
      self::$instance = new Database([
        'dir' => __DIR__ . '/../../storage/filebase/' . $folder,
        'format' => \Filebase\Format\Json::class,
        'cache' => false,
      ]);
    }



    return self::$instance;
  }
}