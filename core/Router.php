<?php

namespace core;

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

  /**
   * Dispatch the route, creating the object and running the action method
   * 
   * @param string $url The route URL
   * 
   * @return void
   */
  public function dispatch($url)
  {
    $url = $this->removeQueryStringVariables($url);

    if ($this->match($url)) {
      $controller = $this->params['controller'];
      $controller = $this->convertToStudlyCaps($controller);
      // $controller = "app\controllers\\$controller";
      $controller = $this->getNamespace() . $controller;

      if (class_exists($controller)) {
        $controller_object = new $controller($this->params);
        
        $action = $this->params['action'];
        $action = $this->convertToCamelCase($action);

        if (is_callable([$controller_object, $action])) {
          $controller_object->$action();
        } else {
          // echo "Method $action (in controller $controller) not found!";
          throw new \Exception("Method $action (in controller $controller) not found!");
        }
      } else {
        // echo "Controller class $controller not found!";
        throw new \Exception("Controller class $controller not found!");
      }
    } else {
      // echo 'No route matched.';
      throw new \Exception('No route matched.', 404);
    }
  }

  /**
   * Convert the string hypens to StudlyCaps,
   * e.g. post-authors => PostAuthors
   * 
   * @param string $string The string to convert
   * 
   * @return string
   */
  protected function convertToStudlyCaps($string)
  {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
  }

  /**
   * Convert the string hypens to camelCase,
   * e.g. add-new => AddNew
   * 
   * @param string $string The string to convert
   * 
   * @return string
   */
  protected function convertToCamelCase($string)
  {
    return lcfirst($this->convertToStudlyCaps($string));
  }

  /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     * example:
     *
     *   URL                           $_SERVER['QUERY_STRING']  Route
     *   -------------------------------------------------------------------
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *   localhost/posts?page=1        posts&page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index&page=1        posts/index
     *
     * A URL of the format localhost/?page (one variable name, no value) won't
     * work however. (NB. The .htaccess file converts the first ? to a & when
     * it's passed through to the $_SERVER variable).
     *
     * @param string $url The full URL
     *
     * @return string The URL with the query string variables removed
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present
     * 
     * @return string The request URL
     */
    protected function getNamespace()
    {
      $namespace = 'app\controllers\\';

      if (array_key_exists('namespace', $this->params)) {
        $namespace .= $this->params['namespace'] . '\\';
      }

      return $namespace;
    }
}