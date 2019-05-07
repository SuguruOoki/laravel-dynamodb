# 概要

DynamoDBをAPIを通して操作するための環境と実装をしている。

# 使い方

## 初期実行コマンド

```
git clone git@github.com:SuguruOoki/laravel-dynamodb.git
cd laravel-dynamodb
chmod +x install.sh
sh install.sh
```

## APIの確認方法

dockerコンテナを立ち上げて、DynamoDbを作成した状態で
以下のURLにアクセスすると登録済みのレコードが全件出力される。

http://localhost:50080/api/dynamoDb

以下のURLからGUIベースで、テーブル一覧、テーブルの内容一覧を確認できる。
dynamodbadminを使用しているため、詳しくはそちらのリポジトリを参照のこと。

http://localhost:8001/

## 前提

### ディレクトリ構成

```
-- dynamoDbApi
 |
 -- dynamodb
 |
 -- env-template
 |
 -- laravel
 |
 -- nginx
 |
 -- php-fpm
```

### ディレクトリの役割

```
dynamodb/     ・・・dynamodbに関するファイル
env-template/ ・・・ 環境設定に必要なファイル
laravel/      ・・・ laravelのソースコード
nginx/        ・・・ nginx関連のファイル
php-fpm/      ・・・ php-fpm関連のファイル
```

### インフラの設定について

#### nginx

動く設定で動かしているだけなので、後々詳細なチューニングが必要

#### php-fpm

こちらもnginx に同じ。

### 利用しているライブラリなど

#### aws-sdk

aws-sdkをdynamodbにアクセスする際に利用。
composerにて管理。

#### baopham/laravel-dynamodb

dynamodbのフロントに立てるAPIを作るのにORMとして使っている。
Migrationについては、持っていないため、ORM以外の機能はない。
詳細については、公式に任せる。

https://github.com/baopham/laravel-dynamodb

# 注意

## サービス名の重複

dynamodb という名前のサービス名が被っていると、立ち上げに失敗する。
その場合は、適宜docker-compose.ymlファイルの名称などを調整すること

## ポートの重複

できるだけ重複しないようにポートを選択したが、
重複している場合には、docker-compose.ymlのポートを調節すること。
内部ポートまで触ると、動かなくなる可能性がある。

## キャッシュ

### 注意

1. Laravel5.2~ キャッシュがある時は、config/*.php以外の場所で使われるenv()は無効化（null）になる仕様になった
2. `php artisan key:generate` を実行し、全てのキャッシュを無効にしたつもりでも、Scheduler のキャッシュは無効にならないため、laravel/storage/framework 内にある `schedule-*` といったファイルを削除すること

### キャッシュをクリアするコマンド

#### composer のオートローディングなどを除いたキャッシュをクリアしたい場合

APIなど、Webサービスを使っていなくてビューがないのであれば、 view:clear はしなくてよい。
dynamoDbApiは管理画面ができない限りは必要ない。

```
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### オートローディングをしなおして、オプティマイズも実行してと、まるっとキャッシュを作り直したい場合

```
composer dump-autoload
php artisan clear-compiled
php artisan optimize
php artisan config:cache
```
