@extends('layout')

@section('title')
Diary 一覧

@endsection

@section('content')
	<a href="{{ route('diary.create') }}" class="btn btn-outline-primary">新規投稿</a>
	@foreach($diaries as $diary)
	<div class="m-4 p-4 border border-primary">	
		<p>{{ $diary['title'] }}</p>
		<p>{{ $diary['body'] }}</p>
		<p>{{ $diary['created_at'] }}</p>
		<form action="{{ route('diary.destroy',['id' => $diary['id']])}}" method="POST" class="d-inline">
			@csrf
			{{-- @csrfはフォームを送るときは必須！ --}}
			@method('delete')
			<button class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
		</form>
	</div>
	@endforeach
@endsection

	
