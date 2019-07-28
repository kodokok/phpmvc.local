<?php

namespace app\controllers\admin;

/**
 * User admin controller
 */

class Users extends \core\Controller
{
  /**
   * Before filter
   * 
   * @return void
   */
  protected function before()
  {
    // Make sure an admin user has logged in fore example
    // return false;
  }

  /**
   * Show the index page
   * 
   * @return void
   */
  public function indexAction()
  {
    echo 'User admin index controller!';
  }

}