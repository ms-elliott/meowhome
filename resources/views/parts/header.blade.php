<!-- ナビゲーションメニュー -->
@if (Route::has('login'))
<nav class="navbar navbar-expand-md">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <img class="ms-3 me-2" src="{{ asset('mh_images/meowhome_logo.png')}}" height="20">
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarForm" aria-controls="navbarForm" aria-expanded="false" aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarForm">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                <li class="nav-item">
                    <a class="nav-link text-end pe-2" href="{{ route('mypage.show', Illuminate\Support\Facades\Auth::user()->id) }}">マイページ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative text-end pe-2" href="{{ route('messages.index', Illuminate\Support\Facades\Auth::user()->id) }}">メッセージ
                        @if(App\Models\Message::getUnreadCount() > 0)
                        <span class="position-absolute top-30 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2"><span class="visually-hidden">unread posts</span></span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="post">
                        @csrf
                        <a class="nav-link text-end pe-2 @if(App\Models\Message::getUnreadCount() > 0) ms-3 @endif" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    </form>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link text-end pe-2" href="{{ route('users.create') }}">ユーザー登録</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-end pe-2" href="{{ route('login') }}">ログイン</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
@endif