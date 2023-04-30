<?php

namespace App;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;

class Database
{
    private static $client;

    /**
     * Get the DynamoDB client instance.
     *
     * @return DynamoDbClient
     */
    public static function client()
    {
        if (!self::$client) {
            // Load the AWS credentials from the JSON file
            $awsCredentials = json_decode(file_get_contents(__DIR__ . '/../aws.json'), true);

            self::$client = new DynamoDbClient([
                'region' => 'ap-southeast-2',
                'version' => 'latest',
                'credentials' => [
                    'key' => $awsCredentials['access_key'],
                    'secret' => $awsCredentials['secret_key'],
                ],
            ]);
        }

        return self::$client;
    }
}
