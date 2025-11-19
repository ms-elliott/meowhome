@extends('layouts.common')

@section('title', 'お気に入り')
@section('content')
<section class="py-8">
    <div class="container px-3 px-md-4 mx-auto">
        <div class="py-4 px-3 px-md-4 bg-white rounded">
            <div class="ml-auto mb-2 d-flex justify-content-between">
                <h2 class="text-xl font-bold">お気に入り募集一覧</h2>
            </div>
            @if($likes->isEmpty())
            <div class="row">
                <div class="col my-3 text-center">
                    <p class="fs-5 mx-auto">お気に入り登録した募集はありません</p>
                    <a href="{{ route('matchings.index', Auth()->user()->id) }}" class="btn btn-secondary mt-2 px-3">マッチした投稿から探す</a>
                </div>
            </div>
            @else
            <div class="row row-cols-md-2 row-cols-lg-3 row-cols-xl-4 mb-3">
                @foreach($likes as $like)
                <div class="px-3 py-3">
                    <div class="card px-3 shadow" @if(in_array($like->post->status, [3, 4], true)) style="background-color: #DCDCDC;" @endif>
                        <img src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($like->post->photo1)) }}" class="card-img-top rounded mt-2" alt="写真" height="250" width="250" style="object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-truncate">{{ $like->post->title }}</h5>
                            <p class="card-text">
                            <table class="table table-bordered border-secondary table-sm px-3">
                                <tbody>
                                    <tr>
                                        <th class="table-secondary text-center">状況</th>
                                        <td class="ps-2 @if(in_array($like->post->status, [3, 4], true)) table-secondary @else bg-white @endif" width="70%">
                                            {{ App\Models\Post::getStatusName($like->post->status) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">年齢</th>
                                        <td class="ps-2  @if(in_array($like->post->status, [3, 4], true)) table-secondary @else bg-white @endif">
                                            {{ $like->post->age_year }} 歳 {{ $like->post->age_month }} ヶ月
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">性別</th>
                                        <td class="ps-2 @if(in_array($like->post->status, [3, 4], true)) table-secondary @else bg-white @endif">
                                            {{ $like->post->gender == 0 ? 'オス' : 'メス';}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">所在地</th>
                                        <td class="ps-2 @if(in_array($like->post->status, [3, 4], true)) table-secondary @else bg-white @endif">
                                            {{ $like->post->location->name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </p>
                            <div class="d-flex justify-content-center justify-content-md-between">
                                <a href="{{ route('posts.show', $like->post->id) }}" class="btn btn-outline-secondary px-4 me-3 me-md-0">詳細</a>
                                <a href="{{ route('applies.create', $like->post->id) }}" class="btn btn-secondary px-4 @if(in_array($like->post->status, [3, 4], true) || (App\Models\Apply::getIsApplied($like->post->id, Auth()->user()->id))) disabled @endif" role="button" aria-disabled="true">
                                    @if(App\Models\Apply::getIsApplied($like->post->id, Auth()->user()->id))
                                    応募済
                                    @else
                                    里親応募
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                {{ $likes->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection