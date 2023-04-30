<?php
require_once 'models/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getCurrentUser()
    {
        session_start();

        if (!isset($_SESSION['email'])) {
            // User is not logged in
            return null;
        }

        $email = $_SESSION['email'];
        $password = $_SESSION['password'];

        return $this->userModel->readUser($email, $password);
    }

    public function login()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->readUser($email, $password);
            if ($user !== null) {
                session_start();
                $_SESSION['user'] = $user; // Store the $user array in the session

                // Pass $user to the dashboard view
                header('Location: /dashboard');
                exit;
            } else {
                $error_message = "Invalid email or password.";
                // Pass $error_message to the login view
                include('views/login.php');
                exit;
            }
        } else {
            $error_message = "Invalid email or password.";
            // Pass $error_message to the login view
            include('views/login.php');
            exit;
        }
    }
}
