<?php

namespace App\Livewire;

/*use Livewire\Component;
use App\Models\Chirp;

class LikeButton extends Component
{
    public Chirp $chirp;

    public function like()
    {
        \Log::info('like clicked');
        $this->chirp->increment('likes_count');        
        $this->chirp->likes()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $this->chirp->refresh();
    }

    public function unlike()
    {
        \Log::info('unlike clicked');
        $this->chirp->decrement('likes_count');
        $this->chirp->likes()->where('user_id', auth()->id())->delete();
        $this->chirp->refresh();
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}*/

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chirp;
use App\Events\ChirpLiked;
use Livewire\Attributes\On; // Важно для прослушивания

class LikeButton extends Component
{
    public Chirp $chirp;
    public $likesCount;

    public function mount(Chirp $chirp)
    {
        $this->chirp = $chirp;
        $this->likesCount = $chirp->likes_count; // Предположим, у вас есть такое поле/связь
    }

    public function like()
    {
        // 1. Здесь ваша логика сохранения лайка в базу данных, например:
        // $this->chirp->increment('likes_count');
        $this->likesCount++; 

        // 2. Отправляем событие в WebSocket для ВСЕХ остальных пользователей
        broadcast(new ChirpLiked($this->chirp->id))->toOthers();
    }

    // Магия Livewire: префикс `echo:` говорит слушать WebSocket канал 'chirps-activity'
    // Когда событие 'ChirpLiked' прилетает, вызывается этот метод
    #[On('echo:chirps-activity,ChirpLiked')]
    public function handleChirpLiked($event)
    {
        // Если лайкнули именно ТОТ чирп, который отображает эта кнопка — обновляем счетчик
        if ($event['chirpId'] === $this->chirp->id) {
            $this->likesCount++;
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
