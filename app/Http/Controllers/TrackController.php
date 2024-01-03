<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Comment;
use App\Models\Track;
use App\Models\Like;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    public function index()
    {
        $playlistId = '11165596124'; // ID плейлиста, який ви хочете відобразити
        $client = new Client();

        // Отримати інформацію про плейлист
        $playlistResponse = $client->get("https://api.deezer.com/playlist/$playlistId");
        $playlistData = json_decode($playlistResponse->getBody()->getContents(), true);

        // Отримати треки з плейлиста
        $tracksResponse = $client->get("https://api.deezer.com/playlist/$playlistId/tracks");
        $tracksData = json_decode($tracksResponse->getBody()->getContents(), true);

        $tracks = $tracksData['data'];

        return view('home', compact('tracks', 'playlistData'));
    }





    public function search(Request $request)
    {
        $query = $request->input('query');

        // Використовуйте Deezer API для пошуку треків
        $apiKey = '0a3c7810b04e22d5d33ff40d272e0ba0';
        $response = Http::get('https://api.deezer.com/search', [
            'q' => $query,
            'limit' => 10, // При потребі змініть ліміт
            'output' => 'json',
            'apikey' => $apiKey,
        ]);

        $tracks = $response->json()['data'];

        return view('home', compact('tracks', 'query'));
    }

    public function showTrack($id)
    {
        $apiKey = '0a3c7810b04e22d5d33ff40d272e0ba0';
        $response = Http::get("https://api.deezer.com/track/{$id}", [
            'apikey' => $apiKey,
        ]);

        $trackDetails = $response->json();

        $likes = Like::where('track_id', $trackDetails['id'])->count();

        $comments = Comment::where('track_id', $trackDetails['id'])->get();

        $user = auth()->user();
        $userLikedTrack = $user ? $user->likes->where('track_id', $trackDetails['id'])->isNotEmpty() : false;

        return view('track_detail', compact('trackDetails', 'likes', 'userLikedTrack', 'comments'));
    }

    public function likeTrack($id)
    {
        $track = Track::findOrFail($id);
        $track->like();

        return redirect()->route('track.detail', ['id' => $id])->with('success', 'Трек вподобано');
    }

    public function mostLikedTracks()
    {
        // Отримання кількості лайків для кожного трека
        $tracks = DB::table('likes')
            ->select('track_id', DB::raw('count(*) as likes_count'))
            ->groupBy('track_id')
            ->orderByDesc('likes_count')
            ->get();

        // Отримання деталей треків з API або бази даних
        $trackDetails = [];

        foreach ($tracks as $track) {
            $apiKey = '0a3c7810b04e22d5d33ff40d272e0ba0';
            $response = Http::get("https://api.deezer.com/track/{$track->track_id}", [
                'apikey' => $apiKey,
            ]);

            $trackDetails[] = $response->json();
        }

        return view('most_liked_tracks', compact('trackDetails'));
    }
}
