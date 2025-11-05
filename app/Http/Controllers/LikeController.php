<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // お気に入り一覧画面
    public function index(User $user)
    {
        $login_user = Auth::user();

        // ログインユーザーidと異なる場合はエラー
        abort_if($user->id != $login_user->id, 403);

        $likes = Like::where('user_id', $user->id)
            ->latest()
            ->with('post')
            ->simplePaginate(12);

        return view('like', ['id' => $user->id, 'likes' => $likes]);
    }

    // お気に入り登録/削除　切替え処理
    public function toggleLike(Post $post)
    {
        $user = Auth::user();
        $like = $post->likes()->where('user_id', $user->id);

        if ($like->exists()) {
            $like->delete();
        } else {
            $post->likes()->create(['user_id' => $user->id]);
        }

        return redirect()->back();
    }
}
