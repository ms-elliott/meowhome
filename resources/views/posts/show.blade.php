@extends('layouts.common')

@section('title', '募集詳細')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-9">
            @if(session('message'))
            <div class="alert alert-danger mb-4 py-4 px-6">
                <ul>
                    <li style="color: red;">{{ session('message') }}</li>
                </ul>
            </div>
            @endif
            <div class="card my-2">
                <div class="card-header">募集詳細</div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center justify-content-xl-end mb-4 me-xl-2">
                        @if(auth()->user()->id == $post->user_id)
                        <div class="col-12 col-md-7 col-xl-5 text-xl-end">
                            <form action="{{ route('posts.delete', $post->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('posts.edit', ['id' => $post->id ]) }}" class="btn btn-secondary mx-4" style="width: 40%;">編集</a>
                                <button type="submit" class="btn btn-outline-secondary" onclick="return confirm('本当に削除しますか？')" style="width: 40%;">削除</button>
                            </form>
                        </div>
                        @else
                        <div class="col-1 me-3 me-xl-2">
                            <form action="{{ route('posts.like', $post) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn {{ $post->likes->contains('user_id', auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }}">
                                    {!! $post->likes->contains('user_id', auth()->id()) ? '<i class="bi bi-heart-fill"></i>' : '<i class="bi bi-heart"></i>' !!}
                                </button>
                            </form>
                        </div>
                            @if(App\Models\Apply::getIsApplied($post->id, auth()->user()->id) == false && $post->status < 3 )
                                <!-- 応募済or募集終了/里親決定済の場合は表示しない -->
                                <a href="{{ route('applies.create', [$post->id]) }}" class="col-4 col-md-3 col-xl-2 btn btn-secondary me-xl-4">里親に応募する</a>
                            @endif
                        @endif
                    </div>
                    <div class="row">
                        <div class="text-center d-xl-flex justify-content-xl-between">
                            <div class="col-12 col-xl-3 mb-3 ms-xl-3">
                                <img class="object-fit-cover rounded shadow-md" src="{{ asset('storage/posts/' . $post->photo1) }}" alt="写真１" width="250" height="250">
                            </div>
                            <div class="col-12 col-xl-3 mb-3 mx-xl-5">
                                <img class="object-fit-cover rounded shadow-md" src="{{ $post->photo2 ? asset('storage/posts/' . $post->photo2) : asset('storage/posts/post_no-image.png') }}" alt="写真２" width="250" height="250">
                            </div>
                            <div class="col-12 col-xl-3 mb-3 me-xl-5">
                                <img class="object-fit-cover rounded shadow-md" src="{{ $post->photo3 ? asset('storage/posts/' . $post->photo3) : asset('storage/posts/post_no-image.png') }}" alt="写真３" width="250" height="250">
                            </div>
                        </div>
                    </div>
                    <div class="row mx-1 mb-2">
                        <h4>{{ $post->title }}</h4>
                    </div>
                    <div class="row mx-1 mx-xl-3">
                        <table class="table table-bordered border-secondary" style="table-layout: fixed; width: 100%;">
                        <colgroup>
				<col style="width: 25%;"> 
				<col styel="width: 30%;">
				<col style="width: 20%;">
				<col style="width: 25%;">
          		<tbody>
                                <tr>
                                    <th class="table-secondary text-center"">状況</th>
                                    <td>{{ $status_name }}</td>
                                    <th class="table-secondary text-center">掲載日</th>
                                    <td><?php echo ($post->created_at)->format('Y/m/d'); ?></td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">種類</th>
                                    <td>{{ $post->breed->name ?? "ー" }}</td>
                                    <th class="table-secondary text-center">毛柄</th>
                                    <td>{{ $post->pattern->name ?? "ー" }}</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">性別</th>
                                    <td>{{ $post->gender === 0 ? 'オス' : 'メス' }}</td>
                                    <th class="table-secondary text-center">年齢(推定)</th>
                                    <td>{{ $post->age_year }} 歳　{{ $post->age_month }} ヶ月</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">ワクチン接種</th>
                                    <td>{{ $post->vaccined === 0 ? '未' : ($post->vaccined == 1 ? '済' : '不明') }}</td>
                                    <th class="table-secondary text-center">去勢/避妊</th>
                                    <td>{{ $post->neutered === 0 ? '未' : ($post->neutered == 1 ? '済' : '不明') }}</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">単身者応募</th>
                                    <td>{{ $post->accept_single === 0 ? '不可' : '可' }}</td>
                                    <th class="table-secondary text-center">高齢者応募</th>
                                    <td>{{ $post->accept_senior === 0 ? '不可' : '可' }}</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">所在地 (その他応募可能地域)</th>
                                    <td colspan="3">{{ $post->location->name }} ({{ $accept_locations ?? " ー "}})</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">詳細</th>
                                    <td colspan="3" style="white-space: normal;">{!! nl2br(e($post->body)) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-4 mx-1 justify-content-center align-items-center mt-4">
                        <div class="d-flex col-5 col-xl-2 justify-content-end">
                            <img class="rounded-circle object-fit-cover" src="{{ asset('storage/users/' . (App\Http\Controllers\ImageController::convert2fileName(optional($post->user)->image) ?? 'user_default.png')) }}" alt="" height="100" width="100">
                        </div>
                        <div class="col-7 col-xl-3 justify-content-start">
                            <p class="fw-bold mb-1">【投稿者】</p>
                            <p class="ms-1 fs-5 mb-1">{{ $post->user->name }}</p>
                            <a href="{{ route('users.show', ['id'=>$post->user_id]) }}" class="button btn btn-secondary btn-sm ms-1">プロフィールを確認</a>
                        </div>
                    </div>
                    <div class="row">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary col-4 col-xl-1 mt-3 mb-2 mx-auto">戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
