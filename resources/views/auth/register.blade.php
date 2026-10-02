<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-bold text-slate-900">Buat Akun Baru</h1>
        <p class="mt-1 text-sm text-slate-500">Daftarkan diri untuk menggunakan SRPE</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 {{ $errors->get('name') ? 'border-red-400' : '' }}"
                placeholder="Nama lengkap kamu"
            />
            @if($errors->get('name'))
                <p class="mt-1 text-xs text-red-600">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
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
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 {{ $errors->get('password') ? 'border-red-400' : '' }}"
                placeholder="Min. 8 karakter"
            />
            @if($errors->get('password'))
                <p class="mt-1 text-xs text-red-600">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 {{ $errors->get('password_confirmation') ? 'border-red-400' : '' }}"
                placeholder="Ulangi password"
            />
            @if($errors->get('password_confirmation'))
                <p class="mt-1 text-xs text-red-600">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>

        <button
            type="submit"
            class="w-full flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
        >
            Daftar Sekarang
        </button>

        <p class="text-center text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:text-blue-700">Masuk</a>
        </p>
    </form>
</x-guest-layout>
