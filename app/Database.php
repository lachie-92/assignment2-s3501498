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
                    'key' => 'AKIAY7MZXWYZ5P4FBOBB',
                    'secret' => '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',
                ],
            ]);
        }

        return self::$client;
    }
}
