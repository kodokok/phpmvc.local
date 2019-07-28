<?php

/**
 * Front controller
 */

/**
 * Composer Autoloader
 */
require_once '../vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('core\Error::errorHandler');
set_exception_handler('core\Error::exceptionHandler');

/* 
Routing 
*/
$router = new core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'admin']);

// Dispath the route from the query string
$router->dispatch($_SERVER['QUERY_STRING']);