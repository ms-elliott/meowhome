@extends('layouts.common')

@section('title', '募集投稿')

@section('content')
<section class="post-form-page">
    <div class="container">
        <div class="post-form-page__inner">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="status" value="0">

                <div class="post-form-page__header">
                    <h3 class="post-form-page__title">里親募集 新規投稿</h3>
                </div>

                @include('posts._form', ['post' => null])

                <div class="post-form-page__submit">
                    <button type="submit" class="btn btn-secondary py-2 px-4">投稿する</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection