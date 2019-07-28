<?php

/**
 * Front controller
 */

/**
 * Composer Autoloader
 */
require_once '../vendor/autoload.php';

/* 
Routing 
*/
$router = new core\Router();

//echo get_class($router);

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
// $router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'admin']);

// Display the routing table
// echo '<pre>';
// var_dump($router->getRoutes());
// echo htmlspecialchars(print_r($router->getRoutes(), true));
// echo '</pre>';


// Match the requested route
// $url = $_SERVER['QUERY_STRING'];

// if ($router->match($url)) {
//   echo '<pre>';
//   var_dump($router->getParams());
//   echo '</pre>';
// } else {
//   echo "No route found for URL '$url";
// }
$router->dispatch($_SERVER['QUERY_STRING']);