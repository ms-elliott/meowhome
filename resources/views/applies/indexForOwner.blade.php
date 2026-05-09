@extends('layouts.common')

@section('title', '応募状況一覧')

@section('content')
<div class="container">
    <div class="owner-page">

        <h4 class="owner-page__title">応募状況一覧</h4>

        <div class="owner-table-wrap">
            <table class="table table-striped-light table-sm border text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>募集</th>
                        <th></th>
                        <th>応募者</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- TODO: レコード０件の場合の表示 --}}
                    @forelse ($posts as $post)
                    <tr class="align-middle">
                        {{-- 募集写真 --}}
                        <td>
                            <img
                                src="{{ asset('storage/posts/' . $post->post->photo1) }}"
                                class="owner-table__post-photo"
                                alt="写真">
                        </td>
                        {{-- 募集情報 --}}
                        <td class="owner-table__post-info">
                            <p class="mb-1">【{{ App\Models\Post::getStatusName($post->post->status) }}】</p>
                            <p class="lh-1">{{ $post->post->title }}</p>
                        </td>
                        {{-- 応募者情報 --}}
                        <td class="owner-table__applicant">
                            @php $applicant = App\Models\User::find($post->apply->user_id) @endphp
                            <img
                                src="{{ asset('storage/' . ($applicant->image ?? 'user_default.png')) }}"
                                class="owner-table__applicant-avatar"
                                alt="">
                            <p class="mt-1 mb-2 lh-1">
                                {{ $applicant->name }}<br>
                                <span class="owner-table__apply-date">申請：{{ $post->apply->created_at->format('Y/m/d') }}</span>
                            </p>
                            <a href="{{ route('posts.show', [$post->post_id, $post->applied_user_id]) }}">
                                <i class="bi bi-chat-left-text position-relative owner-table__message-icon">
                                    @if (is_null($post->is_read_at))
                                    <span class="unread-badge"><span class="visually-hidden">未読あり</span></span>
                                    @endif
                                </i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">応募はありません</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection