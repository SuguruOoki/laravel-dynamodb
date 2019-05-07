<?php

require '../vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;

$sdk = new Aws\Sdk([
    'endpoint' => getenv('DYNAMODB_LOCAL_ENDPOINT'),
    'region'   => getenv('DYNAMODB_REGION'),
    'version'  => 'latest',
    'credentials' => [
        'key'    => getenv('DYNAMODB_KEY'),
        'secret' => getenv('DYNAMODB_SECRET')
    ],
]);

$dynamodb = $sdk->createDynamoDb();

$params = [
    'TableName' => 'DynamoDb',
    'KeySchema' => [
        [
            'AttributeName' => 'kigyo_id',
            'KeyType' => 'HASH'
        ],
        [
            'AttributeName' => 'host',
            'KeyType' => 'RANGE'
        ]
    ],
    'AttributeDefinitions' => [
        [
            'AttributeName' => 'kigyo_id',
            'AttributeType' => 'N'
        ],
        [
            'AttributeName' => 'host',
            'AttributeType' => 'S'
        ],

    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits'  => 10,
        'WriteCapacityUnits' => 10
    ]
];

try {
    $result = $dynamodb->createTable($params);
    echo 'Created table.  Status: ' .
        $result['TableDescription']['TableStatus'] ."\n";

} catch (DynamoDbException $e) {
    echo "Unable to create table:\n";
    echo $e . "\n";
}

