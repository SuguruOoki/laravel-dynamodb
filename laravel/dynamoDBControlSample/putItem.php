<?php
require 'DynamoDbController.php';

DynamoDb::putItem("DynamoDb", array(
    "kigyo_id"   => array(
        "N" => 1234567
    ),
    "host" => array(
        "S" => "山田花子"
    )
));

// スキャンして検索
// $sample = DynamoDb::scan("DynamoDb", $kind="N");

// var_dump($sample);
// クエリで検索
$sample = DynamoDb::query("DynamoDb", $type = 1234567, $fromDate = "2016-01-01 00:00:00", $toDate = "2019-12-31 23:59:59");
var_dump($sample);
