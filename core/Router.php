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
   * Parameters from the matched route
   * @var array
   */
  protected $params = [];

  /**
   * Add a route to the routing table
   * 
   * @param string $route The route URL
   * @param array  $params Parameters (conroller, action, etc.)
   */
  public function add($route, $params = [])
  {
    // Convert the route to a regular expression: escape forward slashes
    $route = preg_replace('/\//', '\\/', $route);

    // Convert variable e.g {controller}
    $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

    // Convert variables with custom regular expressions
    $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

    // Add start and end delimiters, and case insensitive flag;
    $route = '/^' . $route . '$/i';

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

  /**
   * Match the route to the routes in the routing table, setting the $params
   * propert if a route is found.
   * 
   * @param string $url The route URL
   * 
   * @return boolean true if a match found, false otherwise
   */
  public function match($url)
  {
    // foreach ($this->routes as $route => $params) {
    //   if ($url == $route) {
    //     $this->params = $params;
    //     return true;
    //   }
    // }

    // Match to the fixed URL format /controller/action
    // $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
    foreach ($this->routes as $route => $result) {
      if (preg_match($route, $url, $matches)) {
        // get named capture group values
        // $result = [];

        foreach ($matches as $key => $match) {
          if (is_string($key)) {
            $result[$key] = $match;
          }
        }

        $this->params = $result;
        return true;
      }
    }

    return false;
  }
  
  /**
   * Get currently matched parameters
   * 
   * @return array
   */
  public function getParams()
  {
    return $this->params;
  }
}