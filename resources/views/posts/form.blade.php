{{--
    共通フォームパーシャル: posts/_form.blade.php
    create / edit 両方から @include で呼び出す。
    $post が null のとき新規投稿、Model のとき編集。
--}}

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

{{-- 状況（編集時のみ） --}}
@if ($post)
<div class="post-form-row">
    <label class="post-form-row__label" for="status">
        状況<x-required-badge />
    </label>
    <div class="post-form-row__field post-form-row__field--sm">
        <select id="status" class="form-select" name="status">
            @foreach ([0 => '募集中', 1 => '検討中', 2 => 'トライアル中', 3 => '募集終了', 4 => '里親決定済'] as $val => $label)
            <option value="{{ $val }}" @selected(old('status', $post->status) === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
@endif

{{-- 年齢・性別 --}}
<div class="post-form-row">
    <label class="post-form-row__label">年齢(推定)<span class="badge text-bg-primary ms-2">必須</span></label>
    <div class="post-form-row__field d-flex align-items-center gap-1">
        <input class="form-control post-form-row__num-input" type="number" name="age_year" value="{{ old('age_year',  $post->age_year  ?? 0) }}" min="0">
        <span>歳</span>
        <input class="form-control post-form-row__num-input" type="number" name="age_month" value="{{ old('age_month', $post->age_month ?? 0) }}" min="0" max="11">
        <span>ヶ月</span>
    </div>

    <label class="post-form-row__label">性別<span class="badge text-bg-primary ms-2">必須</span></label>
    <div class="post-form-row__field">
        @foreach ([0 => 'オス', 1 => 'メス'] as $val => $label)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="gender_{{ $val }}" value="{{ $val }}"
                {{ old('gender', $post->gender ?? '') == $val ? 'checked' : '' }}>
            <label class="form-check-label" for="gender_{{ $val }}">{{ $label }}</label>
        </div>
        @endforeach
    </div>
</div>

{{-- 種類・毛柄 --}}
<div class="post-form-row">
    <label class="post-form-row__label" for="breed_id">種類</label>
    <div class="post-form-row__field post-form-row__field--sm">
        <select id="breed_id" class="form-select" name="breed_id">
            <option value="0">未選択</option>
            @foreach ($breeds as $breed)
            <option value="{{ $breed->id }}" @selected($breed->id === (int)old('breed_id', $post->breed_id ?? 0))>{{ $breed->name }}</option>
            @endforeach
        </select>
    </div>

    <label class="post-form-row__label" for="pattern_id">毛柄</label>
    <div class="post-form-row__field post-form-row__field--sm">
        <select id="pattern_id" class="form-select" name="pattern_id">
            <option value="0">未選択</option>
            @foreach ($patterns as $pattern)
            <option value="{{ $pattern->id }}" @selected($pattern->id === (int)old('pattern_id', $post->pattern_id ?? 0))>{{ $pattern->name }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- ワクチン・去勢 --}}
<div class="post-form-row">
    <label class="post-form-row__label">ワクチン接種<span class="badge text-bg-primary ms-2">必須</span></label>
    <div class="post-form-row__field">
        @foreach ([0 => '未', 1 => '済', 9 => '不明'] as $val => $label)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="vaccined" id="vaccined_{{ $val }}" value="{{ $val }}"
                {{ old('vaccined', $post->vaccined ?? '') == $val ? 'checked' : '' }}>
            <label class="form-check-label" for="vaccined_{{ $val }}">{{ $label }}</label>
        </div>
        @endforeach
    </div>

    <label class="post-form-row__label">去勢/避妊手術<span class="badge text-bg-primary ms-2">必須</span></label>
    <div class="post-form-row__field">
        @foreach ([0 => '未', 1 => '済', 9 => '不明'] as $val => $label)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="neutered" id="neutered_{{ $val }}" value="{{ $val }}"
                {{ old('neutered', $post->neutered ?? '') == $val ? 'checked' : '' }}>
            <label class="form-check-label" for="neutered_{{ $val }}">{{ $label }}</label>
        </div>
        @endforeach
    </div>
</div>

{{-- 所在地・単身者・高齢者応募 --}}
<div class="post-form-row">
    <label class="post-form-row__label" for="location_id">所在地<span class="badge text-bg-primary ms-2">必須</span></label>
    <div class="post-form-row__field post-form-row__field--sm">
        <select id="location_id" class="form-select" name="location_id">
            @foreach ($locations as $location)
            <option value="{{ $location->id }}" @selected($location->id === (int)old('location_id', $post->location_id ?? $user->location_id ?? 0))>{{ $location->name }}</option>
            @endforeach
        </select>
    </div>

    <label class="post-form-row__label">単身者応募<span class="badge text-bg-primary ms-2">必須</span></label>
    <div class="post-form-row__field">
        @foreach ([1 => '可', 0 => '不可'] as $val => $label)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="accept_single" id="accept_single_{{ $val }}" value="{{ $val }}"
                {{ old('accept_single', $post->accept_single ?? '') == $val ? 'checked' : '' }}>
            <label class="form-check-label" for="accept_single_{{ $val }}">{{ $label }}</label>
        </div>
        @endforeach
    </div>

    <label class="post-form-row__label">高齢者応募<span class="badge text-bg-primary ms-2">必須</span></label>
    <div class="post-form-row__field">
        @foreach ([1 => '可', 0 => '不可'] as $val => $label)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="accept_senior" id="accept_senior_{{ $val }}" value="{{ $val }}"
                {{ old('accept_senior', $post->accept_senior ?? '') == $val ? 'checked' : '' }}>
            <label class="form-check-label" for="accept_senior_{{ $val }}">{{ $label }}</label>
        </div>
        @endforeach
    </div>
</div>

{{-- 応募可能地域（最大5件） --}}
<div class="post-form-row post-form-row--locations">
    <span class="post-form-row__label">応募可能地域</span>
    <div class="post-form-row__field d-flex flex-wrap gap-2">
        @foreach (range(1, 5) as $i)
        <div class="d-flex align-items-center gap-1">
            <label class="post-form-row__location-num" for="accept_location{{ $i }}">{{ $i }}</label>
            <select id="accept_location{{ $i }}" class="form-select post-form-row__location-select" name="accept_location{{ $i }}">
                <option value="0">未選択</option>
                @foreach ($locations as $location)
                <option value="{{ $location->id }}" @selected($location->id === (int)old("accept_location{$i}", $post->{"accept_location{$i}"} ?? 0))>{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        @endforeach
    </div>
    <p class="post-form-row__note">※所在地を除く、最大５都道府県まで選択可能</p>
</div>

{{-- タイトル --}}
<div class="post-form-row">
    <label class="post-form-row__label" for="title">タイトル<span class="badge text-bg-primary ms-2">必須</span></label>
    <div class="post-form-row__field post-form-row__field--wide">
        <input id="title" class="form-control" type="text" name="title" value="{{ old('title', $post->title ?? '') }}">
    </div>
</div>

{{-- 本文 --}}
<div class="post-form-row">
    <label class="post-form-row__label" for="body">本文<span class="badge text-bg-primary ms-2">必須</span></label>
    <div class="post-form-row__field post-form-row__field--wide">
        <textarea id="body" class="form-control" name="body" rows="10">{{ old('body', $post->body ?? '') }}</textarea>
    </div>
</div>

{{-- 写真アップロード --}}
<div class="post-form-row post-form-row--photos">
    <span class="post-form-row__label">写真</span>
    <div class="post-form-row__field d-flex flex-wrap gap-3">
        @foreach ([1 => '１枚目', 2 => '２枚目', 3 => '３枚目'] as $i => $label)
        @php
        $sessionKey = "uploadedPhoto{$i}Path";
        $fieldName = "photo{$i}";
        $src = session()->has($sessionKey)
        ? asset(session($sessionKey))
        : ($post && $post->$fieldName
        ? asset('storage/posts/' . $post->$fieldName)
        : asset('storage/posts/post_no-image.png'));
        @endphp
        <div class="post-photo-field">
            <label class="post-form-row__label" for="{{ $fieldName }}">
                {{ $label }}@if($i === 1)<span class="badge text-bg-primary ms-2">必須</span>@endif
            </label>
            <img
                id="previewImage{{ $i }}"
                data-noimage="{{ asset('storage/posts/post_no-image.png') }}"
                src="{{ $src }}"
                class="post-photo-field__preview rounded shadow-md object-fit-cover"
                alt=""
                height="200"
                width="200">
            <input id="{{ $fieldName }}" class="post-photo-field__input" type="file" accept="image/*" name="{{ $fieldName }}">
        </div>
        @endforeach
    </div>
</div>

{{-- 写真プレビュー用JS --}}
<script>
    [1, 2, 3].forEach(i => {
        document.getElementById(`photo${i}`).addEventListener('change', e => {
            const preview = document.getElementById(`previewImage${i}`)
            const reader = new FileReader()
            reader.onload = () => preview.src = reader.result
            e.target.files.length > 0 ?
                reader.readAsDataURL(e.target.files[0]) :
                preview.src = preview.dataset.noimage
        })
    })
</script>