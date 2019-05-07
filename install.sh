#!/bin/sh

echo 'DynamoDBのテーブルのテンプレートをコピー'
cp -f dynamodb/table_template/accesskey_localhost:8000.db dynamodb/data/
echo 'DynamoDBのテーブルのテンプレートコピー終了'

echo 'laravelの設定をスタート'
cp -f env-template/env-template laravel/.env

docker-compose build
docker-compose up -d
echo 'laravelの設定を終了'

echo 'aws の設定をスタート'
cp -rf env-template/aws-config/ laravel/.aws/
echo 'aws の設定を終了'
