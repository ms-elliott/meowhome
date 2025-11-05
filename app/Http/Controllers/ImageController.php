<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    // 画像パスからフォルダパスを排除
    public static function convert2fileName(?string $path) {
        if (isset($path)) {
            return pathinfo($path, PATHINFO_BASENAME);
        } else {
            return null;
        }
    }
}
