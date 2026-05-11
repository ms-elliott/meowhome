@extends('layouts.common')

@section('title', 'プロフィール')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- フラッシュメッセージ --}}
            @if (session('success'))
            <div class="flash-message flash-message--success mb-3">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="card">
                <div class="card-header">プロフィール</div>
                <div class="card-body">
                    <div class="user-profile">

                        {{-- アバター --}}
                        <div class="user-profile__avatar-wrap">
                            <div class="ratio ratio-1x1">
                                <img
                                    class="user-profile__avatar object-fit-cover rounded-circle"
                                    src="{{ asset('storage/users/' . ($user->image ?? 'user_default.png')) }}"
                                    alt="">
                            </div>
                        </div>

                        {{-- 情報 --}}
                        <div class="user-profile__info">
                            <div class="user-profile__row">
                                <span class="user-profile__key">ユーザー名：</span>
                                <span class="user-profile__value">{{ $user->name }}</span>
                            </div>
                            <div class="user-profile__row">
                                <span class="user-profile__key">年齢：</span>
                                <span class="user-profile__value">{{ $user->age }} 歳</span>
                            </div>
                            <div class="user-profile__row">
                                <span class="user-profile__key">居住地：</span>
                                <span class="user-profile__value">{{ $user->location->name }}</span>
                            </div>
                            <div class="user-profile__row user-profile__row--comment">
                                <span class="user-profile__key">自己紹介：</span>
                                <span class="user-profile__value">{!! nl2br(e($user->comment)) !!}</span>
                            </div>
                        </div>

                    </div>

                    {{-- ボタン --}}
                    <div class="user-profile__actions">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">戻る</a>
                        @if (auth()->id() === $user->id)
                        <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-secondary px-4">編集</a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection