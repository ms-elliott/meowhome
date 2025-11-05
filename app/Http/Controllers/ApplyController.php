<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplyRequest;
use App\Models\Apply;
use App\Models\Message;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // 応募者一覧画面
    public function indexForPost(string $post_id)
    {
        // ログインユーザーidと異なる場合はエラー
        abort_if(Post::find($post_id)->user_id != Auth::user()->id, 403);

        // 応募を取得
        $applies = Apply::where('post_id', $post_id)
            ->with('user')
            ->latest()
            ->simplePaginate(8);

        return view('applies.indexForPost', ['applies' => $applies]);
    }

    // 応募済一覧画面
    public function indexForApplicant(string $user_id)
    {
        // ログインユーザーidと異なる場合はエラー
        abort_if($user_id != Auth::user()->id, 403);

        // 自分が応募した一覧
        $myApplications = Apply::where('user_id', $user_id)->latest()->with('post')->simplePaginate(8);

        return view('applies.indexForApplicant', ['applies' => $myApplications]);
    }

    // // 応募状況一覧画面（募集者側）
    // public function indexForOwner(string $user_id)
    // {
    //     $user = Auth::user();

    //     // 応募状況を取得
    //     $posts = Apply::getApplicantList($user->id);

    //     return view('applies.indexForOwner', ['posts' => $posts]);
    // }

    // 申請画面
    public function create(string $post_id)
    {
        $post = Post::find($post_id);
        return view('applies.create', ['post' => $post]);
    }

    // 申請登録処理
    public function store(StoreApplyRequest $request)
    {
        // ログインユーザーidと異なる場合はエラー
        abort_if($request->user_id != Auth::user()->id, 403);

        //　メッセージ用バリデーション　
        $validatedMessage = $request->validate([
            'message' => ['required', 'string', 'max:255'],
        ]);

        $validatedApply = $request->validated();

        $post_id = $validatedApply['post_id'];
        $user_id = $validatedApply['user_id'];

        $apply = new Apply();
        $apply->post_id = $post_id;
        $apply->user_id = $user_id;
        $apply->save();

        // メッセージテーブルにも保存
        $message = new Message();
        $message->post_id = $post_id;
        $message->applied_user_id = $user_id;
        $message->sent_by = $user_id;
        $message->sent_to = Post::find($post_id)->user_id;
        $message->message = $validatedMessage['message'];
        $message->save();

        return redirect()->route('applies.indexApplicant', ['user_id' => $user_id])->with('success', '応募申請が完了しました');
    }
}
