{{--
    共通フォームパーシャル: users/_form.blade.php
    create / edit 両方から @include で呼び出す。
    $user  : null のとき新規登録、Model のとき編集
    $mode  : 'create' | 'edit'
--}}

{{-- プロフィール画像 --}}
<div class="user-form__row">
    <label class="user-form__label" for="image">プロフィール画像</label>
    <div class="user-form__field user-form__field--center">
        @php
        $avatarSrc = $mode === 'edit'
        ? (session('image_path')
        ? asset(session('image_path'))
        : ($user->image ? asset('storage/users/' . $user->image) : asset('storage/users/user_default.png')))
        : asset('storage/users/user_default.png');
        @endphp
        <img
            id="previewImage"
            data-noimage="{{ asset('storage/users/user_default.png') }}"
            src="{{ $avatarSrc }}"
            class="user-form__avatar object-fit-cover rounded-circle shadow-md mb-2"
            alt="プロフィール画像"
            height="200"
            width="200">
        <input id="image" class="d-block mx-auto mb-2" type="file" accept="image/*" name="image">
    </div>
</div>

{{-- ユーザー名 --}}
<div class="user-form__row">
    <label class="user-form__label" for="name">
        ユーザー名<span class="badge text-bg-primary ms-2">必須</span>
    </label>
    <div class="user-form__field">
        <input
            id="name"
            type="text"
            class="form-control bg-white @error('name') is-invalid @enderror"
            name="name"
            value="{{ old('name', $user->name ?? '') }}"
            required
            autocomplete="off"
            @if ($mode==='create' ) autofocus @endif>
        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

{{-- 年齢・居住地 --}}
<div class="user-form__row user-form__row--inline">
    <div class="user-form__group">
        <label class="user-form__label" for="age">
            年齢@if($mode === 'create')<span class="badge text-bg-primary ms-2">必須</span>@endif
        </label>
        <div class="d-flex align-items-center gap-2">
            <input
                id="age"
                type="number"
                class="form-control user-form__num-input @error('age') is-invalid @enderror"
                name="age"
                value="{{ old('age', $user->age ?? '') }}"
                @if ($mode==='edit' ) disabled @endif
                @if ($mode==='create' ) required @endif>
            <span>歳</span>
        </div>
    </div>
    <div class="user-form__group">
        <label class="user-form__label" for="location_id">
            居住地@if($mode === 'create')<span class="badge text-bg-primary ms-2">必須</span>@endif
        </label>
        <select
            id="location_id"
            class="form-select"
            name="location_id"
            @if ($mode==='edit' ) disabled @endif>
            @foreach ($locations as $location)
            <option value="{{ $location->id }}" @selected($location->id === (int)old('location_id', $user->location_id ?? 0))>
                {{ $location->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>

{{-- メールアドレス --}}
<div class="user-form__row">
    <label class="user-form__label" for="email">
        メールアドレス
        @if ($mode === 'create')
        <span class="badge text-bg-primary ms-2">必須</span>
        @else
        <span class="badge text-bg-warning ms-2">非公開</span>
        @endif
    </label>
    <div class="user-form__field">
        <input
            id="email"
            type="email"
            class="form-control @error('email') is-invalid @enderror"
            name="email"
            value="{{ old('email', $user->email ?? '') }}"
            autocomplete="off"
            @if ($mode==='create' ) required @endif
            @if ($mode==='edit' ) disabled @endif>
        @error('email')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

{{-- パスワード --}}
<div class="user-form__row">
    <label class="user-form__label" for="password">
        {{ $mode === 'create' ? 'パスワード' : '変更後パスワード' }}
        @if ($mode === 'create')
        <span class="badge text-bg-primary ms-2">必須</span>
        @else
        <span class="badge text-bg-warning ms-2">非公開</span>
        @endif
    </label>
    <div class="user-form__field">
        <input
            id="password"
            type="password"
            class="form-control bg-white @error('password') is-invalid @enderror"
            name="password"
            autocomplete="new-password"
            @if ($mode==='create' ) required @endif>
        @error('password')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

{{-- パスワード確認 --}}
<div class="user-form__row">
    <label class="user-form__label" for="password_confirmation">
        {{ $mode === 'create' ? 'パスワード(確認)' : '変更後パスワード(確認)' }}
        @if ($mode === 'create')
        <span class="badge text-bg-primary ms-2">必須</span>
        @else
        <span class="badge text-bg-warning ms-2">非公開</span>
        @endif
    </label>
    <div class="user-form__field">
        <input
            id="password_confirmation"
            type="password"
            class="form-control bg-white @error('password') is-invalid @enderror"
            name="password_confirmation"
            autocomplete="new-password">
    </div>
</div>

{{-- 自己紹介 --}}
<div class="user-form__row">
    <label class="user-form__label" for="comment">自己紹介</label>
    <div class="user-form__field">
        <textarea
            id="comment"
            class="form-control bg-white @error('comment') is-invalid @enderror"
            name="comment"
            rows="5">{{ old('comment', $user->comment ?? '') }}</textarea>
        @error('comment')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

{{-- 画像プレビュー用JS --}}
<script>
    document.getElementById('image').addEventListener('change', e => {
        const preview = document.getElementById('previewImage')
        const reader = new FileReader()
        reader.onload = () => preview.src = reader.result
        e.target.files.length > 0 ?
            reader.readAsDataURL(e.target.files[0]) :
            preview.src = preview.dataset.noimage
    })
</script>