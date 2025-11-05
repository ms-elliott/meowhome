<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Type\Integer;

class Post extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    
    // テーブル名
    protected $table = 'posts';

    // 可変項目
    protected $fillable =
    [
        'user_id',
        'title',
        'body',
        'status',
        'age_year',
        'age_month',
        'gender',
        'location_id',
        'breed_id',
        'pattern_id',
        'vaccined',
        'neutered',
        'accept_single',
        'accept_senior',
        'accept_location1',
        'accept_location2',
        'accept_location3',
        'accept_location4',
        'accept_location5',
        'photo1',
        'photo2',
        'photo3'
    ];

    // リレーション
    // ユーザーテーブル
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 居住地テーブル
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // 種類テーブル
    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    // 毛柄テーブル
    public function pattern()
    {
        return $this->belongsTo(Pattern::class);
    }

    // お気に入りテーブル
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 申請テーブル
    public function applies()
    {
        return $this->hasMany(Apply::class);
    }

    // メッセージテーブル
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // ステータス名称取得
    public static function getStatusName(int $status_id)
    {
        $name = "";

        switch ($status_id) {
            case 0:
                $name = "募集中";
                break;
            case 1:
                $name = "検討中";
                break;
            case 2:
                $name = "トライアル中";
                break;
            case 3:
                $name = "募集終了";
                break;
            case 4:
                $name = "里親決定済";
                break;
        }

        return $name;
    }

    // 応募可能地域名を取得し、「, 」で結合した文字列を返す(nullは除外)
    public static function getAcceptLocationName(?int $id1, ?int $id2, ?int $id3, ?int $id4, ?int $id5)
    {
        $locationIds = [$id1, $id2, $id3, $id4, $id5];
        $concatName = "";

        foreach ($locationIds as $id) {
            if (isset($id)) {
                $name = Location::find($id, ['name']);
                $concatName .= $name->name . ", ";
            }
        }

        if (!empty($concatName)) {
            $concatName = substr($concatName, 0, strlen($concatName) - 2);
        } else {
            $concatName = " ー ";
        }

        return $concatName;
    }

    // 累計投稿数を取得
    public static function ComulativePostTotal()
    {
        return Post::withTrashed()->count();
    }
}
