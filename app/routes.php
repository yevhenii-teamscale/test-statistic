<?php

use Bramus\Router\Router;

$router = new Router();

$router->setNamespace('\App\Controllers');

$router->get('/', 'HomeController@index');
$router->post('/statistic/file', 'StatisticController@index');


$router->run();
