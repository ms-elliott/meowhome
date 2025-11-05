@extends('layouts.common')

@section('title', 'メッセージ一覧')
@section('content')
<div class="container">
    <div class="border bg-white px-2 py-2 mx-3 my-2">
        <h4 class="ms-2 mt-2 mb-3">メッセージ一覧</h4>
        <div class="row mx-1 mx-md-3">
            <div class="mx-auto">
                <table class="table table-striped-light table-sm px-3 border text-md-center table_design08">
                    <thead class="table-secondary">
                        <tr>
                            <th>募集/応募</th>
                            <th colspan="2">投稿</th>
                            <th>状況</th>
                            <!-- <th>年齢</th>
                            <th>性別</th> -->
                            <th>申請者</th>
                            <th>申請日</th>
                            <th>最終メッセージ</th>
                            <th>送信者</th>
                            <th>詳細</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr class="align-middle">
                            <th width="8%">
                                <p class="fs-5 lh-1 my-1 ms-2 align-middle text-center">
                                    <span class="badge @if($message->applied_user_id == Auth()->user()->id) text-bg-warning text-white @else text-bg-success @endif">
                                        {{ ($message->applied_user_id == Auth()->user()->id) ? '応募' : '募集' }}
                                    </span>
                                </p>
                            </th>
                            <td width="6%" data-label="投稿"><img src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($message->post->photo1)) }}" class="object-fit-cover border rounded" alt="写真" height="80" width="80"></td>
                            <td width="35%" data-label="タイトル">{{ $message->post->title }}</td>
                            <td class="ps-1" width="8%" data-label="状況">{{ App\Models\Post::getStatusName($message->post->status) }}</td>
                            <!-- <td class="ps-1" width="10%">{{ $message->post->age_year }} 歳 {{ $message->post->age_month }} ヶ月</td>
                            <td class="ps-1" width="5%">{{ $message->post->gender == 0 ? 'オス' : 'メス'; }}</td> -->
                            <td class="ps-1" width="10%" data-label="応募者" id="with-label">{{ $message->user->name }}</td>
                            <td class="ps-1" width="8%" data-label="応募日時" id="with-label"><?php echo ($message->apply->created_at)->format('Y/m/d'); ?></td>
                            <td class="ps-1" width="10%" data-label="最終メッセージ" id="with-label"><?php echo ($message->created_at)->format('Y/m/d H:i'); ?></td>
                            <td class="ps-1" width="10%" data-label="送信者" id="with-label">{{ App\Models\User::find($message->sent_by)->name }}</td>
                            <td class="ps-1" width="10%" data-label="詳細" id="with-label">
                                <a href="{{ route('messages.show', [$message->post_id, $message->applied_user_id]) }}">
                                    <i class="bi bi-chat-left-text position-relative" style="font-size: 2rem;">
                                        @if(App\Models\Message::getUnreadCount($message->post_id, $message->applied_user_id) > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2"><span class="visually-hidden">unread posts</span></span>
                                        @endif
                                    </i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($messages->isEmpty())
                <div class="row">
                    <div class="col my-5 mx-auto">
                        <p class="text-center fs-5">メッセージはありません</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="text-center my-4">
            {{ $messages->links() }}
        </div>
    </div>
</div>

@endsection