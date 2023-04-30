<?php
require_once 'models/MusicModel.php';

class MusicController
{
    private $musicModel;

    public function __construct()
    {
        $this->musicModel = new MusicModel();
    }

    public function getMusicDetails($title, $artist, $year)
    {
        // Call the readMusic method from the music model
        return $this->musicModel->readMusic($title, $artist, $year);
    }

    public function query()
    {
        // Get the query parameters
        $title = isset($_GET['Title']) ? $_GET['Title'] : '';
        $artist = isset($_GET['Artist']) ? $_GET['Artist'] : '';
        $year = isset($_GET['Year']) ? $_GET['Year'] : '';

        // Get the music items from the database
        $musicItems = $this->musicModel->readMusic($title, $artist, $year);

        // Return the music items as JSON
        header('Content-Type: application/json');
        echo json_encode($musicItems);
    }

}
