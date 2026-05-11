@extends('layouts.common')

@section('title', 'ユーザー情報変更')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 mt-3">
            <div class="card">
                <div class="card-header">ユーザー情報変更</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', ['id' => $user->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <p class="user-form__note">※メールアドレス、年齢、居住地は変更できません。</p>

                        {{-- バリデーションエラー --}}
                        @if ($errors->any())
                        <div class="apply-errors mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @include('users._form', ['user' => $user, 'mode' => 'edit'])

                        <div class="user-form__submit">
                            <button type="submit" class="btn btn-secondary user-form__submit-btn">更新</button>
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-secondary user-form__submit-btn">キャンセル</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsections