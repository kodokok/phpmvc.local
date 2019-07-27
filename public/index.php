<?php

// echo 'Requested URL = "' .  $_SERVER['QUERY_STRING'] . '"';

/* 
Routing 
*/
require '../core/Router.php';

$router = new Router();

echo get_class($router);
