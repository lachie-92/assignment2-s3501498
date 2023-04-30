<?php

// Load the application routes
require_once('routes.php');

// require_once 'controllers/UserController.php';

// $userController = new UserController();

// if (isset($_GET['page'])) {
//     $page = $_GET['page'];
// } else {
//     $page = 'home';
// }

// switch ($page) {
//     case 'home':
//         require_once 'views/home.php';
//         break;
//     case 'register':
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $userController->login();
//         } else {
//             include 'views/register.php';
//             break;
//         }
//     case 'login':
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $userController->login();
//         } else {
//             include 'views/login.php';
//             break;
//         }
//     case 'dashboard':
//         $user = $userController->getCurrentUser();
//         if (!$user) {
//             header('Location: index.php?page=login');
//             exit();
//         }
//     default:
//         header('HTTP/1.0 404 Not Found');
//         require_once 'views/404.php';
//         break;
// }
