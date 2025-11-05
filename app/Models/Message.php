<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'messages';

    protected $fillable = [
        'post_id',
        'applied_user_id',
        'sent_by',
        'sent_to',
        'message',
        'read_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // リレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'applied_user_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function apply()
    {
        return $this->belongsTo(Apply::class, 'post_id', 'post_id')
            ->withDefault(['user_id' => $this->applied_user_id]);
    }

    // 未読メッセージ数を取得
    public static function getUnreadCount(?string $post_id = null, ?string $applied_user_id = null)
    {
        $unreadCount = 0;
        $my_user_id = Auth::user()->id;

        if (is_null($post_id) && is_null($applied_user_id)) {
            // 自分宛の全ての未読メッセージ
            $unreadCount = Message::where('sent_to', $my_user_id)
                                    ->whereNull('read_at')
                                    ->count();
        } elseif(!is_null($post_id) && is_null($applied_user_id)) {
            // 対象の募集投稿に対する未読メッセージ
            $unreadCount = Message::where('post_id', $post_id)
                                    ->where('sent_to', $my_user_id)
                                    ->whereNull('read_at')
                                    ->count();            
        } else {
            // 対象の応募に対する未読メッセージ
            $unreadCount = Message::where('post_id', $post_id)
                                    ->where('applied_user_id', $applied_user_id)
                                    ->where('sent_to', $my_user_id)
                                    ->whereNull('read_at')
                                    ->count();
        }

        return $unreadCount;
    }

    // メッセージを既読にする
    public static function readMessage(string $post_id, string $applied_user_id) 
    {
        $user_id = Auth::user()->id;
        $unreadExist = Message::where('post_id', $post_id)
                              ->where('applied_user_id', $applied_user_id)
                              ->where('sent_to', $user_id)
                              ->whereNull('read_at')
                              ->exists();
        
        if($unreadExist) {
            Message::where('post_id', $post_id)
                    ->where('applied_user_id', $applied_user_id)
                    ->where('sent_to', $user_id)
                    ->whereNull('read_at')
                    ->update([
                        'read_at' => NOW()
                    ]);         
        }

        return;
    }
}
