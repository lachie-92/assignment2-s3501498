<?php

namespace App;

use Aws\S3\S3Client;

class S3
{
    private static $client;

    /**
     * Get the S3 client instance.
     *
     * @return S3Client
     */
    public static function client()
    {
        if (!self::$client) {
            // Load the AWS credentials from the JSON file
            $awsCredentials = json_decode(file_get_contents(__DIR__ . '/../aws.json'), true);
            self::$client = new S3Client([
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

    /**
     * Upload a file to an S3 bucket.
     *
     * @param string $key The S3 object key.
     * @param string $filePath The local file path.
     * @return array The result of the S3 putObject operation.
     */
    public static function putObject($key, $filePath)
    {
        $bucketName = 's3501498-music-app';

        $result = self::client()->putObject([
            'Bucket' => $bucketName,
            'Key' => $key,
            'SourceFile' => $filePath,
            'ACL' => 'public-read',
        ]);

        return $result;
    }
}
