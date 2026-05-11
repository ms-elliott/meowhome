@extends('layouts.common')

@section('title', 'MEOW HOME')

@section('content')
<div class="welcome-page">

    {{-- フラッシュメッセージ --}}
    @if (session('message'))
    <div class="flash-message flash-message--success welcome-page__flash">
        <p>{{ session('message') }}</p>
    </div>
    @endif

    {{-- メインビジュアル --}}
    <div class="welcome-hero">
        <img
            src="{{ asset('mh_images/meowhome_image.png') }}"
            alt="MeowHomeイメージ"
            class="welcome-hero__image">
        <img
            src="{{ asset('mh_images/meowhome_logo.png') }}"
            alt="MeowHomeロゴ"
            class="welcome-hero__logo">
        <h3 class="welcome-hero__catch">あたらしいおうちへ、ただいま。</h3>
        <h5 class="welcome-hero__sub">ー 猫専用 譲渡マッチングアプリ ー</h5>
    </div>

    {{-- 登録カード --}}
    <div class="welcome-card-wrap">
        <div class="welcome-card">
            <h5 class="welcome-card__title">ユーザー登録はこちら</h5>
            <p class="welcome-card__count">
                累計里親募集件数：{{ App\Models\Post::ComulativePostTotal() }}件
            </p>
            <div class="welcome-card__actions">
                <a href="{{ route('users.create') }}" class="btn btn-secondary">里親を募集したい方</a>
                <a href="{{ route('users.create') }}" class="btn btn-secondary">里親になりたい方</a>
            </div>
        </div>
    </div>

</div>
@endsection