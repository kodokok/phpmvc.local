<?php

namespace app\controllers;

use \core\View;

/**
 * Home controller
 */

class Home extends \core\Controller
{
  /**
   * Before filter
   * 
   * @return void
   */
  protected function before()
  {
    // echo "(before) ";
    // return false;
  }

  /**
   * After filter
   * 
   * @return void
   */
  protected function after()
  {
    // echo " (after) ";
    // return false
  }

  /**
   * Show the index page
   * 
   * @return void
   */
  public function indexAction()
  {
    // echo 'Hello from the index action in the Home controller!';
    // View::render('Home/index.php', [
    //   'name' => 'Dave',
    //   'colours' => ['red', 'green', 'blue']
    // ]);
    View::renderTemplate('Home/index.html', [
      'name' => 'Dave',
      'colours' => ['red', 'green', 'blue']
    ]);
  }

}