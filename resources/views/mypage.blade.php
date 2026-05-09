@extends('layouts.common')

@section('title', 'マイページ')

@section('content')
<div class="container">
    <h3 class="mypage__greeting">{{ $user->name }}さんのマイページ</h3>

    <div class="mypage-grid">

        {{-- 里親を募集したい --}}
        <div class="mypage-card">
            <h5 class="mypage-card__header">里親を募集したい</h5>
            <div class="mypage-card__body">
                <div class="mypage-card__item">
                    <a href="{{ route('posts.create', ['id' => $user->id]) }}" class="btn btn-secondary btn-lg mypage-card__btn">新規募集</a>
                    <p class="mypage-card__desc">新しく里親募集を投稿</p>
                </div>
                <div class="mypage-card__item">
                    <a href="{{ route('posts.index', ['id' => $user->id]) }}" class="btn btn-secondary btn-lg mypage-card__btn">マイ募集一覧</a>
                    <p class="mypage-card__desc">自分が投稿した里親募集を確認</p>
                </div>
            </div>
        </div>

        {{-- 里親になりたい --}}
        <div class="mypage-card">
            <h5 class="mypage-card__header">里親になりたい</h5>
            <div class="mypage-card__body">
                <div class="mypage-card__item">
                    <a href="{{ route('matchings.index', ['user' => auth()->user()]) }}" class="btn btn-secondary btn-lg mypage-card__btn">募集検索</a>
                    <p class="mypage-card__desc">マッチした里親募集から検索</p>
                </div>
                <div class="mypage-card__item">
                    <a href="{{ route('likes.index', auth()->id()) }}" class="btn btn-secondary btn-lg mypage-card__btn">お気に入り</a>
                    <p class="mypage-card__desc">お気に入り登録した里親募集を確認</p>
                </div>
                <div class="mypage-card__item">
                    <a href="{{ route('applies.indexApplicant', auth()->id()) }}" class="btn btn-secondary btn-lg mypage-card__btn">応募済一覧</a>
                    <p class="mypage-card__desc">応募した里親募集を確認</p>
                </div>
            </div>
        </div>

        {{-- プロフィール・メッセージ・ユーザー削除 --}}
        <div class="mypage-card mypage-card--profile">

            {{-- アバター + プロフィールリンク --}}
            <div class="mypage-profile">
                <img
                    src="{{ $user->image ? asset('storage/users/' . $user->image) : asset('storage/users/user_default.png') }}"
                    class="mypage-profile__avatar"
                    alt="プロフィール画像"
                    height="150"
                    width="150">
                <a href="{{ route('users.show', ['id' => $user->id]) }}" class="btn btn-secondary btn-lg mypage-card__btn">プロフィール</a>
                <p class="mypage-card__desc">自分のプロフィールを確認・編集</p>
            </div>

            {{-- メッセージ --}}
            <div class="mypage-card__item mypage-card__item--message">
                <a href="{{ route('messages.index', ['user_id' => $user->id]) }}" class="btn btn-secondary btn-lg mypage-card__btn position-relative">
                    メッセージ
                    @if (App\Models\Message::getUnreadCount() > 0)
                    <span class="unread-badge"><span class="visually-hidden">未読あり</span></span>
                    @endif
                </a>
                <p class="mypage-card__desc">里親応募後のメッセージを確認</p>
            </div>

            {{-- ユーザー削除 --}}
            <div class="mypage-delete">
                <form action="{{ route('users.delete', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="btn btn-outline-secondary mypage-delete__btn"
                        onclick="return confirm('関連する投稿やメッセージも削除されますが、本当にユーザー削除してよろしいですか？')">
                        ユーザー削除
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection