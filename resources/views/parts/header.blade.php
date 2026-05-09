{{-- ナビゲーションメニュー --}}
@if (Route::has('login'))
<nav class="site-nav navbar navbar-expand-md">
    <div class="container-fluid">

        {{-- ロゴ --}}
        <a class="navbar-brand site-nav__brand" href="{{ route('welcome') }}">
            <img src="{{ asset('mh_images/meowhome_logo.png') }}" alt="MeowHome" height="20">
        </a>

        {{-- ハンバーガーボタン --}}
        <button
            type="button"
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#navbarForm"
            aria-controls="navbarForm"
            aria-expanded="false"
            aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- ナビリンク --}}
        <div class="collapse navbar-collapse" id="navbarForm">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                <li class="nav-item">
                    <a class="nav-link site-nav__link" href="{{ route('mypage.show', auth()->id()) }}">マイページ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link site-nav__link position-relative" href="{{ route('messages.index', auth()->id()) }}">
                        メッセージ
                        @if (App\Models\Message::getUnreadCount() > 0)
                        <span class="unread-badge"><span class="visually-hidden">未読あり</span></span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a
                            class="nav-link site-nav__link"
                            href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            ログアウト
                        </a>
                    </form>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link site-nav__link" href="{{ route('users.create') }}">ユーザー登録</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link site-nav__link" href="{{ route('login') }}">ログイン</a>
                </li>
                @endauth
            </ul>
        </div>

    </div>
</nav>
@endif