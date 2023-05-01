<?php
require 'vendor/autoload.php';
require 'app/Database.php';

use App\Database;
use Aws\DynamoDb\Exception\DynamoDbException;

class UserModel
{
    private $dynamodb;
    private $tableName = 'login';

    public function __construct()
    {
        $this->dynamodb = Database::client();
    }

    public function createUser($email, $password, $username)
    {
        $params = [
            'TableName' => $this->tableName,
            'Item' => [
                'email' => [
                    'S' => $email
                ],
                'password' => [
                    'S' => $password
                ],
                'user_name' => [
                    'S' => $username
                ]
            ]
        ];

        try {
            $result = $this->dynamodb->putItem($params);
        } catch (DynamoDbException $e) {
            echo "Unable to create user:\n";
            echo $e->getMessage() . "\n";
        }
    }

    public function checkEmail($email)
    {
        $params = [
            'TableName' => $this->tableName,
            'FilterExpression' => 'email = :email',
            'ExpressionAttributeValues' => [
                ':email' => ['S' => $email]
            ]
        ];
    
        try {
            $result = $this->dynamodb->scan($params);
            if ($result['Count'] > 0) {
                return $result['Items'][0];
            } else {
                return null;
            }
        } catch (DynamoDbException $e) {
            echo "Unable to read user:\n";
            echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function readUser($email, $password)
    {
        $params = [
            'TableName' => $this->tableName,
            'FilterExpression' => 'email = :email AND password = :password',
            'ExpressionAttributeValues' => [
                ':email' => ['S' => $email],
                ':password' => ['S' => $password]
            ]
        ];
    
        try {
            $result = $this->dynamodb->scan($params);
            if ($result['Count'] > 0) {
                return $result['Items'][0];
            } else {
                return null;
            }
        } catch (DynamoDbException $e) {
            echo "Unable to read user:\n";
            echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function updateUser($email, $password, $newPassword)
    {
        $params = [
            'TableName' => $this->tableName,
            'Key' => [
                'email' => [
                    'S' => $email
                ],
                'password' => [
                    'S' => $password
                ]
            ],
            'UpdateExpression' => 'set #password = :newPassword',
            'ExpressionAttributeNames' => [
                '#password' => 'password'
            ],
            'ExpressionAttributeValues' => [
                ':newPassword' => [
                    'S' => $newPassword
                ]
            ]
        ];

        try {
            $result = $this->dynamodb->updateItem($params);
            echo "User updated successfully!\n";
        } catch (DynamoDbException $e) {
            echo "Unable to update user:\n";
            echo $e->getMessage() . "\n";
        }
    }

    public function deleteUser($email, $password)
    {
        $params = [
            'TableName' => $this->tableName,
            'Key' => [
                'email' => [
                    'S' => $email
                ],
                'password' => [
                    'S' => $password
                ]
            ]
        ];

        try {
            $result = $this->dynamodb->deleteItem($params);
            echo "User deleted successfully!\n";
        } catch (DynamoDbException $e) {
            echo "Unable to delete user:\n";
            echo $e->getMessage() . "\n";
        }
    }
}
