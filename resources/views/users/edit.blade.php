@extends('layouts.common')

@section('title', 'ユーザー情報変更')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 mt-3">
            <div class="card">
                <div class="card-header">{{ __('ユーザー情報変更') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', ['id' => $user->id]) }}" enctype="multipart/form-data">
                        <p class="text-center mb-3" style="color: gray;">※メールアドレス、年齢、居住地は変更できません。</p>
                        @csrf
                        @method('PUT')
                        <!-- ▼▼▼▼エラーメッセージ▼▼▼▼-->
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
                        <div class="row mb-3 align-items-center">
                            <label class="col-lg-4 col-form-label text-lg-end mb-2" for="image">{{ __('プロフィール画像') }}</label>
                            <div class="col-12 col-lg-4 text-center">
                                <img id="previewImage" data-noimage="storage/users/user_default.png" alt="プロフィール画像" class="object-fit-cover rounded-circle shadow-md w-32 mb-2"
                                src="{{ old('image', $user->image) ? asset(old('image', 'storage/users/' . $user->image)) : (session()->has('image_path') ? asset(session('image_path')) : asset('storage/users/user_default.png')) }}" 
                                height="250" width="250" style="object-fit: cover;">
                                <div class="col-12">
                                <input id="image" class="text-center mx-auto mb-2" type="file" accept='image/*' name="image">
                            </div>
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
                        <div class="row mb-1 mb-lg-3">
                            <label for="name" class="col-lg-4 col-form-label text-lg-end">{{ __('ユーザー名') }}<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="col-lg-6">
                                <input id="name" type="text" class="form-control bg-white @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}">
                            </div>
                        </div>
                        <div class="row mb-lg-3 align-items-center">
                            <label for="age" class="col-lg-4 col-form-label text-lg-end">{{ __('年齢') }}</label>
                            <div class="col-4 col-lg-2 d-flex align-items-center mb-1">
                                <input id="age" type="age" class="form-control bg-gray @error('age') is-invalid @enderror" name="age" value="{{ old('age') ?? $user->age }}" disabled>
                                <label class="text-lg-start ms-2">歳</label>
                            </div>
                            <label for="location_id" class="col-lg-2 col-form-label text-lg-end">{{ __('居住地') }}</label>
                            <div class="col-6 col-lg-2">
                                <select id="location_id" class="form-select" aria-label="location_id" name="location_id" disabled> 
                                    @foreach ($locations as $location)
                                    <option value="{{ $location->id }}" @if($location->id === old('location_id', $user->location_id)) selected @endif> {{ $location->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1 mb-lg-3">
                            <label for="comment" class="col-lg-4 col-form-label text-lg-end">{{ __('自己紹介') }}</label>
                            <div class="col-lg-6">
                                <textarea id="comment" class="col-12 text-sm bg-white px-2 py-1 border rounded @error('comment') is-invalid @enderror" name="comment" rows="5">{{ old('comment') ?? $user->comment }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-1 mb-lg-3">
                            <label for="email" class="col-lg-4 col-form-label text-lg-end">{{ __('メールアドレス') }}<span class="badge text-bg-warning ms-2">非公開</span></label>
                            <div class="col-lg-6">
                                <input id="email" type="email" class="form-control bg-gray @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-1 mb-lg-3">
                            <label for="password" class="col-lg-4 col-form-label text-lg-end">{{ __('変更後パスワード') }}<span class="badge text-bg-warning ms-2">非公開</span></label>
                            <div class="col-lg-6">
                                <input id="password" type="password" class="form-control bg-white @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-4 mb-lg-1 mb-xl-4">
                            <label for="password_confirmation" class="col-lg-4 col-form-label text-lg-end">{{ __('変更後パスワード(確認)') }}<span class="badge text-bg-warning ms-2">非公開</span></label>
                            <div class="col-lg-6">
                                <input id="password_confirmation" type="password" class="form-control bg-white @error('password') is-invalid @enderror" name="password_confirmation">
                            </div>
                        </div>
                        <div class="row mb-2 justify-content-center">
                            <div class="col-12 col-lg-7 text-center">
                                <button type="submit" class="btn btn-secondary" style="width: 100px">更新</button>
                                <a href="{{ route('users.show', [$user->id]) }}" class="button btn btn-outline-secondary ms-5" style="width: 100px">キャンセル</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection