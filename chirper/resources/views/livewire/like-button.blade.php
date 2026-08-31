{{--<div class="flex items-center gap-2">
@auth     
@if ($chirp->likedBy(auth()->user())) 
    <button wire:click="unlike" class="text-red-600">
        ❤️ 
    </button>
    <span class="text-sm text-gray-600">
        {{ $likesCount }}
    </span>
@else
    <button wire:click="like" class="text-gray-600">
        🤍 
    </button>
    <span class="text-sm text-gray-600">
        {{ $likesCount }}
    </span>
@endif
@endauth
@guest
    <button class="text-gray-600">
        🤍 
    </button>
    <span class="text-sm text-gray-600">
        {{ $likesCount }}
    </span>
@endguest
</div>--}}

@props(['chirp'])

<div class="flex items-center gap-2">
    @auth     
        @if ($isLiked) 
            <button wire:click="unlike" class="text-red-600">
                ❤️ 
            </button>
        @else
            <button wire:click="like" class="text-gray-600">
                🤍 
            </button>
        @endif
    @endauth

    @guest
        <button class="text-gray-600" disabled>
            🤍 
        </button>
    @endguest

    <!-- Выносим счетчик отдельно, чтобы не дублировать его 3 раза -->
    <span class="text-sm text-gray-600">
        {{ $likesCount }}
    </span>
</div>

