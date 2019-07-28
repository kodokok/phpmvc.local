<?php

namespace app\models;

use PDO;

/**
 * Post model
 */
class Post extends \core\Model
{

  /**
   * Get all the posts as an associative array
   * 
   * @return array
   */
  public static function getAll()
  {
    try {
      $db = static::getDB();

      $stmt = $db->query('SELECT id, title, content FROM posts ORDER BY created_at');

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $result;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}