@extends('layouts.common')

@section('title', 'マイ募集一覧')

@section('content')
<section class="applies-page">
    <div class="container">
        <div class="applies-page__inner">

            {{-- ページタイトル + 新規募集ボタン --}}
            <div class="applies-page__header d-flex justify-content-between align-items-center">
                <h2 class="applies-page__title">マイ募集一覧</h2>
                <a href="{{ route('posts.create', ['id' => $id]) }}" class="btn btn-secondary py-2 px-4">新規募集</a>
            </div>

            {{-- フラッシュメッセージ --}}
            @if (session('success'))
            <div class="flash-message flash-message--success mt-2">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @if ($posts->isEmpty())
            <div class="applies-page__empty">
                <p>投稿した募集はありません</p>
            </div>
            @else
            <div class="apply-card-grid">
                @foreach ($posts as $post)
                @php $closed = in_array($post->status, [3, 4], true) @endphp
                <div class="apply-card {{ $closed ? 'apply-card--closed' : '' }}">
                    <img
                        src="{{ asset('storage/posts/' . $post->photo1) }}"
                        class="apply-card__photo"
                        alt="写真">
                    <div class="apply-card__body">
                        <h5 class="apply-card__post-title">{{ $post->title }}</h5>
                        <table class="table table-bordered border-secondary table-sm">
                            <tbody>
                                <tr>
                                    <th class="table-secondary text-center">状況</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}" width="70%">
                                        {{ App\Models\Post::getStatusName($post->status) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">年齢</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $post->age_year }} 歳 {{ $post->age_month }} ヶ月
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">性別</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $post->genderLabel }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">掲載日</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $post->created_at->format('Y/m/d') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="apply-card__actions">
                            <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="btn btn-outline-secondary">詳細</a>
                            <a href="{{ route('applies.indexPost', $post->id) }}" class="btn btn-secondary position-relative">
                                応募者 ({{ App\Models\Apply::getApplicantCount($post->id) }})
                                @if (App\Models\Message::getUnreadCount($post->id) > 0)
                                <span class="unread-badge"><span class="visually-hidden">未読あり</span></span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="applies-page__pagination">
                {{ $posts->links() }}
            </div>
            @endif

        </div>
    </div>
</section>
@endsection