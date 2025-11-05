<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'age',
        'location_id',
        'comment',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            //'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // リレーション - 居住地テーブル
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // リレーション - 投稿テーブル
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // リレーション - お気に入りテーブル
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // リレーション - 申請テーブル
    public function applies()
    {
        return $this->hasMany(Apply::class);
    }

    // リレーション - メッセージテーブル
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // ユーザー登録を論理削除した際に、関連データも論理削除する
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->posts()->delete();
            $user->applies()->delete();
            $user->likes()->delete();
        });
    }

    public static function deleteData($user_id)
    {
        $result = DB::transaction(function () use ($user_id) {
            $user = User::where('user_id', $user_id)->first();
            $user->delete();
            return true;
        });
        return $result;
    }
}
