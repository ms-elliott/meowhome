@extends('layouts.common')

@section('title', '会員登録')

@section('content')
<section class="auth-page">
    <div class="container">
        <div class="auth-card">

            <h2 class="auth-card__title">会員登録</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- ユーザー名 --}}
                <div class="auth-field">
                    <label class="auth-field__label" for="name">ユーザー名</label>
                    <div class="auth-field__input-wrap">
                        <input
                            id="name"
                            class="auth-field__input form-control @error('name') is-invalid @enderror"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                {{-- 年齢・居住地 --}}
                <div class="auth-field auth-field--inline">
                    <div class="auth-field__group">
                        <label class="auth-field__label" for="age">年齢</label>
                        <div class="auth-field__input-wrap auth-field__input-wrap--short">
                            <input
                                id="age"
                                class="auth-field__input form-control @error('age') is-invalid @enderror"
                                type="number"
                                name="age"
                                value="{{ old('age') }}"
                                required
                                autocomplete="off">
                            @error('age')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="auth-field__group">
                        <label class="auth-field__label" for="location">居住地</label>
                        <div class="auth-field__input-wrap">
                            <input
                                id="location"
                                class="auth-field__input form-control @error('location') is-invalid @enderror"
                                type="text"
                                name="location"
                                value="{{ old('location') }}"
                                required
                                autocomplete="off">
                            @error('location')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- メールアドレス --}}
                <div class="auth-field">
                    <label class="auth-field__label" for="email">メールアドレス</label>
                    <div class="auth-field__input-wrap">
                        <input
                            id="email"
                            class="auth-field__input form-control @error('email') is-invalid @enderror"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                {{-- パスワード --}}
                <div class="auth-field">
                    <label class="auth-field__label" for="password">パスワード</label>
                    <div class="auth-field__input-wrap">
                        <input
                            id="password"
                            class="auth-field__input form-control @error('password') is-invalid @enderror"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="auth-card__submit btn btn-secondary">登録</button>

            </form>
        </div>
    </div>
</section>
@endsection