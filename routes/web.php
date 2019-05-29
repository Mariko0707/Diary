<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// get('URLリクエスト', '対象コントローラー＠対象メソッド')
Route::get('/', 'DiaryController@index')->name('diary.index'); //追加
// オブジェクト指向のクラスメソッド
// クラス名::メソッド
// オブジェクト->メソッド
Route::group(['middleware' => 'auth'], function(){
	//groupのグルーピング
	//ログインの中でしか見せたくないものは全てこの中に入れておく！！！大事！！！
	Route::get('diary/create', 'DiaryController@create')->name('diary.create'); //投稿画面
	//'diary/create'はwebのURLを自分で作成したということ。自分で名前を変えたければそれも可能。
	Route::post('diary/create', 'DiaryController@store')->name('diary.create');//保存処理

	Route::get('diary/{id}/edit', 'DiaryController@edit')->name('diary.edit'); // 編集画面
	Route::put('diary/{id}/update', 'DiaryController@update')->name('diary.update'); //更新処理

	Route::delete('diary/{id}/delete', 'DiaryController@destroy')->name('diary.destroy');//削除処理
	//{}は対応するメソッドの引数になる

	Route::get('mypage', 'DiaryController@mypage')->name('diary.mypage');

	Route::post('diary/{id}/like', 'DiaryController@like')->name('diary.like');
    Route::post('diary/{id}/dislike', 'DiaryController@dislike')->name('diary.dislike');

});


//---------------------------------------------
//RESTFull設計
//---------------
//GET データ取得
//POST 作成
//PATCH 更新
//DELETE 削除
//↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//localhost:8000/aaa ←GET
//localhost:8000/aaa ←POST
//localhost:8000/aaa ←PATCH
//localhost:8000/aaa ←DELETE
//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
//これをすることで、URLが短縮され楽になる。
//---------------------------------------------

// class Car {
// 	function start(){

// 	}
// }

// $car = new Car();
// $car->start();
// //という８行必要だったのが、
// Car::start();
// //だけで良くなるというやつ


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home'); //不必要なため消去









