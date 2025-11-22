@extends('layouts.common')

@section('title', 'プロフィール')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session('success'))
            <div class="row d-flex justify-content-start">
                <div class="col mx-md-3 py-1 alert alert-primary">
                    <p class="text-primary mb-1">{{ session('success') }}</p>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-header">プロフィール</div>
                <div class="card-body">
                    <div class="row my-2 d-flex justify-content-center">
                        <div class="col-11 col-md-4 my-auto">
                            <div class="ratio ratio-1x1">
                                <img class="object-fit-cover rounded-circle" src="{{ asset('storage/users/' . (optional($user)->image ?? 'user_default.png')) }}" alt="" height="350" width="350">
                            </div>
                        </div>
                        <div class="col-md-7 mt-md-3">
                            <div class="row my-2 align-items-center">
                                <h6 class="col-md-3 text-md-end">ユーザー名：</h6>
                                <h5 class="col-md-9">{{ $user->name }}</h5>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <h6 class="col-md-3 text-md-end">年齢：</h6>
                                <h5 class="col-md-9">{{ $user->age }} 歳</h5>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <h6 class="col-md-3 text-md-end">居住地：</h6>
                                <h5 class="col-md-9">{{ $user->location->name }}</h5>
                            </div>
                            <div class="row mb-3">
                                <h6 class="col-md-3 mt-md-1 text-md-end">自己紹介：</h6>
                                <h5 class="col-md-9">{!! nl2br(e($user->comment)) !!}</h5>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 mt-4 mb-2">戻る</a>
                            @if(auth()->user()->id == $user->id)
                            <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-secondary px-4 mt-4 mb-2 ms-4">編集</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
