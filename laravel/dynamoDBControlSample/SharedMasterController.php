<?php
require '../vendor/autoload.php';
use Aws\Common\Aws;
use Aws\DynamoDb\DynamoDbClient;

/**
 * DynamoDbの操作用にAWS-SDKを使って
 * 操作をラップしたクラス。
 * NOTE: aws-adk-php(composer install) の version 3 を前提としている。
 * version upが必要な際には、composer ファイル側を書き換えること 
 */
class DynamoDb
{
    // aws設定
    public $config = array(
        'endpoint' => getenv('DYNAMODB_LOCAL_ENDPOINT'),
        'region'   => getenv('DYNAMODB_REGION'),
        'version'  => 'latest',
        'credentials' => [
            'key'    => getenv('DYNAMODB_KEY'),
            'secret' => getenv('DYNAMODB_SECRET')
        ]
    );

    /**
     * @param string $table テーブル名
     * @param array  $items アイテム名
     * @return void
     */
    public function putItem(string $table, array $items)
    {
        $client = new DynamoDbClient($this->config);

        $client->putItem(array(
            "TableName" => $table,
            "Item"      => $items,
        ));
    }

    /**
     * 条件を指定して全件検索を行うメソッド。
     *
     * @param  mixed $kind   検索に使うキーの内容
     * @param  string $table 検索するテーブル名
     * @return iterator 検索結果のイテレータ
     */
    public function scan($kind, string $table='dynamoDb')
    {
        $client = new DynamoDbClient(self::$config);

        $iterator = $client->getIterator('Scan', array(
            'TableName' => $table,
            'ScanFilter' => array(
                'type' => array(
                    'AttributeValueList' => array(
                        array(
                            'N'=> $kind
                        )
                    ),
                    'ComparisonOperator' => 'EQ' // イコール
                ),
            )
        ));
        return $iterator;
    }

    public static function query(string $table, $type, $fromDate, $toDate)
    {
        $client = new DynamoDbClient(self::$config);

        $iterator = $client->getIterator('Query', array(
            "TableName" => $table,
            "KeyConditions" => array(
                "datetime" => array(
                    "AttributeValueList" => array(
                        array(
                            'S' => $fromDate
                        ),
                        array(
                            'S' => $toDate
                    ),
                    'ComparisonOperator' => 'BETWEEN'
                ),
                "kigyo_id" => array(
                    "AttributeValueList" => array(
                        array(
                            'N' => $type
                        ),
                    ),
                    "ComparisonOperator" => "EQ",
                ),
            ),
            )
        ));
        return $iterator;
    }
}
