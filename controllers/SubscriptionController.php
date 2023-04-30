<?php
require_once 'models/SubscriptionModel.php';

class SubscriptionController
{
    private $subscriptionModel;

    public function __construct()
    {
        $this->subscriptionModel = new SubscriptionModel();
    }

    public function subscription()
    {
        session_start();

        // Get the query parameters
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $user = $_SESSION['user'];

        // Get the music items from the database
        $musicItems = $this->subscriptionModel->createSubscription($id, $user['email']['S']);
        // Return the music items as JSON
        header('Content-Type: application/json');
        echo json_encode($musicItems);
    }

    public function unsubscribe()
    {
        session_start();

        // Get the query parameters
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $user = $_SESSION['user'];

        // Get the music items from the database
        $response = $this->subscriptionModel->deleteSubscription($id, $user['email']['S']);

        if($response['success'] == true){
            header('Location: /dashboard');
        }
    }
}
