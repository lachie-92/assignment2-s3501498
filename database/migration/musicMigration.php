<?php
require 'vendor/autoload.php'; // Load the AWS SDK for PHP
require 'app/Database.php';
require 'app/S3.php';

use App\Database;
use App\S3;
use Aws\Exception\AwsException;

// Create a DynamoDB client instance
$client = Database::client();

// Create an S3 instance
$s3 = new S3;

// Create music table if it doesn't exist
$tableName = 'music';
$params = [
    'TableName' => $tableName,
    'AttributeDefinitions' => [
        ['AttributeName' => 'id', 'AttributeType' => 'S'],
    ],
    'KeySchema' => [
        ['AttributeName' => 'id', 'KeyType' => 'HASH'],
    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 5,
        'WriteCapacityUnits' => 5,
    ],
];
try {
    $client->createTable($params);
} catch (AwsException $e) {
    // If the table already exists, drop it and create it again
    if ($e->getAwsErrorCode() === 'ResourceInUseException') {
        $client->deleteTable(['TableName' => $tableName]);
        $client->waitUntil('TableNotExists', ['TableName' => $tableName]);
        $client->createTable($params);
    } else {
        echo "Error creating table: " . $e->getMessage();
        return;
    }
}

// Read data from a2.json file
$json = file_get_contents('data/a2.json');
$data = json_decode($json, true);

// Insert records into music table
foreach ($data['songs'] as $song) {
    // Upload image to S3 and get the URL
    $file_name = substr($song['img_url'], strrpos($song['img_url'], '/') + 1);
    // Download and store file.
    $file = file_get_contents($song['img_url']);
    file_put_contents("storage/music_images/$file_name", $file);

    try {
        $result = $s3->putObject("music_images/$file_name", "storage/music_images/$file_name");
    } catch (AwsException $e) {
        echo "Error uploading image to S3: " . $e->getMessage();
        return;
    }
    $imgUrl = $result['ObjectURL'];

    // Insert record into music table
    $params = [
        'TableName' => $tableName,
        'Item' => [
            'id' => ['S' => uniqid()],
            'title' => ['S' => $song['title']],
            'artist' => ['S' => $song['artist']],
            'year' => ['N' => $song['year']],
            'web_url' => ['S' => $song['web_url']],
            'img_url' => ['S' => $imgUrl],
        ],
    ];
    try {
        $client->putItem($params);
    } catch (AwsException $e) {
        echo "Error inserting record into music table: " . $e->getMessage();
        return;
    }
}

echo "Table and records created successfully.";
