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
Route::get('diary/create', 'DiaryController@create')->name('diary.create'); 
//'diary/create'はwebのURLを自分で作成したということ。自分で名前を変えたければそれも可能。


// class Car {
// 	function start(){

// 	}
// }

// $car = new Car();
// $car->start();
// //という８行必要だったのが、
// Car::start();
// //だけで良くなるというやつ