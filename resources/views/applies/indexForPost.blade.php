@extends('layouts.common')

@section('title', '応募者一覧')

@section('content')
<section class="applies-page">
    <div class="container">
        <div class="applies-page__inner">

            {{-- ページタイトル --}}
            <div class="applies-page__header">
                <h4 class="applies-page__title">応募者一覧</h4>
                <p class="applies-page__subtitle">（自分の募集への応募者一覧）</p>
            </div>

            {{-- 未読メッセージ通知 --}}
            @if (isset($applies[0]) && App\Models\Message::getUnreadCount($applies[0]->post_id) > 0)
            <div class="flash-message flash-message--danger">
                <p>新着メッセージがあります。</p>
            </div>
            @endif

            {{-- 一覧 --}}
            @if ($applies->isEmpty())
            <div class="applies-page__empty">
                <p>応募者はいません</p>
            </div>
            @else
            <div class="apply-card-grid">
                @foreach ($applies as $apply)
                <div class="apply-card apply-card--applicant">
                    <img
                        src="{{ $apply->user->image
                                    ? asset('storage/users/' . App\Http\Controllers\ImageController::convert2fileName($apply->user->image))
                                    : asset('storage/users/user_default.png') }}"
                        class="apply-card__avatar"
                        alt="写真">
                    <div class="apply-card__body">
                        <h5 class="apply-card__user-name">{{ $apply->user->name }}</h5>
                        <p class="apply-card__apply-date">申請：{{ $apply->created_at->format('Y/m/d') }}</p>
                        <div class="apply-card__actions">
                            <a href="{{ route('users.show', $apply->user->id) }}" class="btn btn-outline-secondary">プロフィール</a>
                            <a href="{{ route('messages.show', [$apply->post->id, $apply->user->id]) }}" class="btn btn-secondary position-relative">
                                メッセージ
                                @if (App\Models\Message::getUnreadCount($apply->post->id, $apply->user_id) > 0)
                                <span class="unread-badge"><span class="visually-hidden">未読あり</span></span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="applies-page__pagination">
                {{ $applies->links() }}
            </div>
            @endif

        </div>
    </div>
</section>
@endsection