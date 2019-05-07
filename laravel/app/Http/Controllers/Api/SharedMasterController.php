<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DynamoDb;

class DynamoDbController extends Controller
{
    /**
     * 登録したレコードを全て見るメソッド
     */
    public function index() {
        return DynamoDb::all();
    }

    /**
     * kigyo_id と host を新規登録するメソッド。
     */
    public function store(Request $request) {
        $model           = new DynamoDb();
        $model->kigyo_id = $request->kigyo_id;
        $model->host     = $request->host;
        $model->save();
    }

    /**
     * kigyo_id を利用して、host を取得するメソッド
     */
    public function show(int $kigyo_id) {
        return DynamoDb::where('kigyo_id', $kigyo_id)->get();
    }

    /**
     * kigyo_id を使って、host のみ更新を行うメソッド
     */
    public function update(Request $request, int $kigyo_id) {
        $shared_master = DynamoDb::where('kigyo_id', $kigyo_id)->get();
        $shared_master->host = $request->host;
        $shared_master->save();
    }

    /**
     * kigyo_id を利用して、削除を行うメソッド
     */
    public function destroy(Request $request) {
        $shared_master = DynamoDb::where('kigyo_id', $request->kigyo_id)->get();
        $shared_master->delete();
    }
}
