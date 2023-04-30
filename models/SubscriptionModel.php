<?php
require 'vendor/autoload.php';

use App\Database;
use Aws\DynamoDb\Exception\DynamoDbException;


class SubscriptionModel
{
    private $dynamodb;
    private $tableName = 'subscription';

    public function __construct()
    {
        $this->dynamodb = Database::client();
    }

    public function getUserSubscriptions($email)
    {
        $params = [
            'TableName' => $this->tableName,
            'FilterExpression' => 'email = :email',
            'ExpressionAttributeValues' => [
                ':email' => ['S' => $email],
            ]
        ];

        try {
            $result = $this->dynamodb->scan($params);
            if ($result['Count'] > 0) {
                return $result['Items'];
            } else {
                return null;
            }
        } catch (DynamoDbException $e) {
            echo "Unable to read subscription:\n";
            echo $e->getMessage() . "\n";
            return null;
        }
    }


    public function createSubscription($musicId, $userEmail)
    {

        $params = [
            'TableName' => $this->tableName,
            'Item' => [
                'music_id' => [
                    'S' => $musicId
                ],
                'email' => [
                    'S' => $userEmail
                ]
            ]
        ];

        try {
            $result = $this->dynamodb->putItem($params);
            return ['success' => true];
        } catch (DynamoDbException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function deleteSubscription($musicId, $userEmail)
    {
        $params = [
            'TableName' => $this->tableName,
            'Key' => [
                'music_id' => [
                    'S' => $musicId
                ],
                'email' => [
                    'S' => $userEmail
                ]
            ]
        ];
        try {
            $result = $this->dynamodb->deleteItem($params);
            return ['success' => true];
        } catch (DynamoDbException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
