<?php
require '../vendor/autoload.php';

date_default_timezone_set('UTC');
use Aws\DynamoDb\DynamoDbClient;

$client = DynamoDbClient::factory(array(
    'endpoint' => 'http://dynamodb:8000',
    'region'   => 'localhost:8000',
    'version'  => 'latest'
));

$result = $client->listTables([
    'ExclusiveStartTableName' => 'DynamoDb',
    'Limit' => 10,
]);
// var_dump($result);

var_dump($result['TableNames'], $client->getEndpoint());

