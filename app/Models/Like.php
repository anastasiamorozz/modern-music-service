<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'track_id'];

    // Відносини

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function countLikesForTrack($trackId)
    {
        return self::where('track_id', $trackId)->count();
    }
}
