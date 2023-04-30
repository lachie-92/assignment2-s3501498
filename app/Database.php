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
            self::$client = new DynamoDbClient([
                'region' => 'ap-southeast-2',
                'version' => 'latest',
                'credentials' => [
                    'key' => $_ENV['AWS_ACCESS_KEY_ID'],
                    'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'],
                ],
            ]);
        }

        return self::$client;
    }
}
