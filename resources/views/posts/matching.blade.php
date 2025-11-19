@extends('layouts.common')

@section('title', 'マッチング一覧')
@section('content')
<section class="py-8">
    <div class="container px-4 mx-auto">
        <div class="py-4 px-3 px-lg-4 bg-white rounded">
            <div class="ml-auto mb-4 flex">
                <h3 class="text-xl font-bold">あなたにマッチした募集一覧</h3>
                <h6 class="text-xl font-bold">(所在地または応募可能地域が一致した募集のみ表示されます。)</h6>
            </div>
            <!-- ▼絞り込み検索▼ -->
            <div class="accordion mb-3" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            絞り込み検索
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form action="{{ route('matchings.index', [Illuminate\Support\Facades\Auth::user()]) }}" method="GET">
                                @csrf
                                <div class="form-group">
                                    <div class="row d-flex align-items-center mb-lg-1">
                                        <label class="col-3 col-lg-1 text-lg-end" for="location_id">所在地</label>
                                        <div class="col-9 col-lg-2">
                                            <select id="location_id" class="form-select" aria-label="location" name="location_id">
                                                <option value="" selected>未選択</option>
                                                @foreach ($locations as $location)
                                                <option value="{{ $location->id }}" @if($location->id === (int)old('location_id')) selected @endif > {{ $location->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-3 col-lg-1 text-lg-end" for="status">状況</label>
                                        <div class="col-9 col-lg-3 my-2">
                                            <select id="status" class="form-select" aria-label="status" name="status">
                                                <option value="" selected>未選択</option>
                                                <option value="0" @if(old('status')==='0' ) selected @endif>募集中</option>
                                                <option value="1" @if(old('status')==='1' ) selected @endif>検討中</option>
                                                <option value="2" @if(old('status')==='2' ) selected @endif>トライアル中</option>
                                                <option value="3" @if(old('status')==='3' ) selected @endif>募集終了</option>
                                                <option value="4" @if(old('status')==='4' ) selected @endif>里親決定済</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row d-flex align-items-center">
                                        <label class="col-3 col-lg-1 text-lg-end mb-2" for="age_from">年齢</label>
                                        <div class="col-9 col-lg-2 d-flex align-items-center mb-2">
                                            <input id="age_from" class="form-control text-sm border rounded text-end" type="text" name="age_from" value="{{ old('age_from') }}" style="width: 60px;">
                                            <label class="text-end mx-1" for="age_to">〜</label>
                                            <input id="age_to" class="form-control text-sm border rounded text-end" type="text" name="age_to" value="{{ old('age_to') }}" style="width: 60px;">
                                            <label class="ms-xl-2">歳</label>
                                        </div>
                                        <label class="col-3 col-lg-1 text-lg-end mb-2" for="gender">性別</label>
                                        <div class="col-9 col-lg-2 mb-2">
                                            <select id="gender" class="form-select" aria-label="gender" name="gender">
                                                <option value="" selected>未選択</option>
                                                <option value="0" @if(old('gender')==='0' ) selected @endif>オス</option>
                                                <option value="1" @if(old('gender')==='1' ) selected @endif>メス</option>
                                            </select>
                                        </div>
                                        <label class="col-3 col-lg-1 text-lg-end mb-2" for="breed_id">種類</label>
                                        <div class="col-9 col-lg-2">
                                            <select id="breed_id" class="form-select mb-2" aria-label="breed" name="breed_id">
                                                <option value="" selected>未選択</option>
                                                @foreach ($breeds as $breed)
                                                <option value="{{ $breed->id }}" @if($breed->id === (int)old('breed_id')) selected @endif > {{ $breed->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-3 col-lg-1 text-lg-end mb-2" for="pattern_id">毛柄</label>
                                        <div class="col-9 col-lg-2 mb-2">
                                            <select id="pattern_id" class="form-select" aria-label="pattern" name="pattern_id">
                                                <option value="" selected>未選択</option>
                                                @foreach ($patterns as $pattern)
                                                <option value="{{ $pattern->id }}" @if($pattern->id === (int)old('pattern_id')) selected @endif > {{ $pattern->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row d-flex align-items-start mt-lg-1 mb-1">
                                        <label class="col-3 col-lg-1 text-lg-end">応募条件</label>
                                        <div class="col-9 col-lg-4 d-flex align-items-center justify-content-start">
                                            <div class="form-check d-flex justify-content-center me-4 me-lg-5">
                                                <input class="form-check-input" type="checkbox" value="1" id="accept_single" name="accept_single" @if(old('accept_single')==='1' ) checked @endif>
                                                <label class="form-check-label ms-1" for="accept_single">
                                                    単身者応募可
                                                </label>
                                            </div>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" value="1" id="accept_senior" name="accept_senior" @if(old('accept_senior')==='1' ) checked @endif>
                                                <label class="form-check-label ms-1" for="accept_senior">
                                                    高齢者応募可
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center mt-lg-2 mt-3 mb-2">
                                    <button type="submit" class="btn btn-secondary col-4 col-lg-2 py-2 px-4">検索</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ▲絞り込み検索▲ -->
            @if($posts->isEmpty())
            <div class="row">
                <div class="col my-3 mx-auto">
                    <p class="text-center fs-5">該当する募集がありません</p>
                </div>
            </div>
            @else
            <div class="row row-cols-md-2 row-cols-lg-3 row-cols-xl-4 mb-lg-3">
                @foreach($posts as $post)
                <div class="px-3 py-3">
                    <div class="card px-3 shadow" @if(in_array($post->status, [3, 4], true)) style="background-color: #DCDCDC;" @endif>
                        <img src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($post->photo1)) }}" class="card-img-top rounded mt-2" alt="写真" height="250" width="250" style="object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-truncate">{{ $post->title }}</h5>
                            <p class="card-text">
                            <table class="table table-bordered border-secondary table-sm px-3">
                                <tbody>
                                    <tr>
                                        <th class="table-secondary text-center">状況</th>
                                        <td class="ps-2 @if(in_array($post->status, [3, 4], true)) table-secondary @else bg-white @endif" width="70%">
                                            {{ App\Models\Post::getStatusName($post->status) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">年齢</th>
                                        <td class="ps-2 @if(in_array($post->status, [3, 4], true)) table-secondary @else bg-white @endif">
                                            {{ $post->age_year }} 歳 {{ $post->age_month }} ヶ月
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">性別</th>
                                        <td class="ps-2 @if(in_array($post->status, [3, 4], true)) table-secondary @else bg-white @endif">
                                            {{ $post->gender == 0 ? 'オス' : 'メス';}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">所在地</th>
                                        <td class="ps-2 @if(in_array($post->status, [3, 4], true)) table-secondary @else bg-white @endif">
                                            {{ $post->location->name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </p>
                            <div class="text-center">
                                <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="btn btn-secondary px-4 me-3">詳細</a>
                                <form action="{{ route('posts.like', $post) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn {{ $post->likes->contains('user_id', auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }}">
                                        {!! $post->likes->contains('user_id', auth()->id()) ? '<i class="bi bi-heart-fill"></i>' : '<i class="bi bi-heart"></i>' !!}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                {{ $posts->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection