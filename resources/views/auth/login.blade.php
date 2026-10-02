<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h1 class="text-xl font-bold text-slate-900">Masuk ke Akun</h1>
        <p class="mt-1 text-sm text-slate-500">Gunakan akun yang telah terdaftar</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 {{ $errors->get('email') ? 'border-red-400' : '' }}"
                placeholder="nama@email.com"
            />
            @if($errors->get('email'))
                <p class="mt-1 text-xs text-red-600">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-600 hover:text-blue-700" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 {{ $errors->get('password') ? 'border-red-400' : '' }}"
                placeholder="Password kamu"
            />
            @if($errors->get('password'))
                <p class="mt-1 text-xs text-red-600">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
            >
            <label for="remember_me" class="text-sm text-slate-600">Ingat saya</label>
        </div>

        <button
            type="submit"
            class="w-full flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
        >
            Masuk
        </button>

        @if (Route::has('register'))
            <p class="text-center text-sm text-slate-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:text-blue-700">Daftar</a>
            </p>
        @endif
    </form>
</x-guest-layout>
