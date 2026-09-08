<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chirp;
use App\Events\ChirpLiked;
use App\Events\ChirpUnliked;
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

    public function unlike(Chirp $chirp)
    {
        if ($chirp->likes_count > 0) {
            $chirp->decrement('likes_count');
        }
        $chirp->likes()->where('user_id', auth()->id())->delete();

        // Вещаем событие снятия лайка
        broadcast(new ChirpUnliked($chirp->id))->toOthers();

        return response()->json(['success' => true]);
    }
}
