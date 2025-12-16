@extends('layouts.common')
@section('title', 'MEOW HOME')
@section('content')
<div class="text-center">
    @if(session('message'))
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-5">
            <div class="mt-2 mb-3 px-3 py-1 alert alert-primary">
                <p class="my-auto">{{ session('message') }}</p>
            </div>
        </div>
    </div>
    @endif
    <div>
        <img src="{{ asset('mh_images/meowhome_image.png')}}" alt="MeowHomeイメージ" height="300" class="mt-3">
    </div>
    <div>
        <img src="{{ asset('mh_images/meowhome_logo.png')}}" alt="MeowHomeロゴ" height=50" class="mb-5">
    </div>
    <h3 class="ms-3">あたらしいおうちへ、ただいま。</h3>
    <h5>ー 猫専用 譲渡マッチングアプリ ー</h5>
    <div class="row row-cols-auto justify-content-center" style="margin-top: 60px;">
        <div class="col-xl-5" style="max-width: 600px;">
            <div class="card text-center">
                <div class="card-body m-plus-rounded-1c-regular mx-auto justify-content-center">
                    <h5 class="card-title mt-1">ユーザー登録はこちら</h5>
                    <p class="card-text">累計里親募集件数：{{ App\Models\Post::ComulativePostTotal() }}件</p>
                    <div>
                        <a href="{{ route('users.create') }}" class="button btn btn-secondary btn-md-lg me-3 me-xl-5 mb-3">里親を募集したい方</a>
                        <a href="{{ route('users.create') }}" class="button btn btn-secondary btn-md-lg mb-3"> 里親になりたい方 </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
