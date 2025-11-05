<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Location;
use App\Models\User;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // ユーザー情報画面
    public function index()
    {
        $user = User::find(21);
        $user['image'] =  pathinfo($user->image, PATHINFO_BASENAME);
        return view('users.index', ['user' => $user]);
    }

    // ユーザー登録画面
    public function create()
    {
        $locations = DB::table('locations')->whereNull('deleted_at')->orderBy('id', 'asc')->get();
        return view('users.create', ['locations' => $locations]);
    }

    // ユーザー登録処理
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        if (isset($validated['image'])) {
            $validated['image'] = $request->file('image')->store('users', 'public');
        }
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()->route('login')->with('success', 'ユーザー登録が完了しました');
    }

    // ユーザー情報画面
    public function show(string $id)
    {
        $user = User::find($id);
        $user['image'] =  isset($user->image) ? pathinfo($user->image, PATHINFO_BASENAME) : null;
        return view('users.show', ['user' => $user]);
    }

    // ユーザー編集画面
    public function edit(string $id)
    {
        // ログインユーザーidと異なる場合は編集画面表示しない
        abort_if($id != Auth::user()->id, 403);

        $user = User::find($id);
        $user['image'] =  pathinfo($user->image, PATHINFO_BASENAME);
        $locations = DB::table('locations')->whereNull('deleted_at')->orderBy('id', 'asc')->get();
        return view('users.edit', ['user' => $user, 'locations' => $locations]);
    }

    // ユーザー情報更新処理
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        $updateData = $request->validated();

        // 画像を変更する場合
        if ($request->has('image')) {
            if (isset($user->image)) {
                // 変更前の画像を削除
                Storage::disk('public')->delete($user->image);
            }
            // 変更後の画像をアップロード、保存パスを更新対象データにセット
            $updateData['image'] = $request->file('image')->store('users', 'public');
        }

        // パスワードを変更する場合
        if (isset($updateData)) {
            $updateData['password'] = Hash::make($updateData['password']);
        } else {
            $updateData->offsetUnset('password');
        }

        $user->update($updateData);

        return redirect()->route('users.show', ['id' => $id])->with('success', 'プロフィールを変更しました');
    }

    // ユーザー削除処理
    public function delete(string $id)
    {
        $user = User::find($id);

        if ($user) {
            // idが一致していない場合はエラー
            $auth_id = Auth::user()->id;
            abort_if($user->id != $auth_id, 403);

            // 画像削除
            if (isset($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $user->delete();
            return to_route('welcome')->with('message', 'ユーザー削除しました。');
        } else {
            return redirect()->with('message', '対象のユーザー情報が見つかりませんでした。');
        } 
    }
}
