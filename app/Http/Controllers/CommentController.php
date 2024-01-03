<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'track_id' => 'required',
        ]);

        // Створення нового коментаря в базі даних
        $comment = Comment::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(), // ID залогованого користувача
            'track_id' => $request->input('track_id'),
        ]);

        // Повернення до попередньої сторінки або іншої, наприклад, до сторінки трека
        return redirect()->back()->with('success', 'Коментар додано успішно');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

             if (Auth::id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Ви не маєте дозволу на видалення цього коментаря.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Коментар успішно видалено.');
    }

    // public function userCommentedTracks()
    // {
    //     $user = auth()->user();

    //     if ($user) {
    //         $userComments = $user->comments; // Отримайте всі коментарі користувача

    //         if ($userComments) {
    //             $trackIds = $userComments->pluck('track_id')->unique(); // Отримайте унікальні ідентифікатори треків, які були коментовані

    //             // Отримайте інформацію про треки з бази даних або API Deezer
    //             $tracks = []; // Замініть це на код, який отримує дані про треки за їхніми ідентифікаторами

    //             return view('user_commented_tracks', compact('tracks'));
    //         }
    //     }

    //     return view('user_commented_tracks', ['tracks' => []]); // Повернення порожнього масиву, якщо немає коментарів
    // }

}
