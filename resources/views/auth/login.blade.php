@extends('layouts.common')

@section('title', 'ログイン')
@section('content')
<div>
    <section class="h-screen py-48 bg-blueGray-50 mb-2">
        <div class="container px-4 mx-auto">
            <div class="flex max-w-md mx-auto flex-col text-center d-flex justify-content-center">
                <div class="mt-2 p-8 col-md-5 bg-white rounded shadow">
                    <h2 class="mt-5 pt-1 mb-4 text-3xl">ユーザー認証</h2>
                    @if($errors->any())
                    <div class="row d-flex justify-content-center">
                        <div class="col-10 col-md-8 me-md-4 py-1 alert alert-danger">
                            <p class="text-danger mb-1">ログインに失敗しました</p>
                        </div>
                    </div>
                    @elseif(session('success'))
                    <div class="row d-flex justify-content-center">
                        <div class="col-10 col-md-8 me-md-4 py-1 alert alert-primary">
                            <p class="text-primary mb-1">{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="flex mb-4 px-4 bg-blueGray-50 rounded">
                                <label class="col-5 col-md-3 me-md-2 text-end" for="email">メールアドレス</label>
                                <input class="col-12 col-md-6 w-full py-2 me-md-5 text-xs placeholder-blueGray-400 font-semibold leading-none bg-blueGray-50 outline-none" type="email" placeholder="メールアドレス" name="email" value="{{ old('email') }}" autocomplete="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="flex mb-6 px-4 bg-blueGray-50 rounded">
                                <label class="col-4 col-md-3 me-md-2 text-end" for="email">パスワード</label>
                                <input class="col-12 col-md-6 w-full py-2 me-md-5 text-xs placeholder-blueGray-400 font-semibold leading-none bg-blueGray-50 outline-none" type="password" placeholder="パスワード" name="password">
                            </div>
                        </div>
                        <button type="submit" class="block w-full px-4 mt-4 mb-5 text-center text-xs btn btn-secondary font-semibold leading-none rounded">ログイン</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection