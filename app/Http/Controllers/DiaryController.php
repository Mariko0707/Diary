<?php

//頭文字を大文字にすること＋バックスラッシュに気をつける！
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Http\Requests\CreateDiary;
use Illuminate\Support\Facades\Auth;
//６行目があることで、他ファイルの内容を引き継げる
// ↑ require_once('別のファイル');のイケてる版

class DiaryController extends Controller
{
	public function index(){
		//public ＝　アクセス修飾子
		//クラスの外から引っ張ってくることが可能
			// dd('Hello Laravel');
			// ddを書いたらそのあとの処理は全て停止される！！動かしたければ必ず消すこと！
			//dump and die関数というLaravelに用意された関数
			//var_dumpとdieを組み合わせたもの
			//Laravel開発の必須ツールです

			//モデルファイルを使ってデータを取得する
			$diaries = Diary::with('likes')->orderBy('id', 'desc')->get();
			//orderByから後の記述をすることで、記事の更新順に上に来るように設定する
			// SELECT * FROM diaries WHERE 1を実行し$diariesに入れる
			//all()メソッド
			//CollectionをArrayに変換するtoArray()メソッドをチェインする
			//dd($diaries);

			//$diary = Diary::find(1)->toArray();
			//SELECT * FROM diaries WHERE id=1
			//dd($diary);



			return view('diaries.index',['diaries' => $diaries]);
			// view関数はresources/view/内にあるファイルを取得する関数
			// view（'ファイル名'）もしくは
			// view（’ファイル名.ファイル名')のように記述する
			// 例）view('welcome')
			// 例）view('diaries.edit')
			// ※ファイル名は.bladeの前のみ
			//view(③,[② => ①]);
			//①の変数を、②の変数名に変えて、③のviewへ送る

	}

	public function create(){
		//投稿画面
		return view('diaries.create');
	}

	public function store(CreateDiary $request){
		//保存処理
		// dd('ほげ');for check the site
		//POST送信データの受け取り
		//$_POSTの代わりにrequestクラスを使用する
		// dd($request);
		//INSERT INTO テーブル名 (カラム) VALUE (値)
		//INSERT INTO diaries (title, body) VALUE ($_POST['title'], $_POST['body'])
		//INSERT INTO diaries (title, body) VALUE ($request->title, $request->body)
		//ModelクラスDiaryを使用する
		$diary = new Diary(); //インスタンス化
		$diary->title = $request->title;
		$diary->body = $request->body;
		$diary->user_id = Auth::user()->id;
		$diary->save();

		//一覧ページに戻る（リダイレクト処理）
		return redirect()->route('diary.index'); //header()と同じような処理

		//リクエスト-> http//localhost:8000/diary/3/delete
		//web.php->Route::delete('diary/{id}/delete')


	}
//----------------------------------------
	public function destroy($id){
		//web.phpの 'diary/{id}/delete''にある{id}と同名の因数が定義される。
		//dd($id);

		$diary = Diary::find($id);
		//SELECT * FROM diaries WHERE id=?
		$diary->delete();
		//DELETE FROM テーブル名 WHERE id=?

		return redirect()->route('diary.index');
		//一覧ページに戻る（リダイレクト処理）
	}
//-----------------------------------------
	//この上の関数のみで削除処理が可能になる。
	

	function edit($id) {
		//public functionと書かなくても、パブリックになっている。
		//privateにしたい時は加筆必須。
		$diary = Diary::find($id);
		//SELECT * FROM diaries WHERE id=?
		//$diaryはCollectionという型でできていて、Arrayに変換するにはtoArray()
		return view('diaries.edit',['diary' => $diary]);
	}

	function update($id, CreateDiary $request) {
		$diary = Diary::find($id); //1件データ取得

		//$requestがバリデーション機能付きの$_POSTみたいなもの
		$diary->title = $request->title; //値上書き
		$diary->body = $request->body; //値上書き
		$diary->save(); //保存

		return redirect()->route('diary.index');
	}

	function mypage(){

	//--------パターン①------------
		// //whereメソッドを使ったパターン
		// $login_user = Auth::user();
		// // dd($login_user->id);
		// $diaries = Diary::where('user_id', 1)->get();
		// //where('カラム名）, 値');
		// //SELECT * FROM diaries WHERE カラム名＝値
		// dd($diaries);

	//--------パターン②------------
		// ModelModelのリレーションを使ったパターン
		$login_user = Auth::user();
		$diaries = $login_user->diaries;
		//dd($diaries);
		return view('diaries.mypage', ['diaries'=> $diaries]);
	}


	// likeメソッドの追加
	function like($id) {
		//idをもとにdiaryデータ1件取得
		$diary = Diary::where('id', $id)->with('likes')->first();
		// withから後ろはなくてもシステム自体は実行される
		// dd('diary');

		// likesテーブルに選択されているdiaryとログインしているユーザーのidをINSERTする
		$diary->likes()->attach(Auth::user()->id);
		// INSERT INTO likes (diary_id, user_id) VALUES ($diary->id, Auth::user()->id)

		return redirect()->route('diary.index');

	}

}



