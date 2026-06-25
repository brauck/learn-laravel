<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Chirp $chirp)
    {
        $chirp->likes()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function destroy(Chirp $chirp)
    {
        $chirp->likes()
            ->where('user_id', auth()->id())
            ->delete();

        return back();
    }
}

