@extends('layouts.common')

@section('title', 'メッセージ一覧')

@section('content')
<div class="container">
    <div class="msg-list-page">

        <h4 class="msg-list-page__title">メッセージ一覧</h4>

        <div class="msg-list-page__table-wrap">
            <table class="table table-striped-light table-sm border text-md-center table_design08">
                <thead class="table-secondary">
                    <tr>
                        <th>募集/応募</th>
                        <th colspan="2">投稿</th>
                        <th>状況</th>
                        <th>申請者</th>
                        <th>申請日</th>
                        <th>最終メッセージ</th>
                        <th>送信者</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                    @php $isApplicant = $message->applied_user_id == auth()->id() @endphp
                    <tr class="align-middle">
                        {{-- 募集/応募バッジ --}}
                        <th width="8%">
                            <span class="badge {{ $isApplicant ? 'text-bg-warning text-white' : 'text-bg-success' }}">
                                {{ $isApplicant ? '応募' : '募集' }}
                            </span>
                        </th>
                        {{-- 投稿写真 --}}
                        <td width="6%" data-label="投稿">
                            <img
                                src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($message->post->photo1)) }}"
                                class="object-fit-cover border rounded"
                                alt="写真"
                                height="80"
                                width="80">
                        </td>
                        {{-- 投稿タイトル --}}
                        <td width="35%" data-label="タイトル">{{ $message->post->title }}</td>
                        {{-- 状況 --}}
                        <td class="ps-1" width="8%" data-label="状況">
                            {{ App\Models\Post::getStatusName($message->post->status) }}
                        </td>
                        {{-- 応募者 --}}
                        <td class="ps-1" width="10%" data-label="応募者">
                            {{ $message->user->name }}
                        </td>
                        {{-- 申請日 --}}
                        <td class="ps-1" width="8%" data-label="応募日時">
                            {{ $message->apply->created_at->format('Y/m/d') }}
                        </td>
                        {{-- 最終メッセージ --}}
                        <td class="ps-1" width="10%" data-label="最終メッセージ">
                            {{ $message->created_at->format('Y/m/d H:i') }}
                        </td>
                        {{-- 送信者 --}}
                        <td class="ps-1" width="10%" data-label="送信者">
                            {{ App\Models\User::find($message->sent_by)->name }}
                        </td>
                        {{-- 詳細リンク --}}
                        <td class="ps-1" width="10%" data-label="詳細">
                            <a href="{{ route('messages.show', [$message->post_id, $message->applied_user_id]) }}">
                                <i class="bi bi-chat-left-text position-relative msg-list-page__chat-icon">
                                    @if (App\Models\Message::getUnreadCount($message->post_id, $message->applied_user_id) > 0)
                                    <span class="unread-badge"><span class="visually-hidden">未読あり</span></span>
                                    @endif
                                </i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- 空状態 --}}
            @if ($messages->isEmpty())
            <div class="msg-list-page__empty">
                <p>メッセージはありません</p>
            </div>
            @endif
        </div>

        <div class="msg-list-page__pagination">
            {{ $messages->links() }}
        </div>

    </div>
</div>
@endsection