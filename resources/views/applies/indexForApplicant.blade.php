@extends('layouts.common')

@section('title', '里親申請一覧')
@section('content')
<section class="py-8">
    <div class="container px-4 mx-auto">
        <div class="py-4 px-4 bg-white rounded">
            <div class="ml-auto d-flex justify-content-between">
                <h4 class="text-xl font-bold">応募済一覧</h4>
            </div>
            <div class="row">
                <div>
                    <h6>（自分が里親応募した募集一覧）</h6>
                </div>
            </div>
            @if(session('success'))
            <div class="row">
                <div class="d-flex align-items-center">
                    <div class="col-md-6 mt-2 mb-3 px-3 py-1 border border-primary bg-light rounded">
                        <p class="text-primary my-auto">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($applies->isEmpty())
            <div class="row">
                <div class="col mt-5 mb-3">
                    <p class="fs-5 text-center">応募済の里親募集はありません</p>
                </div>
            </div>
            @else
            <div class="row row-cols-md-4 mb-3">
                @foreach($applies as $apply)
                <div class="px-2 px-md-3 py-3">
                    <div class="card px-3 shadow" @if(in_array($apply->post->status, [3, 4], true)) style="background-color: #DCDCDC;" @endif>
                        <img src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($apply->post->photo1)) }}" class="card-img-top rounded mt-2" alt="写真" height="250" width="250" style="object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-truncate">{{ $apply->post->title }}</h5>
                            <p class="card-text">
                            <table class="table table-bordered border-secondary table-sm">
                                <tbody>
                                    <tr>
                                        <th class="table-secondary text-center">申請日</th>
                                        <td class="ps-2 @if(in_array($apply->post->status, [3, 4], true)) table-secondary @else bg-white @endif" width="55%">
                                            <?php echo ($apply->created_at)->format('Y/m/d'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">状況</th>
                                        <td class="ps-2 @if(in_array($apply->post->status, [3, 4], true)) table-secondary @else bg-white @endif">
                                            {{ App\Models\Post::getStatusName($apply->post->status) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary text-center">投稿更新日</th>
                                        <td class="ps-2 @if(in_array($apply->post->status, [3, 4], true)) table-secondary @else bg-white @endif">
                                            <?php echo ($apply->post->updated_at)->format('Y/m/d'); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </p>
                            <div class="text-center">
                                <a href="{{ route('posts.show', $apply->post->id) }}" class="btn btn-outline-secondary px-3 me-2">投稿詳細</a>
                                <a href="{{ route('messages.show', ['post_id' => $apply->post->id, 'applied_id' => $apply->user_id]) }}" class="btn btn-secondary px-3 position-relative">メッセージ
                                    @if(App\Models\Message::getUnreadCount($apply->post->id, Auth()->user()->id) > 0)
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
                {{ $applies->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection