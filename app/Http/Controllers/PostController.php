<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Like;
use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use DragonCode\Contracts\Http\Builder;
//use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Integer;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // マイ募集一覧画面
    public function index(string $id)
    {
        // ログインユーザーidと異なる場合はエラー
        abort_if($id != Auth::user()->id, 403);

        $posts = Post::where('user_id', $id)->orderBy('updated_at', 'desc')->simplePaginate(12);

        // 画像パスからフォルダパスを排除
        foreach ($posts as $post) {
            // 画像パスからフォルダパスを排除し、再代入
            $post['photo1'] =  ImageController::convert2fileName($post->photo1);
            $post['photo2'] =  ImageController::convert2fileName($post->photo2);
            $post['photo3'] =  ImageController::convert2fileName($post->photo3);
        }

        return view('posts.index', ['posts' => $posts, 'id' => $id]);
    }

    // 投稿登録画面
    public function create()
    {
        $user = Auth::user();
        $locations = DB::table('locations')->orderBy('id', 'asc')->get();
        $breeds = DB::table('breeds')->orderBy('order', 'asc')->get();
        $patterns = DB::table('patterns')->orderBy('order', 'asc')->get();

        return view('posts.create', ['user' => $user, 'locations' => $locations, 'breeds' => $breeds, 'patterns' => $patterns]);
    }

    // 投稿登録処理
    public function store(StorePostRequest $request)
    {
        // ログインユーザーidと異なる場合は編集画面表示しない
        abort_if($request->user_id != Auth::user()->id, 403);

        $validated = $request->validated();

        // 値が0（未選択）だった場合、nullに置換
	$validated['breed_id'] = $validated['breed_id'] ?: null;
        $validated['pattern_id'] = $validated['pattern_id'] ?: null;
        $validated['accept_location1'] = $validated['accept_location1'] ?: null;
        $validated['accept_location2'] = $validated['accept_location2'] ?: null;
        $validated['accept_location3'] = $validated['accept_location3'] ?: null;
        $validated['accept_location4'] = $validated['accept_location4'] ?: null;
        $validated['accept_location5'] = $validated['accept_location5'] ?: null;

        // 写真①　必須
        $validated['photo1'] = $request->file('photo1')->store('posts', 'public');
        $uploadedPhoto1Path = $request->file('photo1')->storeAs('temp', uniqid() . '_' . $request->file('photo1')->getClientOriginalName(), 'public');
        $request->session()->flash('photo1_path', $uploadedPhoto1Path);

        // 写真②　任意
        if (isset($validated['photo2'])) {
            $validated['photo2'] = $request->file('photo2')->store('posts', 'public');
            $uploadedPhoto2Path = $request->file('photo2')->storeAs('temp', uniqid() . '_' . $request->file('photo2')->getClientOriginalName(), 'public');
            $request->session()->flash('photo2_path', $uploadedPhoto2Path);
        }

        // 写真③　任意
        if (isset($validated['photo3'])) {
            $validated['photo3'] = $request->file('photo3')->store('posts', 'public');
            $uploadedPhoto3Path = $request->file('photo3')->storeAs('temp', uniqid() . '_' . $request->file('photo3')->getClientOriginalName(), 'public');
            $request->session()->flash('photo3_path', $uploadedPhoto3Path);
        }

        $post = Post::create($validated);
        $post->save();

        return redirect()->route('posts.show', ['id' => $post->id])->with('success', '里親募集を投稿しました');
    }

    // 投稿詳細画面
    public function show(string $id)
    {
        $post = Post::find($id);

        // ログインユーザーの所在地が応募可能地域でない場合はエラー(投稿者の場合は除外)
        if ($post->user_id != Auth::user()->id) {
            $accept_locations_array = [$post->location_id, $post->accept_location1, $post->accept_location2, $post->accept_location3, $post->accept_location4, $post->accept_location5];
            abort_if(!in_array(Auth::user()->location_id, $accept_locations_array), 403);
        }

        $status_name = Post::getStatusName($post->status);
        $accept_locations = Post::getAcceptLocationName($post->accept_location1, $post->accept_location2, $post->accept_location3, $post->accept_location4, $post->accept_location5);

        // 画像パスからフォルダパスを排除し、再代入
        $post['photo1'] =  ImageController::convert2fileName($post->photo1);
        $post['photo2'] =  ImageController::convert2fileName($post->photo2);
        $post['photo3'] =  ImageController::convert2fileName($post->photo3);

        return view('posts.show', ['post' => $post, 'status_name' => $status_name, 'accept_locations' => $accept_locations]);
    }

    // 投稿編集画面
    public function edit(string $id)
    {
        $post = Post::find($id);

        // ログインユーザーidと異なる場合はエラー
        abort_if($post->user_id != Auth::user()->id, 403);

        // 画像パスからフォルダパスを排除し、再代入
        $post['photo1'] =  ImageController::convert2fileName($post->photo1);
        $post['photo2'] =  ImageController::convert2fileName($post->photo2);
        $post['photo3'] =  ImageController::convert2fileName($post->photo3);

        $locations = DB::table('locations')->orderBy('id', 'asc')->get();
        $breeds = DB::table('breeds')->orderBy('order', 'asc')->get();
        $patterns = DB::table('patterns')->orderBy('order', 'asc')->get();

        return view('posts.edit', ['post' => $post, 'locations' => $locations, 'breeds' => $breeds, 'patterns' => $patterns]);
    }

    // 投稿更新処理
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::find($id);
        $updateData = $request->validated();

        // 値が0（未選択）だった場合、nullに置換
        $updateData['breed_id'] = $updateData['breed_id'] ?: null;
	$updateData['pattern_id'] = $updateData['pattern_id'] ?: null;
	$updateData['accept_location1'] = $updateData['accept_location1'] ?: null;
        $updateData['accept_location2'] = $updateData['accept_location2'] ?: null;
        $updateData['accept_location3'] = $updateData['accept_location3'] ?: null;
        $updateData['accept_location4'] = $updateData['accept_location4'] ?: null;
        $updateData['accept_location5'] = $updateData['accept_location5'] ?: null;

        // 画像を変更する場合
        $array_photos = ['photo1', 'photo2', 'photo3'];
        foreach ($array_photos as $photo) {
            if (array_key_exists($photo, $updateData)) {
                if (isset($post->$photo)) {
                    // 変更前の画像を削除
                    Storage::disk('public')->delete(asset('storage/' . $post->$photo));
                }
                // 変更後の画像をアップロード、保存パスを更新対象データにセット
                $updateData[$photo] = $request->file($photo)->store('posts', 'public');
            }
        }

        $post->update($updateData);

        return redirect()->route('posts.show', ['id' => $id])->with('success', '投稿を変更しました');
    }

    // 投稿削除処理
    public function delete(string $id)
    {
        $post = Post::find($id);

        if ($post) {
            // 認証ユーザーと投稿したユーザーのidが一致していない場合はエラー
            $auth_id = Auth::user()->id;
            abort_if($post->user_id != $auth_id, 403);

            // 画像を削除
            Storage::disk('public')->delete($post->photo1);
            if (isset($post->photo2)) {
                Storage::disk('public')->delete($post->photo2);
            }
            if (isset($post->photo3)) {
                Storage::disk('public')->delete($post->photo3);
            }

            $post->delete();

            return redirect()->route('posts.index', ['id' => $auth_id])->with('success', '投稿を削除しました。');
        } else {
            return redirect()->with('message', '対象の投稿が見つかりませんでした。');
        }
    }

    // マッチした投稿一覧画面
    public function matchingsIndex(Request $request, User $user)
    {
        $user_location = Auth::user()->location_id;
        $login_id = Auth::user()->id;

        // ログインユーザーidと異なる場合はエラー
        abort_if($user->id != $login_id, 403);

        // 投稿の所在地&応募可能地域とユーザーの所在地がマッチした投稿を取得
        $query = Post::where('user_id', '<>', $login_id)      //自分の投稿は除く
            ->where(function ($query) use ($user_location, $login_id) {
                $query
                    ->where('location_id', $user_location)
                    ->orWhere('accept_location1', $user_location)
                    ->orWhere('accept_location2', $user_location)
                    ->orWhere('accept_location3', $user_location)
                    ->orWhere('accept_location4', $user_location)
                    ->orWhere('accept_location5', $user_location);
            });

        // 絞り込み条件を反映
        // 所在地
        $location_id = $request->input('location_id');
        if (!is_null($location_id)) {
            $query->where('location_id', $location_id);
        }
        // 状況
        $status = $request->input('status');
        if (!is_null($status) && $status != 9) {
            $query->where('status', $status);
        }
        // 年齢（下限）
        $age_from = $request->input('age_from');
        if (!empty($age_from)) {
            $query->where('age_year', '>=', $age_from);
        }
        // 年齢（上限）
        $age_to = $request->input('age_to');
        if (!empty($age_to)) {
            $query->where('age_year', '<=', $age_to);
        }
        // 性別
        $gender = $request->input('gender');
        if (!is_null($gender)) {
            $query->where('gender', $gender);
        }
        // 種類
        $breed_id = $request->input('breed_id');
        if (!is_null($breed_id)) {
            $query->where('breed_id', $breed_id);
        }
        // 単身者応募可
        $accept_single = $request->input('accept_single');
        if (!is_null($accept_single)) {
            $query->where('accept_single', 1);
        }
        // 高齢者応募可
        $accept_senior = $request->input('accept_senior');
        if (!is_null($accept_senior)) {
            $query->where('accept_senior', 1);
        }

        $posts = $query->latest()->simplePaginate(12);

        // 検索条件を保持
        session()->flashInput($request->all());

        // プルダウン用データ
        $locations = DB::table('locations')->orderBy('id', 'asc')->get();
        $breeds = DB::table('breeds')->orderBy('order', 'asc')->get();
        $patterns = DB::table('patterns')->orderBy('order', 'asc')->get();

        return view('posts.matching', compact('posts', 'locations', 'breeds', 'patterns'));
    }
}
