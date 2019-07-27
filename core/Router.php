<?php

/**
 * Router class
 */
class Router 
{
  /**
   * Associative array of routes (the routing table)
   * @var array
   */
  protected $routes = [];

  /**
   * Add a route to the routing table
   * 
   * @param string $route The route URL
   * @param array  $params Parameters (conroller, action, etc.)
   */
  public function add($route, $params)
  {
    $this->routes[$route] = $params;
  }

  /**
   * Get all the routes from the routing table
   * 
   * @return array
   */
  public function getRoutes()
  {
    return $this->routes;
  }
  
}