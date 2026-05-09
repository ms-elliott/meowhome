@extends('layouts.common')

@section('title', 'メッセージ詳細')

@section('content')
{{-- 対象投稿＆ヘッダーを sticky 表示 --}}
<div class="msg-show-header sticky-top">
    @include('parts.header')

    <div class="msg-show-header__post-bar">
        <div class="msg-show-header__post-card">
            <div class="msg-show-header__post-info">
                <p class="msg-show-header__post-label">ー こちらの里親募集について ー</p>
                <a href="{{ route('posts.show', $messages[0]->post->id) }}" class="alert-link">
                    <p class="msg-show-header__post-title text-truncate">
                        【{{ $messages[0]->post->title }}】
                    </p>
                </a>
            </div>
            <img
                src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($messages[0]->post->photo1)) }}"
                class="msg-show-header__post-photo object-fit-cover border rounded"
                alt="写真"
                height="60"
                width="60">
        </div>

        {{-- エラーメッセージ --}}
        @if (session()->has('error'))
        <div class="flash-message flash-message--danger mt-2">
            <p>{{ session('error') }}</p>
        </div>
        @endif
    </div>
</div>

{{-- メッセージ一覧 --}}
<div class="msg-show-body">
    @foreach ($messages as $message)
    @php
    $isMine = $message->sent_by === auth()->id();
    $sender = App\Models\User::find($message->sent_by);
    $imgPath = $sender->image
    ? asset('storage/users/' . App\Http\Controllers\ImageController::convert2fileName($sender->image))
    : asset('storage/users/user_default.png');
    @endphp

    <div class="balloon-chat {{ $isMine ? 'balloon-chat--right' : 'balloon-chat--left' }} mb-1">
        {{-- アイコン --}}
        <figure class="mb-0">
            @if (!$isMine)
            <a href="{{ route('users.show', $message->post->user->id) }}">
                <img src="{{ $imgPath }}" class="chat-icon__img" alt="プロフィール画像" height="80" width="80">
            </a>
            @else
            <img src="{{ $imgPath }}" class="chat-icon__img" alt="プロフィール画像" height="80" width="80">
            @endif
            <figcaption class="chat-icon__name text-truncate">{{ $sender->name }}</figcaption>
        </figure>

        {{-- 吹き出し本文 --}}
        <div class="col-9 {{ $isMine ? 'text-end' : '' }}">
            <div class="chatting">
                <p class="mb-1">{!! nl2br(e($message->message)) !!}</p>
            </div>
            <p class="msg-show-body__timestamp {{ $isMine ? 'text-end me-4' : 'text-start ms-4' }}">
                {{ $message->created_at->format('Y/m/d H:i') }}
                @if ($isMine)
                ({{ is_null($message->read_at) ? '未読' : '既読' }})
                @endif
            </p>
        </div>
    </div>
    @endforeach
</div>

{{-- 送信フォーム（フッターに固定） --}}
<div class="layout-footer" id="footer">
    <form action="{{ route('messages.store', ['post_id' => $messages[0]->post_id, 'user_id' => $messages[0]->applied_user_id]) }}" method="post">
        @csrf
        <input type="hidden" name="post_id" value="{{ $messages[0]->post_id }}">
        <input type="hidden" name="applied_user_id" value="{{ $messages[0]->applied_user_id }}">
        <div class="msg-show-form">
            <textarea
                id="message"
                class="form-control msg-show-form__textarea"
                name="message"
                rows="1"
                maxlength="255">{{ old('message') }}</textarea>
            <button type="submit" class="btn btn-secondary msg-show-form__submit">送信</button>
        </div>
    </form>
    @include('parts.footer')
</div>

{{-- ページ読み込み時に最下部へスクロール --}}
<script>
    document.getElementById('footer').scrollIntoView(false);
</script>
@endsection