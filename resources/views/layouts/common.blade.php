<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'MEOW HOME')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- ファビコン読み込み -->
    <link rel="icon" href="/favicon.ico" sizes="any" />
    <link rel="icon" href="/favicon.svg" type="image/svg+xml" />
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .balloon-chat {
            display: flex;
            flex-wrap: wrap;
        }

        /* 左の吹き出し */
        .balloon-chat.left {
            flex-direction: row;
            /* 左から右に並べる */
        }

        /* 右の吹き出し */
        .balloon-chat.right {
            flex-direction: row-reverse;
            /* 右から左に並べる */
        }

        /* 吹き出しの入力部分の作成 */
        .chatting {
            position: relative;
            display: inline-block;
            /* 吹き出しが文字幅に合わせます */
            margin: 10px 20px;
            padding: 10px 12px;
            background: white;
            text-align: left;
            border-radius: 12px;
            word-break: break-all;
            max-width: 80vmax;
        }

        /* 吹き出しの三角部分の作成 */
        .chatting::after {
            content: "";
            border: 15px solid transparent;
            border-top-color: white;
            position: absolute;
            top: 10px;
        }

        .left .chatting::after {
            left: -15px;
        }

        .right .chatting::after {
            right: -15px;
        }

        /* アイコンの作成 */
        .balloon-chat figure img {
            border-radius: 50%;
            border: 2px solid gray;
            margin: 5px 0px;
        }

        /* アイコンの大きさ */
        .icon-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        /* アイコンの名前の設定 */
        .icon-name {
            width: 80px;
            /* アイコンの大きさと合わせる */
            font-size: 12px;
            text-align: center;
        }

        /* コンテンツ量が少ない場合にフッターを下部に固定 */
        .wrapper {
            position: relative;
            min-height: 100vh;
            padding-bottom: 100px;
        }

        .footer-fix {
            position: absolute;
            width: 100%;
            left: 0;
            bottom: 0;
        }

        /* メッセージ一覧レスポンシブ対応 */
        @media screen and (max-width: 787px) {
            .table_design08 {
                text-align: left;
            }

            .table_design08 thead {
                display: none;
            }

            .table_design08 th,
            .table_design08 td {
                display: block;
                border: 0;
                border-bottom: 2px solid #e6f1f6;
                width: 100%;
            }

            .table_design08 tbody th {
                background: darkgray;
                color: #fff;
            }

            .table_design08 td::before {
                    content: attr(data-label);
                    color: #4d9bc1;
                    font-weight: bold;
                    display: inline-block;
                    max-width: 20%;
                    min-width: 4em;
                    margin-right: 10px;
            }
        }
    </style>
</head>

<body>
    <div id="container" class="flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col m-plus-rounded-1c-regular wrapper">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm not-has-[nav]:hidden">
            @if(Route::currentRouteName() != 'messages.show')
            @include('parts.header')
            @endif
        </header>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                @yield('content')
            </main>
        </div>

        @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
        @endif
        <!-- フッター -->
        @if(Route::currentRouteName() != 'messages.show')
        @include('parts.footer')
        @endif
    </div>
</body>

</html>