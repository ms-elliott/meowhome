<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Apply extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'applies';

    protected $fillable = [
        'post_id',
        'user_id',
        'accepted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // リレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'post_id', 'post_id')
            ->where('applied_user_id', $this->user_id);
    }

    // マイ募集の応募状況を取得する
    public static function getApplicantList(string $user_id)
    {
        return DB::raw('
            SELECT *
            FROM posts
            LEFT JOIN applies
                ON posts.id = applies.post_id
            LEFT JOIN (SELECT MAX(id) FROM messages GROUP BY post_id, applied_user_id) m
                ON applies.post_id = m.post_id
                AND applies.user_id = m.applied_user_id
            WHERE posts.user_id = ?;' ,
            [$user_id]          
        );
    }

    // 応募した人数を取得する
    public static function getApplicantCount(string $post_id)
    {
        return Apply::where('post_id', $post_id)->count();
    }

    // 募集に応募済か確認する
    public static function getIsApplied(string $post_id, string $user_id)
    {
        $is_applied = Apply::where('post_id', $post_id)
                           ->where('user_id', $user_id)
                           ->exists();
        
        return $is_applied;
    }
}
