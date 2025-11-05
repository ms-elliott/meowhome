@extends('layouts.common')

@section('title', 'メッセージ詳細')
@section('content')
<div class="sticky-top" style="background-color: #fff5ee;">
  @include('parts.header')
  <div class="row" style="background-color: #fff5ee;">
    <div class="d-flex align-items-center">
      <div class="col-12 col-md-4 ms-md-4 d-flex justify-content-center justify-content-md-start">
        <div class="border border-3 bg-light rounded px-2 py-2 w-100">
          <!-- 対象の投稿を表示 -->
          <div class="d-flex align-text-center justify-content-start">
            <div class="col-10">
              <p class="mb-1">ー こちらの里親募集について ー</p>
              <a href="{{ route('posts.show', [$messages[0]->post->id]) }}" class="alert-link">
                <p class="mb-1 text-body-secondary text-truncate" style="max-width: 100%">【{{$messages[0]->post->title}}】</p>
              </a>
            </div>
            <img src="{{ asset('storage/posts/' . App\Http\Controllers\ImageController::convert2fileName($messages[0]->post->photo1)) }}" class="object-fit-cover border rounded mx-auto" alt="写真" height="60" width="60">
          </div>
          @if(session()->has('error'))
          <div class="row">
            <div class="d-flex align-items-center">
              <div class="col-6 mt-2 mb-3 px-3 py-1 border border-danger bg-light rounded">
                <p class="text-danger my-auto">{{ session('error') }}</p>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mt-3 mx-2">
    @foreach($messages as $message)
    @if($message->sent_by != auth()->user()->id)
    <!-- 左の吹き出し / 相手 -->
    <div class="balloon-chat left mb-1">
      <figure class="icon-img">
        <a href="{{ route('users.show', [$message->post->user->id]) }}">
          <img src="{{ isset(App\Models\User::find($message->sent_by)->image) ? asset('storage/users/' . App\Http\Controllers\ImageController::convert2fileName(App\Models\User::find($message->sent_by)->image)) : asset('storage/users/user_default.png') }}" alt="プロフィール画像" height="80" width="80" style="object-fit: cover;">
        </a>
        <figcaption class="icon-name text-truncate" style="max-width: 90%;">{{ App\Models\User::find($message->sent_by)->name }}</figcaption>
      </figure>
      <div class="col-9">
        <div class="chatting">
          <p class="chat-text mb-1">{!! nl2br(e($message->message)) !!}</p>
        </div>
        <p class="text-start ms-4 lh-1" style="font-size: xx-small; left: -15px;">
          <?php echo ($message->created_at)->format('Y/m/d H:i'); ?>
        </p>
      </div>
    </div>
    @else
    <!-- 右の吹き出し / 自分 -->
    <div class="balloon-chat right mb-1">
      <figure class="icon-img"><img src="{{ isset(auth()->user()->image) ? asset('storage/users/' . App\Http\Controllers\ImageController::convert2fileName(auth()->user()->image)) : asset('storage/users/user_default.png') }}" alt="プロフィール画像" height="80" width="80" style="object-fit: cover;">
        <figcaption class="icon-name text-truncate" style="max-width: 90%;">{{ auth()->user()->name }}</figcaption>
      </figure>
      <div class="col-9 text-end">
        <div class="chatting">
          <p class="chat-text">{!! nl2br(e($message->message)) !!}</p>
        </div>
        <p class="text-end me-4" style="font-size: xx-small; right: -15px;">
          <?php echo ($message->created_at)->format('Y/m/d H:i'); ?> ({{ is_null($message->read_at) ? '未読' : '既読'}})
        </p>
      </div>
    </div>
    @endif
    @endforeach
  </div>
</div>
<div class="footer-fix">
  <form action="{{ route('messages.store', ['post_id' => $messages[0]->post_id, 'user_id' => $messages[0]->applied_user_id]) }}" method="post">
    @csrf
    <input type="hidden" name="post_id" value="{{ $messages[0]->post_id }}">
    <input type="hidden" name="applied_user_id" value="{{ $messages[0]->applied_user_id }}">
    <div class="row">
      <div class="d-flex justify-content-center w-75 mx-auto">
        <textarea id="message" class="form-control text-sm bg-white px-md-2 py-1 border rounded pure-input-1" name="message" rows="1" maxlength="255">{{ old('message') }}</textarea>
        <button type="submit" class="btn btn-secondary col-3 col-md-1 px-md-4 ms-1 ms-md-3" style="height: fit-content;">送信</button>
      </div>
    </div>
  </form>
  <div class="mt-1" id="footer">
    @include('parts.footer')
  </div>
</div>
<!-- ページアクセス時にスクロールを最下部に設定 -->
<script>
  const scrollerInner = document.getElementById("footer");
  scrollerInner.scrollIntoView(false);
</script>
@endsection