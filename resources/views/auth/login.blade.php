<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SicilyLines - Se connecter</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="min-h-screen font-sans text-gray-800 bg-gradient-to-br from-gray-100 to-gray-200">

    <!-- HEADER -->
    <header class="w-full h-20 bg-gradient-to-r from-[#0d4e80] to-[#0b3f66] shadow-md flex items-center px-10">
    <img
        src="{{ asset('images/logo-sicilylines.png') }}"
        alt="Sicily Lines"
        class="h-12 object-contain"
    >
</header>


    <!-- CONTENT -->
    <main class="flex items-center justify-center min-h-[calc(100vh-5rem)]">
        <div class="bg-white w-full max-w-md rounded-lg shadow-xl p-8">

            <h2 class="text-center text-xl font-semibold text-[#0d4e80] mb-8">
                Espace Professionnel
            </h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- IDENTIFIANT -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Identifiant
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        autofocus
                        class="w-full rounded border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#0d4e80]"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- PASSWORD -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Mot de passe
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="w-full rounded border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#0d4e80]"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- BUTTON -->
                <div class="flex flex-col items-center space-y-4 pt-4">
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-[#f0b429] to-[#e59a17]
                               hover:from-[#e0a11e] hover:to-[#d88d10]
                               text-black font-semibold py-2 rounded shadow transition">
                        Se connecter
                    </button>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-gray-600 hover:underline">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </main>

</body>
</html>
