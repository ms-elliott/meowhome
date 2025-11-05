@extends('layouts.common')

@section('title', '応募者一覧')
@section('content')
<section class="py-8">
    <div class="container px-4 mx-auto">
        <div class="pt-4 px-4 bg-white rounded">
            <div class="ml-auto d-flex justify-content-between">
                <h4 class="text-xl font-bold">応募者一覧</h4>
            </div>
            <div class="row">
                <div>
                    <h6>（自分が里親応募した投稿一覧）</h6>
                </div>
            </div>
            @if(isset($applies[0]) && App\Models\Message::getUnreadCount($applies[0]->post_id) > 0)
            <div class="row">
                <div class="d-flex align-items-center">
                    <div class="col-md-6 mt-2 mb-3 px-3 py-1 border border-danger rounded" style="background-color: MistyRose;">
                        <p class="text-danger my-auto"> 新着メッセージがあります。</p>
                    </div>
                </div>
            </div>
            @endif

            @if($applies->isEmpty())
            <div class="row">
                <div class="col mt-5 mb-5">
                    <p class="fs-5 text-center">応募者はいません</p>
                </div>
            </div>
            @else
            <div class="row row-cols-md-4 mb-3">
                @foreach($applies as $apply)
                <div class="py-3">
                    <div class="card px-2 px-md-3 shadow">
                        <img src="{{ isset($apply->user->image) ? asset('storage/users/' . App\Http\Controllers\ImageController::convert2fileName($apply->user->image)) : asset('storage/users/user_default.png') }}" class="card-img-top rounded-circle mt-2" alt="写真" height="250" width="250" style="object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-center text-truncate">{{ $apply->user->name }}</h5>
                            <p class="card-text mb-1">
                            <div class="row">
                                <p class="text-center mb-1">申請：<?php echo ($apply->created_at)->format('Y/m/d'); ?></p>
                            </div>
                            </p>
                            <div class="text-center d-flex align-items-center">
                                <a href="{{ route('users.show', $apply->user->id) }}" class="btn btn-outline-secondary me-2">プロフィール</a>
                                <a href="{{ route('messages.show', [$apply->post->id, $apply->user->id]) }}" class="btn btn-secondary position-relative">メッセージ
                                    @if(App\Models\Message::getUnreadCount($apply->post->id, $apply->user_id) > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2"><span class="visually-hidden">unread posts</span></span>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                {{ $applies->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection