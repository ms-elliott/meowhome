<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MEOW HOME')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- ファビコン --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="layout-wrapper">

        {{-- ヘッダー（メッセージ詳細画面では非表示） --}}
        @unless (Route::currentRouteName() === 'messages.show')
        <header class="layout-header">
            @include('parts.header')
        </header>
        @endunless

        <main class="layout-main">
            @yield('content')
        </main>

        {{-- フッター（メッセージ詳細画面では非表示） --}}
        @unless (Route::currentRouteName() === 'messages.show')
        @include('parts.footer')
        @endunless

    </div>
</body>

</html>