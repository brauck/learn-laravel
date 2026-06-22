<x-layout>
    <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

    @if (session('status'))
        <div class="text-green-600 mb-4">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label class="block">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input input-bordered w-full">
            @error('name') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input input-bordered w-full">
            @error('email') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Avatar</label>
            <input type="file" name="avatar" class="file-input file-input-bordered w-full">
            @error('avatar') <p class="text-red-600">{{ $message }}</p> @enderror

            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-20 h-20 rounded-full mt-2">
            @endif
        </div>

        <!--div>
            <label>Password</label>
            <input type="password" name="password" class="input input-bordered w-full">
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="input input-bordered w-full"-->
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</x-layout>
