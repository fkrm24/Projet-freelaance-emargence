@section('auth-left')
    <div class="hidden md:flex flex-col justify-center items-center bg-gradient-to-br from-[#2748E9] to-[#152C54] text-white p-10 min-w-[260px] max-w-[340px]">
        <div class="mb-6 text-4xl">🚀</div>
        <h2 class="text-2xl font-bold mb-2">Créer un compte Emargence</h2>
        <p class="text-base mb-4 text-center">Rejoins la plateforme et découvre une nouvelle façon de collaborer en freelance.</p>

    </div>
@endsection
<body style="background: url('{{ asset('images/fondecran.png') }}') no-repeat center center fixed; background-size: cover;">
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" :class="'block mt-1 w-full bg-[#E0E7FF] border-none focus:ring-2 focus:ring-[#2748E9] text-[#152C54] placeholder:text-[#2748E9]'" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" :class="'block mt-1 w-full bg-[#E0E7FF] border-none focus:ring-2 focus:ring-[#2748E9] text-[#152C54] placeholder:text-[#2748E9]'" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" :class="'block mt-1 w-full bg-[#E0E7FF] border-none focus:ring-2 focus:ring-[#2748E9] text-[#152C54] placeholder:text-[#2748E9]'" type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" :class="'block mt-1 w-full bg-[#E0E7FF] border-none focus:ring-2 focus:ring-[#2748E9] text-[#152C54] placeholder:text-[#2748E9]'" type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 bg-[#FF7E00] hover:bg-[#018FFD] text-white font-semibold px-6 py-3 rounded-lg">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
