<?php
require '../vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    'endpoint' => 'http://dynamodb:8000',
    'region'   => 'localhost:8000',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'DynamoDb';

$seed_file = 'sharedmaster.json';
$shared_master = file_get_contents($seed_file);

$params = [
    'TableName' => $tableName,
    'Item'      => $marshaler->marshalJson($shared_master)
];

// putItemする処理
try {
    $result = $dynamodb->putItem($params);
    var_dump($result);
    // echo 'Added Shared Master: ' . $shared_master . "\n";
} catch (DynamoDbException $e) {
    echo "Unable to add Shared Master:\n";
    echo $e . "\n";
}
