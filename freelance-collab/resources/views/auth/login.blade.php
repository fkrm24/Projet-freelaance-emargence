<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Emargence</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: url('{{ asset('images/fondecran.png') }}') no-repeat center center fixed; background-size: cover;" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#152C54] to-[#e0e7ef]">
    <div class="flex flex-col items-center w-full">

        <div class="bg-white rounded-2xl shadow-2xl border border-[#152C54] flex flex-col md:flex-row w-full md:w-[800px] max-w-4xl md:min-h-[400px] md:h-[500px] overflow-hidden">
            <!-- Bloc gauche : message de bienvenue -->
            <div class="hidden md:flex flex-col justify-center items-center bg-gradient-to-br from-[#2748E9] to-[#152C54] text-white p-8 md:w-1/2">
                <div class="mb-6 text-5xl">👋</div>
                <h2 class="text-2xl font-bold mb-2">Bienvenue !</h2>
                <p class="text-base mb-4 text-center">Connecte-toi pour accéder à ta plateforme  et collaborer facilement avec Emargence.</p>
            </div>
            <!-- Bloc droit : formulaire --> 
            <div class="flex flex-col justify-center items-center p-8 w-full md:w-1/2">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}" class="w-full max-w-xs">
                    @csrf
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" :class="'block mt-1 w-full bg-[#E0E7FF] border-none focus:ring-2 focus:ring-[#2748E9] text-[#152C54] placeholder:text-[#2748E9]'" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" :class="'block mt-1 w-full bg-[#E0E7FF] border-none focus:ring-2 focus:ring-[#2748E9] text-[#152C54] placeholder:text-[#2748E9]'" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <div class="flex flex-col gap-2 mt-4">
    <div class="flex w-full">
        @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif
    </div>
    <div class="w-full flex justify-center mt-1 mb-2">
        <span class="text-sm text-gray-500">You don't have an account? 
            <a href="{{ route('register') }}" class="font-semibold text-[#2748E9] hover:text-[#018FFD] underline underline-offset-2 transition">Register first</a>.
        </span>
    </div>
    <div class="flex w-full justify-end">
        <x-primary-button class="bg-[#2748E9] hover:bg-[#018FFD] text-white font-semibold px-6 py-3 rounded-lg">
            {{ __('Log in') }}
        </x-primary-button>
    </div>
</div>
                </form> 
            </div>
        </div>
    </div>
</body>
</html>

