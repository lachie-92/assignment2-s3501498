<?php

// Load the controller classes
require_once('controllers/HomeController.php');
require_once('controllers/UserController.php');
require_once('controllers/MusicController.php');
require_once('controllers/SubscriptionController.php');

require_once('app/Router.php');

// Create a new Router instance
$router = new Router();

// Define the application routes
$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');

$router->get('/login', 'HomeController@login');
$router->post('/login', 'UserController@login');
$router->get('/register', 'HomeController@register');
$router->post('/register', 'UserController@store');

$router->get('/dashboard', 'HomeController@dashboard');

// Add the /query route
$router->get('/query', 'MusicController@query');

// Add the /subscription routes
$router->get('/subscribe', 'SubscriptionController@subscription');
$router->get('/unsubscribe', 'SubscriptionController@unsubscribe');


// Run the router
$router->run();
