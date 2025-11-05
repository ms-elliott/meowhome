<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // マイページ画面表示
    public function show(string $id)
    {
        // ログインユーザーidと異なる場合はエラー
        abort_if($id != Auth::user()->id, 403);

        $user = User::find($id);
        $user['image'] =  isset($user->image) ? pathinfo($user->image, PATHINFO_BASENAME) : null;
        return view('mypage', ['user' => $user]);
    }
}
