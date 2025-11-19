@extends('layouts.common')

@section('title', '里親応募申請')
@section('content')
<div class="container px-4 mx-auto">
    <div class="pt-3 pb-1 px-2 px-xl-4 mx-xl-5 bg-white rounded">
        <div class="row d-flex justify-content-center">
            <div class="ml-auto mb-2 flex">
                <h3 class="text-xl font-bold">里親応募申請</h3>
            </div>
        </div>
        <form id="message-form" action="{{ route('applies.store', [$post->id]) }}" method="post">
            @csrf
            <div class="px-4">
                <!-- ▼▼▼▼エラーメッセージ▼▼▼▼ -->
                @if($errors->any())
                <div class="py-2 px-2 alert alert-danger rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- ▲▲▲▲エラーメッセージ▲▲▲▲　-->
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-11 col-xl-4 mb-4 border rounded bg-light">
                    <div class="text-center my-2">
                        <h5 class="my-1">この募集に里親応募する</h5>
                        <div class="mt-4 mb-2 d-flex justify-content-center">
                            <img src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($post->photo1)) }}" class="object-fit-cover rounded shadow-md" alt="写真１" height="300" width="300">
                        </div>
                        <div class="mx-auto mt-3" style="max-width: 77%;">
                            <table class="table table-bordered border-secondary table-sm px-4">
                                <tbody>
                                    <tr>
                                        <th class="table-secondary text-center">状況</th>
                                        <td class="bg-white ps-2" width="70%">{{ $post->status == 0 ? '募集中' : ($post->status == 1 ? '検討中' : ($post->status == 2 ? 'トライアル中' : ($post->status == 3 ? '募集終了' : '里親決定済'))) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">年齢</th>
                                        <td class="bg-white ps-2">{{ $post->age_year }} 歳 {{ $post->age_month }} ヶ月</td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">性別</th>
                                        <td class="bg-white ps-2">{{ $post->gender == 0 ? 'オス' : 'メス'; }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">所在地</th>
                                        <td class="bg-white ps-2">{{ $post->location->name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col">
                                <a href="{{ route('posts.show', $post->id) }}" class="button btn btn-secondary px-5 py-1">詳細</a>
                            </div>
                        </div>
                        <div class="row mt-4 d-felx align-items-center">
                            <div class="col-6 col-xl-6 text-end">
                                <img class="rounded-circle object-fit-cover" alt="" height="100" width="100"
                                    src="{{ isset($post->user->image) ? asset('storage/users/' . App\Http\Controllers\ImageController::convert2fileName($post->user->image)) : asset('storage/users/user_default.png') }}">
                            </div>
                            <div class="col-6 col-xl-6 mt-1">
                                <p class="fw-bold mb-1 text-start">【投稿者】</p>
                                <p class="fs-6 mb-2 ms-1 text-start">{{ $post->user->name }}</p>
                                <div class="text-start">
                                    <a href="{{ route('users.show', ['id'=>$post->user_id]) }}" class="button btn btn-secondary btn-sm px-3">プロフィール</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-11 col-xl-7 mb-4 ms-xl-4 border rounded bg-light">
                    <div class="my-2">
                        <h5 class="text-center my-1">応募申請</h5>
                        <div class="row">
                            <div>
                                <h6 class="mt-2 mb-3">【確認事項】</h6>
                                @if($post->accept_single != 1)
                                <p>・<span class="text-danger">単身者応募不可</span>に設定されています。単身者ではありませんか？</p>
                                @endif
                                @if($post->accept_senior != 1)
                                <p>・<span class="text-danger">高齢者応募不可</span>に設定されています。高齢者(70歳以上)ではありませんか？</p>
                                @endif
                                <p>・募集詳細をしっかりと確認しましたか？</p>
                                <p>・転売、虐待目的ではありませんか？</p>
                                <p>・終生愛情と責任を持って育てることを誓いますか？</p>
                            </div>
                        </div>
                        <div>
                            <div class="row mt-5 mx-1">
                                <p class="px-2">上記を確認し、問題なければ応募メッセージを送って投稿者へアピールしましょう。<br>今回の応募申請で里親検討されます。<br>里親決定となるまでのメッセージのやり取りで、事前確認したいことがあれば適宜質問してください。</p>
                                <label for="message">【応募メッセージ】</label>
                                <textarea id="message" class="text-sm bg-white px-2 py-1 border rounded" name="message" cols="30" rows="8">{{ old('comment') }}</textarea>
                            </div>
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <div class="row">
                                <div class="col d-flex justify-content-center">
                                    <button type="submit" class="btn btn-secondary px-5 py-2 mt-3 mb-2">申請</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection