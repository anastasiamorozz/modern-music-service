<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
// Track.php

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

}
