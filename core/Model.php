<?php

namespace core;

use PDO;
use app\Config;

/**
 * Base model
 */
abstract class Model
{
  
  /**
   * Get the PDO database connection
   * 
   * @return mixed
   */
  protected static function getDB()
  {
    static $db = null;

    if ($db === null) {
      $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME;
      $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

      // Throw an exception when an error occurs
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
      return $db;
    }
  }
}