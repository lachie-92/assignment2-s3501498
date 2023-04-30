<?php

require 'vendor/autoload.php';

use App\Database;
use Aws\DynamoDb\Exception\DynamoDbException;

class MusicModel
{
    private $dynamodb;
    private $tableName = 'music';

    public function __construct()
    {
        $this->dynamodb = Database::client();
    }


    public function getMusicById($id)
    {
        $params = [
            'TableName' => $this->tableName,
            'FilterExpression' => 'contains(id, :id)',
            'ExpressionAttributeValues' => [
                ':id' => ['S' => $id],
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
            echo "Unable to get music:\n";
            echo $e->getMessage() . "\n";
            return null;
        }
    }


    public function getMusicByTitle($title)
    {
        $params = [
            'TableName' => $this->tableName,
            'FilterExpression' => 'contains(Title, :title)',
            'ExpressionAttributeValues' => [
                ':title' => ['S' => $title],
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
            echo "Unable to get music:\n";
            echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function getMusicByArtist($artist)
    {
        $params = [
            'TableName' => $this->tableName,
            'FilterExpression' => 'contains(Artist, :artist)',
            'ExpressionAttributeValues' => [
                ':artist' => ['S' => $artist],
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
            echo "Unable to get music:\n";
            echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function getMusicByYear($year)
    {
        $params = [
            'TableName' => $this->tableName,
            'FilterExpression' => 'Year = :year',
            'ExpressionAttributeValues' => [
                ':year' => ['N' => $year],
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
            echo "Unable to get music:\n";
            echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function readMusic($title, $artist, $year)
    {
        $params = [
            'TableName' => $this->tableName,
            'Select' => 'ALL_ATTRIBUTES',
        ];

        $filterExpressions = [];
        $expressionAttributeValues = [];

        if (!empty($title)) {
            $filterExpressions[] = '#t = :title';
            $expressionAttributeValues[':title'] = ['S' => $title];
            $params['ExpressionAttributeNames']['#t'] = 'title';
        }

        if (!empty($artist)) {
            $filterExpressions[] = '#a = :artist';
            $expressionAttributeValues[':artist'] = ['S' => $artist];
            $params['ExpressionAttributeNames']['#a'] = 'artist';
        }

        if (!empty($year)) {
            $filterExpressions[] = '#y = :year';
            $expressionAttributeValues[':year'] = ['N' => $year];
            $params['ExpressionAttributeNames']['#y'] = 'year';
        }

        // Check if filter expressions are added
        if (count($filterExpressions) > 0) {
            // Modify params to include filter expression and attribute values
            $params['FilterExpression'] = implode(' AND ', $filterExpressions);
            $params['ExpressionAttributeValues'] = $expressionAttributeValues;
        }
    
        try {
            $result = $this->dynamodb->scan($params);
            $items = [];
            foreach ($result['Items'] as $item) {
                $music = [];
                foreach ($item as $key => $value) {
                    $music[str_replace('#', '', $key)] = $value[array_keys($value)[0]];
                }
                $items[] = $music;
            }
            return $items;
        } catch (DynamoDbException $e) {
            echo "Unable to read music:\n";
            echo $e->getMessage() . "\n";
            return null;
        }
    }
}
