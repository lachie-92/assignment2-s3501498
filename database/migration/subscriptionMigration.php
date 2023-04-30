<?php

require 'vendor/autoload.php'; // Load the AWS SDK for PHP
require 'app/Database.php';

use app\Database;
use Aws\DynamoDb\Exception\DynamoDbException;

// Create a DynamoDB client instance
$client = Database::client();

$tableName = 'subscription';

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
            'AttributeType' => 'S',
        ],
        [
            'AttributeName' => 'music_id',
            'AttributeType' => 'S',
        ],
    ],
    'KeySchema' => [
        [
            'AttributeName' => 'email',
            'KeyType' => 'HASH',
        ],
        [
            'AttributeName' => 'music_id',
            'KeyType' => 'RANGE',
        ],
    ],
    'BillingMode' => 'PAY_PER_REQUEST',
    'GlobalSecondaryIndexes' => [
        [
            'IndexName' => 'music_id-index',
            'KeySchema' => [
                [
                    'AttributeName' => 'music_id',
                    'KeyType' => 'HASH',
                ],
            ],
            'Projection' => [
                'ProjectionType' => 'ALL',
            ],
        ],
    ],
]);

// Wait for the table to be created before adding entities
$client->waitUntil('TableExists', array('TableName' => $tableName));

echo "Subscription table created successfully!";
