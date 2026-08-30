@props(['chirp'])

<div class="flex items-center gap-2">
@auth     
@if ($chirp->likedBy(auth()->user())) 
    <button wire:click="unlike" class="text-red-600">
        ❤️ 
    </button>
    <span class="text-sm text-gray-600">
        {{ $chirp->likes_count }}
    </span>
@else
    <button wire:click="like" class="text-gray-600">
        🤍 
    </button>
    <span class="text-sm text-gray-600">
        {{ $chirp->likes_count }}
    </span>
@endif
@endauth
@guest
    <button class="text-gray-600">
        🤍 
    </button>
    <span class="text-sm text-gray-600">
        {{ $chirp->likes_count }}
    </span>
@endguest
</div>
