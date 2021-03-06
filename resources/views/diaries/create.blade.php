@extends('layout')

@section('title')
Diary 新規作成

@endsection

@section('content')
	 <section class="container m-5">
        <div class="row justify-content-center">
            <div class="col-8">
                @if($errors->any())
                <ul>
                    @foreach($errors->all() as $message)
                        <li class="alert alert-danger">{{ $message }}</li>
                    @endforeach
                </ul>
                @endif

                <form action="{{ route('diary.create') }}" method="POST" enctype="multipart/form-data">
                    {{-- enctypeがないと画像送信が不可能 --}}
                	{{-- ↓↓↓↓Laravelでフォームを実装する場合に必要↓↓↓↓
                		セキュリティ処理を行う。他の攻撃からサイトを守る --}}
                    @csrf
                    <div class="form-group">
                        <label for="title">タイトル</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" />
                    </div>

                    <div class="form-group">
                        <label for="body">本文</label>
                        <textarea class="form-control" name="body" id="body">{{ old('body') }} </textarea>
                    </div>

                    <div class="form-group">
                        <label for="img_url">画像</label>
                        <input type="file" name="img_url" class="form-control" id="ing_url">
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-primary">投稿</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection