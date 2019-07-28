<?php

namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * View
 */
class View
{
  /**
   * Render a view file
   * 
   * @param string $view The view file
   * 
   * @return void
   */
  public static function render($view, $args = [])
  {
    extract($args, EXTR_SKIP);
    
    $file = "../app/views/$view"; // relative to core directory

    if (is_readable($file)) {
      require $file;
    } else {
      echo "$file not found";
    }
  }

  /**
   * Render a view template using Twig
   * 
   * @param string $view The view file
   * 
   * @return void
   */
  public static function renderTemplate($template, $args = [])
  {
    static $twig = null;

    if ($twig === null) {
      $loader = new FilesystemLoader('../app/views');
      $twig = new Environment($loader);
    }

    echo $twig->render($template, $args);
  }
}