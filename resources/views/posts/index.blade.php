@extends('layouts.common')

@section('title', 'マイ募集一覧')
@section('content')
<section class="py-3">
    <div class="container px-4 mx-auto">
        <div class="py-4 px-4 bg-white rounded">
            <div class="ml-auto mb-md-4 d-flex justify-content-between">
                <h2 class="text-xl font-bold">マイ募集一覧</h2>
                <a href="{{ route('posts.create', ['id' => $id]) }}" class="btn btn-secondary py-2 px-4 text-m font-semibold">新規募集</a>
            </div>
            @if(session('success'))
            <div class="row d-flex justify-content-start mt-2">
                <div class="col mx-md-3 py-1 alert alert-primary">
                    <p class="text-primary mb-1">{{ session('success') }}</p>
                </div>
            </div>
            @endif
            @if($posts->isEmpty())
            <div class="row">
                <div class="col my-3 mx-auto">
                    <p class="text-center fs-5">投稿した募集はありません</p>
                </div>
            </div>
            @else
            <div class="row row-cols-md-4 mb-md-3">
                @foreach($posts as $post)
                <div class="px-3 py-3">
                    <div class="card px-3 shadow" @if(in_array($post->status, [3, 4], true)) style="background-color: #DCDCDC;" @endif>
                        <img src="{{ asset('storage/posts/' . $post->photo1) }}" class="card-img-top rounded mt-2" alt="写真" height="250" width="250" style="object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-truncate">{{ $post->title }}</h5>
                            <p class="card-text">
                            <table class="table table-bordered border-secondary table-sm px-3">
                                <tbody>
                                    <tr>
                                        <th class="table-secondary text-center">状況</th>
                                        <td class="ps-2 @if(in_array($post->status, [3, 4], true)) table-secondary @else bg-white @endif" width="70%">{{ App\Models\Post::getStatusName($post->status) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">年齢</th>
                                        <td class="ps-2 @if(in_array($post->status, [3, 4], true)) table-secondary @else bg-white @endif">{{ $post->age_year }} 歳 {{ $post->age_month }} ヶ月</td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">性別</th>
                                        <td class="ps-2 @if(in_array($post->status, [3, 4], true)) table-secondary @else bg-white @endif">{{ $post->gender == 0 ? 'オス' : 'メス'; }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">掲載日</th>
                                        <td class="ps-2 @if(in_array($post->status, [3, 4], true)) table-secondary @else bg-white @endif"><?php echo ($post->created_at)->format('Y/m/d'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            </p>
                            <div class="text-center">
                                <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="botton btn btn-outline-secondary px-4 me-3">詳細</a>
                                <a href="{{ route('applies.indexPost', [$post->id]) }}" class="botton btn btn-secondary px-3 position-relative">応募者 ({{ App\Models\Apply::getApplicantCount($post->id) }})
                                    @if(App\Models\Message::getUnreadCount($post->id) > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2"><span class="visually-hidden">unread posts</span></span>
                                    @endif
                                </a>
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