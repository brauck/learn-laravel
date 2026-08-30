<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chirp;

class LikeButton extends Component
{
    public Chirp $chirp;

    public function like()
    {
        \Log::info('like clicked');
        $this->chirp->likes()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $this->chirp->refresh();
    }

    public function unlike()
    {
        $this->chirp->likes()->where('user_id', auth()->id())->delete();
        $this->chirp->refresh();
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
