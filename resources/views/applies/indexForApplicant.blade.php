@extends('layouts.common')

@section('title', '里親申請一覧')

@section('content')
<section class="applies-page">
    <div class="container">
        <div class="applies-page__inner">

            {{-- ページタイトル --}}
            <div class="applies-page__header">
                <h4 class="applies-page__title">応募済一覧</h4>
                <p class="applies-page__subtitle">（自分が里親応募した募集一覧）</p>
            </div>

            {{-- フラッシュメッセージ --}}
            @if (session('success'))
            <div class="flash-message flash-message--success">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            {{-- 一覧 --}}
            @if ($applies->isEmpty())
            <div class="applies-page__empty">
                <p>応募済の里親募集はありません</p>
            </div>
            @else
            <div class="apply-card-grid">
                @foreach ($applies as $apply)
                @php $closed = in_array($apply->post->status, [3, 4], true) @endphp
                <div class="apply-card {{ $closed ? 'apply-card--closed' : '' }}">
                    <img
                        src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($apply->post->photo1)) }}"
                        class="apply-card__photo"
                        alt="写真">
                    <div class="apply-card__body">
                        <h5 class="apply-card__post-title">{{ $apply->post->title }}</h5>
                        <table class="table table-bordered border-secondary table-sm">
                            <tbody>
                                <tr>
                                    <th class="table-secondary text-center">申請日</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}" width="55%">
                                        {{ $apply->created_at->format('Y/m/d') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">状況</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ App\Models\Post::getStatusName($apply->post->status) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">投稿更新日</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $apply->post->updated_at->format('Y/m/d') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="apply-card__actions">
                            <a href="{{ route('posts.show', $apply->post->id) }}" class="btn btn-outline-secondary">募集詳細</a>
                            <a href="{{ route('messages.show', ['post_id' => $apply->post->id, 'applied_id' => $apply->user_id]) }}" class="btn btn-secondary position-relative">
                                メッセージ
                                @if (App\Models\Message::getUnreadCount($apply->post->id, auth()->id()) > 0)
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