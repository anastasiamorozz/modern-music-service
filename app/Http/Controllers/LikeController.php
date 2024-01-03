<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;


class LikeController extends Controller
{
    public function addLike($trackId)
    {

        try {
            if (auth()->check()) {
                // Користувач аутентифікований
                $user = auth()->user();
            } else {
                // Користувач не аутентифікований
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $like = Like::where('user_id', $user->id)->where('track_id', $trackId)->first();

            if (!$like) {
                Like::create(['user_id' => $user->id, 'track_id' => $trackId]);
            }

            return redirect()->back()->with('success', 'Коментар додано успішно');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function removeLike($trackId)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $like = Like::where('user_id', $user->id)->where('track_id', $trackId)->first();

        if ($like) {
            $like->delete();
        }

        return redirect()->back()->with('success', 'Коментар додано успішно');
    }



}
