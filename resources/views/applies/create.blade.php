@extends('layouts.common')

@section('title', '里親応募申請')

@section('content')
<div class="apply-page">
    <div class="apply-page__inner">

        {{-- ページタイトル --}}
        <div class="apply-page__title">
            <h3>里親応募申請</h3>
        </div>

        <form id="message-form" action="{{ route('applies.store', $post->id) }}" method="post">
            @csrf

            {{-- バリデーションエラー --}}
            @if ($errors->any())
            <div class="apply-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="apply-columns">

                {{-- 左カラム: 募集情報 --}}
                <div class="apply-post-card">

                    <h5 class="apply-post-card__heading">この募集に里親応募する</h5>

                    {{-- ペット写真 --}}
                    <div class="apply-post-card__photo-wrap">
                        <img
                            src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($post->photo1)) }}"
                            class="apply-post-card__photo"
                            alt="写真１">
                    </div>

                    {{-- ペット情報テーブル --}}
                    <div class="apply-post-card__table-wrap">
                        <table class="table table-bordered border-secondary table-sm">
                            <tbody>
                                <tr>
                                    <th class="table-secondary text-center">状況</th>
                                    <td class="bg-white ps-2" width="70%">{{ $post->statusLabel }}</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">年齢</th>
                                    <td class="bg-white ps-2">{{ $post->age_year }} 歳 {{ $post->age_month }} ヶ月</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">性別</th>
                                    <td class="bg-white ps-2">{{ $post->genderLabel }}</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">所在地</th>
                                    <td class="bg-white ps-2">{{ $post->location->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- 詳細リンク --}}
                    <div class="apply-post-card__detail-link">
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary px-5 py-1">詳細</a>
                    </div>

                    {{-- 投稿者情報 --}}
                    <div class="apply-post-card__poster">
                        <img
                            src="{{ $post->user->image
                                ? asset('storage/users/' . App\Http\Controllers\ImageController::convert2fileName($post->user->image))
                                : asset('storage/users/user_default.png') }}"
                            class="apply-post-card__poster-avatar"
                            alt="">
                        <div class="apply-post-card__poster-info">
                            <p class="poster-label">【投稿者】</p>
                            <p class="poster-name">{{ $post->user->name }}</p>
                            <a href="{{ route('users.show', ['id' => $post->user_id]) }}" class="btn btn-secondary btn-sm px-3">プロフィール</a>
                        </div>
                    </div>

                </div>

                {{-- 右カラム: 応募フォーム --}}
                <div class="apply-form-card">

                    <h5 class="apply-form-card__heading">応募申請</h5>

                    {{-- 確認事項 --}}
                    <div class="apply-form-card__checklist">
                        <h6>【確認事項】</h6>
                        @unless ($post->accept_single)
                        <p>・<span class="text-danger">単身者応募不可</span>に設定されています。単身者ではありませんか？</p>
                        @endunless
                        @unless ($post->accept_senior)
                        <p>・<span class="text-danger">高齢者応募不可</span>に設定されています。高齢者(70歳以上)ではありませんか？</p>
                        @endunless
                        <p>・募集詳細をしっかりと確認しましたか？</p>
                        <p>・転売、虐待目的ではありませんか？</p>
                        <p>・終生愛情と責任を持って育てることを誓いますか？</p>
                    </div>

                    {{-- 応募メッセージ --}}
                    <div class="apply-form-card__message-section">
                        <p class="guide-text">
                            上記を確認し、問題なければ応募メッセージを送って投稿者へアピールしましょう。<br>
                            今回の応募申請で里親検討されます。<br>
                            里親決定となるまでのメッセージのやり取りで、事前確認したいことがあれば適宜質問してください。
                        </p>
                        <label for="message">【応募メッセージ】</label>
                        <textarea id="message" name="message" cols="30" rows="8">{{ old('message') }}</textarea>
                    </div>

                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="apply-form-card__submit-wrap">
                        <button type="submit" class="btn btn-secondary px-5 py-2">申請</button>
                    </div>

                </div>

            </div>
        </form>
    </div>
</div>
@endsection