@extends('layouts.common')

@section('title', '投稿編集')

@section('content')
<section class="post-form-page">
    <div class="container">
        <div class="post-form-page__inner">
            <form action="{{ route('posts.update', ['id' => $post->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $post->user_id }}">

                <div class="post-form-page__header">
                    <h3 class="post-form-page__title">里親募集 投稿編集</h3>
                </div>

                @include('posts._form', ['post' => $post])

                <div class="post-form-page__submit">
                    <button type="submit" class="btn btn-secondary py-2 px-4">更新する</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary py-2 px-3 ms-4">キャンセル</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection