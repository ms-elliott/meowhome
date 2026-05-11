@extends('layouts.common')

@section('title', 'マッチング一覧')

@section('content')
<section class="applies-page">
    <div class="container">
        <div class="applies-page__inner">

            {{-- ページタイトル --}}
            <div class="applies-page__header">
                <h3 class="applies-page__title">あなたにマッチした募集一覧</h3>
                <p class="applies-page__subtitle">（所在地または応募可能地域が一致した募集のみ表示されます。）</p>
            </div>

            {{-- 絞り込み検索 --}}
            <div class="accordion mb-3" id="searchAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button
                            type="button"
                            class="accordion-button collapsed"
                            data-bs-toggle="collapse"
                            data-bs-target="#searchPanel"
                            aria-expanded="false"
                            aria-controls="searchPanel">
                            絞り込み検索
                        </button>
                    </h2>
                    <div id="searchPanel" class="accordion-collapse collapse" data-bs-parent="#searchAccordion">
                        <div class="accordion-body">
                            <form action="{{ route('matchings.index', [auth()->user()]) }}" method="GET">
                                @csrf
                                <div class="post-search-form">

                                    {{-- 所在地・状況 --}}
                                    <div class="post-form-row">
                                        <label class="post-form-row__label" for="location_id">所在地</label>
                                        <div class="post-form-row__field post-form-row__field--sm">
                                            <select id="location_id" class="form-select" name="location_id">
                                                <option value="">未選択</option>
                                                @foreach ($locations as $location)
                                                <option value="{{ $location->id }}" @selected($location->id === (int)old('location_id'))>{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="post-form-row__label" for="status">状況</label>
                                        <div class="post-form-row__field post-form-row__field--sm">
                                            <select id="status" class="form-select" name="status">
                                                <option value="">未選択</option>
                                                @foreach ([0 => '募集中', 1 => '検討中', 2 => 'トライアル中', 3 => '募集終了', 4 => '里親決定済'] as $val => $label)
                                                <option value="{{ $val }}" @selected(old('status')===(string)$val)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- 年齢・性別・種類・毛柄 --}}
                                    <div class="post-form-row">
                                        <label class="post-form-row__label" for="age_from">年齢</label>
                                        <div class="post-form-row__field d-flex align-items-center gap-1">
                                            <input id="age_from" class="form-control post-form-row__num-input" type="number" name="age_from" value="{{ old('age_from') }}" min="0">
                                            <span>〜</span>
                                            <input id="age_to" class="form-control post-form-row__num-input" type="number" name="age_to" value="{{ old('age_to') }}" min="0">
                                            <span>歳</span>
                                        </div>
                                        <label class="post-form-row__label" for="gender">性別</label>
                                        <div class="post-form-row__field post-form-row__field--sm">
                                            <select id="gender" class="form-select" name="gender">
                                                <option value="">未選択</option>
                                                <option value="0" @selected(old('gender')==='0' )>オス</option>
                                                <option value="1" @selected(old('gender')==='1' )>メス</option>
                                            </select>
                                        </div>
                                        <label class="post-form-row__label" for="breed_id">種類</label>
                                        <div class="post-form-row__field post-form-row__field--sm">
                                            <select id="breed_id" class="form-select" name="breed_id">
                                                <option value="">未選択</option>
                                                @foreach ($breeds as $breed)
                                                <option value="{{ $breed->id }}" @selected($breed->id === (int)old('breed_id'))>{{ $breed->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="post-form-row__label" for="pattern_id">毛柄</label>
                                        <div class="post-form-row__field post-form-row__field--sm">
                                            <select id="pattern_id" class="form-select" name="pattern_id">
                                                <option value="">未選択</option>
                                                @foreach ($patterns as $pattern)
                                                <option value="{{ $pattern->id }}" @selected($pattern->id === (int)old('pattern_id'))>{{ $pattern->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- 応募条件 --}}
                                    <div class="post-form-row">
                                        <span class="post-form-row__label">応募条件</span>
                                        <div class="post-form-row__field d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="accept_single" name="accept_single" @checked(old('accept_single')==='1' )>
                                                <label class="form-check-label" for="accept_single">単身者応募可</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="accept_senior" name="accept_senior" @checked(old('accept_senior')==='1' )>
                                                <label class="form-check-label" for="accept_senior">高齢者応募可</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-center mt-3 mb-2">
                                    <button type="submit" class="btn btn-secondary px-4 py-2">検索</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- カード一覧 --}}
            @if ($posts->isEmpty())
            <div class="applies-page__empty">
                <p>該当する募集がありません</p>
            </div>
            @else
            <div class="apply-card-grid">
                @foreach ($posts as $post)
                @php $closed = in_array($post->status, [3, 4], true) @endphp
                <div class="apply-card {{ $closed ? 'apply-card--closed' : '' }}">
                    <img
                        src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($post->photo1)) }}"
                        class="apply-card__photo"
                        alt="写真">
                    <div class="apply-card__body">
                        <h5 class="apply-card__post-title">{{ $post->title }}</h5>
                        <table class="table table-bordered border-secondary table-sm">
                            <tbody>
                                <tr>
                                    <th class="table-secondary text-center">状況</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}" width="70%">
                                        {{ App\Models\Post::getStatusName($post->status) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">年齢</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $post->age_year }} 歳 {{ $post->age_month }} ヶ月
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">性別</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $post->genderLabel }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-secondary text-center">所在地</th>
                                    <td class="ps-2 {{ $closed ? 'table-secondary' : 'bg-white' }}">
                                        {{ $post->location->name }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="apply-card__actions">
                            <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="btn btn-secondary px-4">詳細</a>
                            <form action="{{ route('posts.like', $post) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $post->likes->contains('user_id', auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }}">
                                    <i class="bi {{ $post->likes->contains('user_id', auth()->id()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="applies-page__pagination">
                {{ $posts->links() }}
            </div>
            @endif

        </div>
    </div>
</section>
@endsection