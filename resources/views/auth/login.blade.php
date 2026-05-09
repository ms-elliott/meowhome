@extends('layouts.common')

@section('title', 'ログイン')

@section('content')
<section class="auth-page">
    <div class="container">
        <div class="auth-card">

            <h2 class="auth-card__title">ユーザー認証</h2>

            {{-- フラッシュ・エラーメッセージ --}}
            @if ($errors->any())
            <div class="auth-alert auth-alert--danger">
                <p>ログインに失敗しました</p>
            </div>
            @elseif (session('success'))
            <div class="auth-alert auth-alert--success">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="auth-field">
                    <label class="auth-field__label" for="email">メールアドレス</label>
                    <input
                        id="email"
                        class="auth-field__input"
                        type="email"
                        name="email"
                        placeholder="メールアドレス"
                        value="{{ old('email') }}"
                        autocomplete="email">
                </div>

                <div class="auth-field">
                    <label class="auth-field__label" for="password">パスワード</label>
                    <input
                        id="password"
                        class="auth-field__input"
                        type="password"
                        name="password"
                        placeholder="パスワード"
                        autocomplete="current-password">
                </div>

                <button type="submit" class="auth-card__submit btn btn-secondary">ログイン</button>
            </form>

        </div>
    </div>
</section>
@endsection