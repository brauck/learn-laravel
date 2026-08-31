<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chirp;
use App\Events\ChirpLiked;
use Illuminate\Http\Request;

class ChirpLikeController extends Controller
{
    public function like(Chirp $chirp)
    {
        $chirp->increment('likes_count');
        $chirp->likes()->firstOrCreate(['user_id' => auth()->id()]);

        // Laravel сам подхватит X-Socket-ID из заголовков React-запроса
        broadcast(new ChirpLiked($chirp->id))->toOthers();

        return response()->json(['success' => true]);
    }
}
