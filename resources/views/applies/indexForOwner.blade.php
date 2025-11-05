@extends('layouts.common')

@section('title', '応募状況一覧')
@section('content')
<div class="container">
    <div class="border bg-white px-2 py-2 mx-3 my-2">
        <h4 class="ms-2 mt-2 mb-3">応募状況一覧</h4>
        <div class="row mx-3 ">
            <div class="mx-auto">
                <table class="table table-striped-light table-sm px-3 border text-center">
                    <tbody>
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
                            <!-- TODO: レコード０件の場合->一旦保留 -->
                            <p>応募はありません</p>
                            @foreach($posts as $post)
                            <tr class="align-middle">
                                <td width="6%"><img src="{{ asset('storage/posts/' . $post->post->photo1) }}" class="border rounded me-2" alt="写真" height="120" width="120" style="object-fit: cover;"></td>
                                <td class="" width="20%">
                                    <p class="mb-1">【{{ App\Models\Post::getStatusName($post->post->status) }}】</p>
                                    <p class="lh-1">{{ $post->post->title }}</p>
                                </td>
                                <td class="ps-2" width="15%">
                                    <img class="rounded-circle" src="{{ asset('storage/' . (optional(App\Models\User::find($post->apply->user_id))->image ?? 'user_default.png')) }}" alt="" height="60" width="60" style="object-fit: cover;">
                                    <p class="mt-1 mb-2 lh-1">{{ App\Models\User::find($post->apply->user_id)->name }}<br>
                                        <span style="font-size: x-small;">申請：<?php echo ($post->apply->created_at)->format('Y/m/d'); ?></span>
                                    </p>
                                    <a href="{{ route('posts.show', [$post->post_id, $post->applied_user_id]) }}">
                                        <i class="bi bi-chat-left-text position-relative" style="font-size: 1.5rem;">
                                            @if(is_null($post->is_read_at))
                                            <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2"><span class="visually-hidden">unread posts</span></span>
                                            @endif
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </thead>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection