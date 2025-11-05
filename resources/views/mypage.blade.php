@extends('layouts.common')

@section('title', 'マイページ')
@section('content')
<div class="container mt-3">
    <h3 class="mb-2 mb-md-3">{{ ($user->name) }}さんのマイページ</h3>
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <h5 class="card-header text-center">里親を募集したい</h5>
                <div class="card-body text-center">
                    <div class="mt-4 mb-5">
                        <a href="{{ route('posts.create', ['id' => $user->id]) }}" class="btn btn-secondary btn-lg py-2 w-50">新規募集</a>
                        <p class="card-text mt-1">新しく里親募集を投稿</p>
                    </div>
                    <div class="mb-4">
                        <a href="{{ route('posts.index', ['id' => $user->id]) }}" class="btn btn-secondary btn-lg py-2 w-50">マイ募集一覧</a>
                        <p class="card-text mt-1">自分が投稿した里親募集を確認</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <h5 class="card-header text-center">里親になりたい</h5>
                <div class="card-body text-center">
                    <div class="mt-4 mb-5">
                        <a href="{{ route('matchings.index', ['user' => Illuminate\Support\Facades\Auth::user()]) }}" class="btn btn-secondary btn-lg py-2 w-50">募集検索</a>
                        <p class="card-text mt-1">マッチした里親募集から検索</p>
                    </div>
                    <div class="mb-5">
                        <a href="{{ route('likes.index', [auth()->user()->id]) }}" class="button btn btn-secondary btn-lg py-2 w-50">お気に入り</a>
                        <p class="card-text mt-1">お気に入り登録した里親募集を確認</p>
                    </div>
                    <div class="mb-4">
                        <a href="{{ route('applies.indexApplicant', [auth()->user()->id]) }}" class="button btn btn-secondary btn-lg py-2 w-50">応募済一覧</a>
                        <p class="card-text mt-1">応募した里親募集を確認</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card mb-4">
                <div class="col d-flex mt-4 justify-content-center">
                    <img class="rounded-circle" src="{{ ($user->image ? asset('storage/users/' . $user->image) : asset('storage/users/' . 'user_default.png')) }}" alt="プロフィール画像" height="150" width="150" style="object-fit: cover;">
                </div>
                <div class="card-body text-center mb-2">
                    <a href="{{ route('users.show', ['id' => $user->id]) }}" class="btn btn-secondary btn-lg py-2 w-50">プロフィール</a>
                    <p class="card-text mt-1">自分のプロフィールを確認・編集</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center my-2">
                    <a href="{{ route('messages.index', ['user_id' => $user->id]) }}" class="btn btn-secondary btn-lg py-2 w-50 position-relative">メッセージ
                        @if(App\Models\Message::getUnreadCount() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2"><span class="visually-hidden">unread posts</span></span>
                        @endif
                    </a>
                    <p class="card-text mt-1">里親応募後のメッセージを確認</p>
                </div>
            </div>
            <div class="mt-5 d-flex justify-content-center">
                <form action="{{ route('users.delete', $user->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-secondary bg-white py-2 px-3 px-md-5" onclick="return confirm('関連する投稿やメッセージも削除されますが、本当にユーザー削除してよろしいですか？')">ユーザー削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection