<?php

require 'vendor/autoload.php'; // Load the AWS SDK for PHP
require 'app/Database.php';

use app\Database;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;

// Create a DynamoDB client instance
$client = Database::client();

$tableName = 'login';

try {
    // Check if the table exists
    $result = $client->describeTable([
        'TableName' => $tableName,
    ]);

    // If the table exists, drop it
    $client->deleteTable([
        'TableName' => $tableName
    ]);

    // Wait for the table to be deleted before creating it again
    $client->waitUntil('TableNotExists', array('TableName' => $tableName));

} catch (DynamoDbException $e) {
    // If the table doesn't exist, do nothing
    if ($e->getAwsErrorCode() !== 'ResourceNotFoundException') {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}

// Create the login table
$client->createTable([
    'TableName' => $tableName,
    'AttributeDefinitions' => [
        [
            'AttributeName' => 'email',
            'AttributeType' => 'S'
        ],
        [
            'AttributeName' => 'user_name',
            'AttributeType' => 'S'
        ],
    ],
    'KeySchema' => [
        [
            'AttributeName' => 'email',
            'KeyType' => 'HASH'
        ],
        [
            'AttributeName' => 'user_name',
            'KeyType' => 'RANGE'
        ]
    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 5,
        'WriteCapacityUnits' => 5
    ]
]);

// Wait for the table to be created before adding entities
$client->waitUntil('TableExists', array('TableName' => $tableName));

// Add 10 entities to the login table
for ($i = 0; $i <= 9; $i++) {
    $item = [
        'email' => ['S' => 's3501498'.$i.'@student.rmit.edu.au'],
        'user_name' => ['S' => 'Lachlan Young'.$i],
        'password' => ['S' => $i.'01234']
    ];
    $client->putItem([
        'TableName' => $tableName,
        'Item' => $item
    ]);
}

echo "Login table and 10 entities created successfully!";
