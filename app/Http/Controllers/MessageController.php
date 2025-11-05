<?php

namespace App\Http\Controllers;

use App\Models\Apply;
use App\Models\Message;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // メッセージ一覧画面
    public function index(string $user_id)
    {
        // ログインユーザーidと異なる場合はエラー
        abort_if($user_id != Auth::user()->id, 403);

        // 募集投稿✖️応募者の組み合わせを１単位で表示する
        // 自分が投稿した募集を取得
        $myPosts = Post::select('id')
            ->where('user_id', $user_id);

        // 自分が投稿した募集 or 応募した募集
        // 最終メッセージのidを取得 
        $targetMessageIds = Message::select(DB::raw('MAX(id)'))
            ->whereIn('post_id', $myPosts)
            ->orWhere('applied_user_id', $user_id)
            ->groupBy('post_id', 'applied_user_id')
            ->get();

        // 最終メッセージの一覧を取得
        $messages = Message::whereIn('id', $targetMessageIds)
            ->with('post')
            ->with('apply')
            ->with('user')
            ->latest()
            ->simplePaginate(6);

        return view('messages.index', ['messages' => $messages]);
    }

    // メッセージ保存処理
    public function store(Request $request)
    {
        //　バリデーション
        $validated = $request->validate([
            'post_id' => ['required', 'numeric'],
            'applied_user_id' => ['required', 'numeric'],
            'message' => ['required', 'string', 'max:255'],
        ]);

        $post_id = $validated['post_id'];
        $applied_user_id = $validated['applied_user_id'];

        // 送信者のユーザーid
        $auth_id = Auth::user()->id;
        if ($applied_user_id == $auth_id) {
            $sent_to_id = Post::find($post_id)->user_id;
        } else {
            $sent_to_id = $applied_user_id;
        }

        $message = new Message();
        $message->post_id = $post_id;
        $message->applied_user_id = $applied_user_id;
        $message->sent_by = $auth_id;
        $message->sent_to = $sent_to_id;
        $message->message = $validated['message'];
        $message->save();

        return redirect()->back();
    }

    //　メッセージ詳細画面
    public function show(string $post_id, string $applied_id)
    {
        // ログインユーザーidと異なる場合はエラー
        abort_if(($applied_id != Auth::user()->id) && (Post::find($post_id)->user_id != Auth::user()->id), 403);

        $messages = Message::where('post_id', $post_id)
            ->where('applied_user_id', $applied_id)
            ->with('user')
            ->with('post')
            ->simplePaginate(20);

        // 未読->既読にする
        $applied_user_id = $messages[0]->applied_user_id;
        Message::readMessage($post_id, $applied_user_id);

        return view('messages.show', ['messages' => $messages]);
    }
}
