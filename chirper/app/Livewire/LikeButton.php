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
use App\Events\ChirpUnliked;
use Livewire\Attributes\On; // Важно для прослушивания

class LikeButton extends Component
{
    public Chirp $chirp;
    public int $likesCount;
    public bool $isLiked = false; // Добавляем статус лайка

    public function mount(Chirp $chirp)
    {
        $this->chirp = $chirp;
        $this->likesCount = $chirp->likes_count; // Предположим, у вас есть такое поле/связь

        // Проверяем статус один раз при загрузке страницы
        $this->isLiked = auth()->check() ? $chirp->likedBy(auth()->user()) : false;
    }

    public function like()
    {
        // 1. Здесь ваша логика сохранения лайка в базу данных, например:
        // $this->chirp->increment('likes_count');
        \Log::info('like clicked');
        \Log::info($this->likesCount);
        $this->chirp->increment('likes_count');        
        $this->chirp->likes()->firstOrCreate([
            'user_id' => auth()->id(),
        ]); 
        $this->isLiked = true; // Мгновенно меняем статус для себя

        // 2. Отправляем событие в WebSocket для ВСЕХ остальных пользователей
        broadcast(new ChirpLiked($this->chirp->id));
    }

    public function unlike()
    {
        \Log::info('unlike clicked');
        $this->chirp->decrement('likes_count');
        $this->chirp->likes()->where('user_id', auth()->id())->delete();
        $this->isLiked = false; // Мгновенно меняем статус для себя

        // Отправляем событие снятия лайка в Reverb
        broadcast(new ChirpUnliked($this->chirp->id));
    }

    // Магия Livewire: префикс `echo:` говорит слушать WebSocket канал 'chirps-activity'
    // Когда событие 'ChirpLiked' прилетает, вызывается этот метод
    #[On('echo:chirps-activity,ChirpLiked')]
    /////////// не работает /////////////////
    // public function handleChirpLiked($event)
    // {
    //     // Если лайкнули именно ТОТ чирп, который отображает эта кнопка — обновляем счетчик
    //     if ($event['chirpId'] === $this->chirp->id) {
    //         $this->likesCount++;
    //     }
    // }

    /////////// работает /////////////////
    public function handleChirpLiked($event)
    {
        // Логируем для точной проверки в storage/logs/laravel.log, если что-то пойдет не так
        \Log::info($event); 

        // 1. Проверяем ключ (в Livewire v4 он лежит на первом уровне массива)
        if (isset($event['chirpId'])) {
            
            // 2. Приводим оба ID к числу (int), чтобы избежать конфликта типов string/int
            if ((int)$event['chirpId'] === (int)$this->chirp->id) {
                $this->likesCount++;
            }
            
        }
    }

    ///////// работает (упрощённый) /////////////////
    // public function handleChirpLiked($chirpId) // Livewire сам вытащит 'chirpId' из data
    // {
    //     if ((int)$chirpId === (int)$this->chirp->id) {
    //         $this->likesCount++;
    //     }
    // }

    // public function handleChirpLiked($chirpId) // Livewire сам вытащит 'chirpId' из data
    // {
    //     if (isset($event['chirpId']) && (int)$event['chirpId'] === (int)$this->chirp->id) {
    //         $this->likesCount++;
    //     }
    // }

    #[On('echo:chirps-activity,ChirpUnliked')]
    public function handleChirpUnliked($event)
    {
        if (isset($event['chirpId']) && (int)$event['chirpId'] === (int)$this->chirp->id) {
            $this->likesCount--;
        }
    }

    

    public function render()
    {
        return view('livewire.like-button');
    }
}
