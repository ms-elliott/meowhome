@extends('layouts.common')

@section('title', 'ユーザー登録')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">ユーザー登録</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf

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

                        @include('users._form', ['user' => null, 'mode' => 'create'])

                        <div class="user-form__submit">
                            <button type="submit" class="btn btn-secondary user-form__submit-btn">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection