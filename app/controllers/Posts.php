<?php

namespace app\controllers;

use \core\View;
use \app\models\Post;

/**
 * Posts controller
 */

class Posts extends \core\Controller
{

  /**
   * Show the index page
   * 
   * @return void
   */
  public function indexAction()
  {
    // echo 'Hello from the index action in the Posts controller!';
    $posts = Post::getAll();

    View::renderTemplate('Posts/index.html', [
      'posts' => $posts
    ]);
  }

  /**
   * Show the add new page
   * 
   * @return void
   */
  public function Action()
  {
    echo 'Hello from the addNew action in the Posts controller!';
  }

  /**
   * Show the edit page
   * 
   * @return void
   */
  public function editAction()
  {
    echo 'Hello from the edit action in the Posts controller!';
    echo '<p> Route parameters: <pre>' . 
    htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
  }
}