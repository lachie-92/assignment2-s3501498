<?php
require_once 'models/UserModel.php';
require_once 'models/SubscriptionModel.php';
require_once 'models/MusicModel.php';

class HomeController
{
    private $userModel;
    private $subscriptionModel;
    private $musicModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->subscriptionModel = new SubscriptionModel();
        $this->musicModel = new MusicModel();

    }

    public function index()
    {
        // Load the home view
        include('views/home.php');
    }

    public function login()
    {
        // Load the login view
        include('views/login.php');
    }

    public function register()
    {
        // Load the register view
        include('views/register.php');
    }

    public function dashboard() {
        session_start();
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];

            // Get the user's data from the database using the user model
            $user = $this->userModel->readUser($user['email']['S'], $user['password']['S']);
            $subscribedMusic = $this->subscriptionModel->getUserSubscriptions($user['email']['S']);

            $musicRecords = array();
            foreach ($subscribedMusic as $item) {
                $musicId = $item['music_id']['S'];
            
                // Retrieve the music record for the subscribed item
                $musicRecord = $this->musicModel->getMusicById($musicId);

                $musicRecords[] = array(
                    'title' => $musicRecord[0]['title']['S'],
                    'artist' => $musicRecord[0]['artist']['S'],
                    'year' => $musicRecord[0]['year']['N'],
                    'id' => $musicRecord[0]['id']['S'],
                    'img_url' => $musicRecord[0]['img_url']['S'],
                );

            }

            include('views/dashboard.php');
        } else {
            // Redirect to login page if user is not logged in
            header('Location: /login');
            exit;
        }
    }
}
