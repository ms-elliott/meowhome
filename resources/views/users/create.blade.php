@extends('layouts.common')

@section('title', 'ユーザー登録')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ユーザー登録') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- ▼▼▼▼エラーメッセージ▼▼▼▼　-->
                        @if($errors->any())
                        <div class="alert alert-danger mb-4 py-4 px-6">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li style="color: red;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <!-- ▲▲▲▲エラーメッセージ▲▲▲▲　-->
                        <div class="row mb-1 mb-md-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('ユーザー名') }}<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control bg-white @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" autofocus>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <label for="age" class="col-md-4 col-form-label text-md-end mb-md-3">{{ __('年齢') }}<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="col-md-2 col-4 d-flex align-items-center mb-1 mb-md-3">
                                <input id="age" type="age" class="form-control bg-white @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required>
                                <label class="text-md-start ms-2">歳</label>
                            </div>
                            <label for="location_id" class="col-md-2 col-form-label text-md-end mb-md-3">{{ __('居住地') }}<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="col-md-2 col-6 mb-1 mb-md-3">
                                <select id="location_id" class="form-select bg-white" aria-label="location" name="location_id">
                                    @foreach ($locations as $location)
                                    <option class="bg-white" value="{{ $location->id }}" @if($location->id === (int)old('location_id')) selected @endif > {{ $location->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1 mb-md-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control bg-white @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-1 mb-md-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control bg-white @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-1 mb-md-3">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('パスワード(確認)') }}<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control bg-white @error('password') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}">
                            </div>
                        </div>
                        <div class="row mb-1 mb-md-3">
                            <label for="comment" class="col-md-4 col-form-label text-md-end">{{ __('自己紹介') }}</label>
                            <div class="col-md-6">
                                <textarea id="comment" class="col-12 text-sm bg-white px-2 py-1 border rounded @error('comment') is-invalid @enderror" name="comment" rows="5">{{ old('comment') }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-1 mb-md-5 align-items-center">
                            <label class="col-md-4 col-form-label text-md-end mb-md-2" for="image">{{ __('プロフィール画像') }}</label>
                            <div class="col-md-4 col-12 text-center">
                                <img id="previewImage" data-noimage="{{ asset('storage/users/user_default.png') }}" alt="" class="object-fit-cover rounded-circle shadow-md mb-2" height="200" width="200" src="{{ old('image') ??  asset('storage/users/user_default.png') }}">
                                <input id="image" class="block w-full mb-2" type="file" accept='image/*' name="image">
                            </div>
                        </div>
                        <script>
                            // 画像プレビュー
                            document.getElementById('image').addEventListener('change', e => {
                                const previewImageNode = document.getElementById('previewImage')
                                const fileReader = new FileReader()
                                fileReader.onload = () => previewImageNode.src = fileReader.result
                                if (e.target.files.length > 0) {
                                    fileReader.readAsDataURL(e.target.files[0])
                                } else {
                                    previewImageNode.src = previewImageNode.dataset.noimage
                                }
                            })
                        </script>
                        <div class="row mt-5 justify-content-center">
                            <div class="col-4 col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary" style="width: 100px">
                                    {{ __('登録') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection