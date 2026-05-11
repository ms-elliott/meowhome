@extends('layouts.common')

@section('title', '募集詳細')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-9">

            {{-- エラーメッセージ --}}
            @if (session('message'))
            <div class="apply-errors mb-4">
                <ul>
                    <li>{{ session('message') }}</li>
                </ul>
            </div>
            @endif

            <div class="card my-2">
                <div class="card-header">募集詳細</div>
                <div class="card-body">

                    {{-- 操作ボタン（投稿者 / その他） --}}
                    <div class="post-detail__actions">
                        @if (auth()->id() === $post->user_id)
                        <form action="{{ route('posts.delete', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="btn btn-secondary post-detail__action-btn">編集</a>
                            <button type="submit" class="btn btn-outline-secondary post-detail__action-btn" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                        @else
                        <div class="d-flex align-items-center gap-2">
                            {{-- いいねボタン --}}
                            <form action="{{ route('posts.like', $post) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $post->likes->contains('user_id', auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }}">
                                    <i class="bi {{ $post->likes->contains('user_id', auth()->id()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                </button>
                            </form>
                            {{-- 里親応募ボタン（応募済・終了は非表示） --}}
                            @if (!App\Models\Apply::getIsApplied($post->id, auth()->id()) && $post->status < 3)
                                <a href="{{ route('applies.create', $post->id) }}" class="btn btn-secondary">里親に応募する</a>
                                @endif
                        </div>
                        @endif
                    </div>

                    {{-- 写真 --}}
                    <div class="post-detail__photos">
                        @foreach ([1 => '写真１', 2 => '写真２', 3 => '写真３'] as $i => $alt)
                        @php
                        $field = "photo{$i}";
                        $src = $i === 1
                        ? asset('storage/posts/' . $post->$field)
                        : ($post->$field ? asset('storage/posts/' . $post->$field) : asset('storage/posts/post_no-image.png'));
                        @endphp
                        <img class="post-detail__photo object-fit-cover rounded shadow-md" src="{{ $src }}" alt="{{ $alt }}" width="250" height="250">
                        @endforeach
                    </div>

                    {{-- タイトル --}}
                    <div class="row mx-1 mb-2">
                        <h4>{{ $post->title }}</h4>
                    </div>

                    {{-- 詳細テーブル --}}
                    <div class="row mx-1 mx-xl-3">
                        <table class="table table-bordered border-secondary post-detail__table">
                            <colgroup>
                                <col style="width: 25%">
                                <col style="width: 30%">
                                <col style="width: 20%">
                                <col style="width: 25%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th class="table-secondary text-center">状況</th>
                                    <td>{{ $status_name }}</td>
                                    <th class="table-secondary text-center">掲載日</th>
                                    <td>{{ $post->created_at->format('Y/m/d') }}</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">種類</th>
                                    <td>{{ $post->breed->name ?? 'ー' }}</td>
                                    <th class="table-secondary text-center">毛柄</th>
                                    <td>{{ $post->pattern->name ?? 'ー' }}</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">性別</th>
                                    <td>{{ $post->genderLabel }}</td>
                                    <th class="table-secondary text-center">年齢(推定)</th>
                                    <td>{{ $post->age_year }} 歳　{{ $post->age_month }} ヶ月</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">ワクチン接種</th>
                                    <td>{{ $post->vaccinedLabel }}</td>
                                    <th class="table-secondary text-center">去勢/避妊</th>
                                    <td>{{ $post->neuteredLabel }}</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">単身者応募</th>
                                    <td>{{ $post->accept_single ? '可' : '不可' }}</td>
                                    <th class="table-secondary text-center">高齢者応募</th>
                                    <td>{{ $post->accept_senior ? '可' : '不可' }}</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">所在地 (その他応募可能地域)</th>
                                    <td colspan="3">{{ $post->location->name }} ({{ $accept_locations ?? 'ー' }})</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">詳細</th>
                                    <td colspan="3">{!! nl2br(e($post->body)) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- 投稿者情報 --}}
                    <div class="post-detail__poster">
                        <img
                            class="post-detail__poster-avatar rounded-circle object-fit-cover"
                            src="{{ asset('storage/users/' . (App\Http\Controllers\ImageController::convert2fileName(optional($post->user)->image) ?? 'user_default.png')) }}"
                            alt=""
                            height="100"
                            width="100">
                        <div>
                            <p class="fw-bold mb-1">【投稿者】</p>
                            <p class="fs-5 mb-1">{{ $post->user->name }}</p>
                            <a href="{{ route('users.show', ['id' => $post->user_id]) }}" class="btn btn-secondary btn-sm">プロフィールを確認</a>
                        </div>
                    </div>

                    {{-- 戻るボタン --}}
                    <div class="row">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary col-4 col-xl-1 mt-3 mb-2 mx-auto">戻る</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection