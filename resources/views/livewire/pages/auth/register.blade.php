<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // --- PROPERTI BARU ---
    public string $asal_provinsi = '';
    public string $asal_kota = '';
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $no_wa = '';
    public string $gender = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // --- PROTEKSI SPAM SERVER SIDE (RATE LIMITER) ---
        $throttleKey = 'register-attempt:' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => ["Terlalu banyak mencoba. Silakan coba lagi dalam $seconds detik."],
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        // --- VALIDASI DIPERBARUI ---
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'asal_provinsi' => ['required', 'string', 'max:255'],
            'asal_kota' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'no_wa' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'in:L,P'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        RateLimiter::clear($throttleKey);

        if (!$user->member && $user->role !== 'admin') {
            $this->redirect(route('input-unique-code', absolute: false), navigate: true);
        } else {
            $this->redirect(route('dashboard.user', absolute: false), navigate: true);
        }
    }
}; ?>

<div
    class="bg-white p-8 md:p-10 rounded-sm border border-riak-army/5 shadow-[0_4px_30px_rgba(0,0,0,0.02)] w-full max-w-md">

    <div class="text-center mb-8">
        <h2 class="font-serif text-xl md:text-2xl tracking-[0.2em] text-riak-army uppercase">
            @id
            Daftar Akun
            @endid @en Register @enden
        </h2>
        <div class="w-12 h-[1px] bg-riak-honey mx-auto mt-3"></div>
    </div>

    <form wire:submit="register" class="space-y-5">

        {{-- Nama Lengkap --}}
        <div>
            <label for="name" class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                @id Nama Lengkap @endid @en Full Name @enden
            </label>
            <input wire:model="name" id="name" type="text" required autofocus autocomplete="name"
                class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">

            @error('name')
                <span
                    class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email"
                class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                Email
            </label>
            <input wire:model="email" id="email" type="email" required autocomplete="username"
                class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">

            @error('email')
                <span
                    class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- No WhatsApp --}}
        <div>
            <label for="no_wa"
                class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                @id No. WhatsApp @endid @en WhatsApp Number @enden
            </label>
            <input wire:model="no_wa" id="no_wa" type="text" required placeholder="Contoh: 08123456789"
                class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">

            @error('no_wa')
                <span
                    class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Gender --}}
        <div>
            <label for="gender"
                class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                @id Jenis Kelamin @endid @en Gender @enden
            </label>
            <select wire:model="gender" id="gender" required
                class="w-full bg-white border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">
                <option value="">-- @id Pilih @endid @en Select @enden --</option>
                <option value="L">@id Laki-laki @endid @en Male @enden</option>
                <option value="P">@id Perempuan @endid @en Female @enden</option>
            </select>

            @error('gender')
                <span
                    class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Grid: Tempat & Tanggal Lahir --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="tempat_lahir"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                    @id Tempat Lahir @endid @en Place of Birth @enden
                </label>
                <input wire:model="tempat_lahir" id="tempat_lahir" type="text" required
                    class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">
                @error('tempat_lahir')
                    <span
                        class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="tanggal_lahir"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                    @id Tanggal Lahir @endid @en Date of Birth @enden
                </label>
                <input wire:model="tanggal_lahir" id="tanggal_lahir" type="date" required
                    class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">
                @error('tanggal_lahir')
                    <span
                        class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Grid: Provinsi & Kota --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="asal_provinsi"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                    @id Provinsi @endid @en Province @enden
                </label>
                <input wire:model="asal_provinsi" id="asal_provinsi" type="text" required
                    class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">
                @error('asal_provinsi')
                    <span
                        class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="asal_kota"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                    @id Kota/Kabupaten @endid @en City @enden
                </label>
                <input wire:model="asal_kota" id="asal_kota" type="text" required
                    class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">
                @error('asal_kota')
                    <span
                        class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Password --}}
        <div>
            <label for="password"
                class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                Password
            </label>
            <input wire:model="password" id="password" type="password" required autocomplete="new-password"
                class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">

            @error('password')
                <span
                    class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation"
                class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                @id Konfirmasi Password @endid @en Confirm Password @enden
            </label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                autocomplete="new-password"
                class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">

            @error('password_confirmation')
                <span
                    class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tombol Submit & Navigasi --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-riak-army/5">
            <a class="text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/60 hover:text-riak-honey transition-colors rounded focus:outline-none"
                href="{{ route('login') }}" wire:navigate>
                @id Sudah punya akun? @endid @en Already registered? @enden
            </a>

            <button type="submit" wire:loading.attr="disabled"
                class="w-full sm:w-auto px-6 py-3 text-[10px] uppercase tracking-[0.2em] font-bold bg-riak-army text-riak-cream border border-riak-army rounded-sm hover:bg-transparent hover:text-riak-army transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-riak-army disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove>
                    @id Daftar @endid @en Register @enden
                </span>
                <span wire:loading>
                    @id Memproses... @enden @en Processing... @enden
                </span>
            </button>
        </div>
    </form>
</div>
