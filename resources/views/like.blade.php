@extends('layouts.common')

@section('title', 'お気に入り')

@section('content')
<section class="applies-page">
    <div class="container">
        <div class="applies-page__inner">

            {{-- ページタイトル --}}
            <div class="applies-page__header">
                <h2 class="applies-page__title">お気に入り募集一覧</h2>
            </div>

            @if ($likes->isEmpty())
            {{-- 空状態 --}}
            <div class="applies-page__empty">
                <p>お気に入り登録した募集はありません</p>
                <a href="{{ route('matchings.index', auth()->id()) }}" class="btn btn-secondary mt-2 px-3">
                    マッチした投稿から探す
                </a>
            </div>
            @else
            {{-- カードグリッド --}}
            <div class="apply-card-grid">
                @foreach ($likes as $like)
                @php
                $closed = in_array($like->post->status, [3, 4], true);
                $isApplied = App\Models\Apply::getIsApplied($like->post->id, auth()->id());
                @endphp
                <div class="apply-card {{ $closed ? 'apply-card--closed' : '' }}">
                    <img
                        src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($like->post->photo1)) }}"
                        class="apply-card__photo"
                        alt="写真">
                    <div class="apply-card__body">
                        <h5 class="apply-card__post-title">{{ $like->post->title }}</h5>
                        <table class="table table-bordered border-secondary table-sm">
                            <tbody>
                                <tr>
                                    <th class="table-secondary text-center">状況</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}" width="70%">
                                        {{ App\Models\Post::getStatusName($like->post->status) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">年齢</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $like->post->age_year }} 歳 {{ $like->post->age_month }} ヶ月
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">性別</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $like->post->genderLabel }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">所在地</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $like->post->location->name }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="apply-card__actions">
                            <a href="{{ route('posts.show', $like->post->id) }}" class="btn btn-outline-secondary">詳細</a>
                            <a
                                href="{{ route('applies.create', $like->post->id) }}"
                                class="btn btn-secondary like-apply-btn {{ ($closed || $isApplied) ? 'like-apply-btn--disabled' : '' }}"
                                role="button"
                                @if ($closed || $isApplied) aria-disabled="true" @endif>
                                {{ $isApplied ? '応募済' : '里親応募' }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="applies-page__pagination">
                {{ $likes->links() }}
            </div>
            @endif

        </div>
    </div>
</section>
@endsection