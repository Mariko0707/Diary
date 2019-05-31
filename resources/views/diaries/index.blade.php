@extends('layout')

@section('title')
Diary 一覧

@endsection

@section('content')

	{{-- 画像の表示の仕方 --}}
	{{-- <img src="/img/FullSizeRender.jpg" alt=""> --}}
	<img src="{{ asset('img/IMG_1637.jpeg')}}" alt="">
	<br>

	<a href="{{ route('diary.create') }}" class="btn btn-outline-primary">新規投稿</a>
	@foreach($diaries as $diary)
	<div class="m-4 p-4 border border-primary">	
		<p>{{ $diary['title'] }}</p>
		<p>{{ $diary['body'] }}</p>
		@if($diary->img_url)
			<img src="/{{ str_replace('public/', 'storage/', $diary->img_url) }}" alt="">
		@endif
		<p>{{ $diary['created_at'] }}</p>

		@if(Auth::check() && Auth::user()->id == $diary['user_id'])
		{{-- これがあることで、ログインしていないときは編集や削除機能は見れない&&他の人が投稿したものは編集できないようになる --}}
			<a class="btn btn-outline-success" href="{{ route('diary.edit', ['id' => $diary['id']]) }}"><i class="fas fa-edit"></i></a>

			<form action="{{ route('diary.destroy',['id' => $diary['id']])}}" method="POST" class="d-inline">
				@csrf
				{{-- @csrfはフォームを送るときは必須！ --}}
				@method('delete')
				<button class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
			</form>
		@endif
		{{-- いいね機能周りの表示 --}}


		@if(Auth::check() && $diary->likes->contains(function ($user){
			return $user->id == Auth::user()->id;
		}))
		{{-- いいねされていたら、いいねを取り消すボタンを設置 --}}
		<form  style="display: inline;" action="{{ route('diary.dislike', ['id' => $diary['id']]) }}" method="POST">
					@csrf
					<button type="submit" class="btn btn-outline-danger">
						<i class="far fa-thumbs-up"></i>
						<span>{{ $diary->likes->count() }}</span>
					</button>
				</form>

		@else
		{{-- いいねされていなければいいねを取り消すボタンを設置 --}}
				<form  style="display: inline;" action="{{ route('diary.like', ['id' => $diary['id']]) }}" method="POST">
					@csrf
					<button type="submit" class="btn btn-outline-primary">
						<i class="far fa-thumbs-up"></i>
						<span>{{ $diary->likes->count() }}</span>
					</button>
				</form>
		@endif

	</div>
	@endforeach
@endsection

	
