<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    // --- PROPERTI PROFILE ---
    public string $asal_provinsi = '';
    public string $asal_kota = '';
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $no_wa = '';
    public string $gender = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;

        // --- ISI DATA PROPERTI DARI DATABASE ---
        $this->asal_provinsi = $user->asal_provinsi ?? '';
        $this->asal_kota = $user->asal_kota ?? '';
        $this->tempat_lahir = $user->tempat_lahir ?? '';
        $this->tanggal_lahir = $user->tanggal_lahir ?? '';
        $this->no_wa = $user->no_wa ?? '';
        $this->gender = $user->gender ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        // --- VALIDASI ADAPTIF BERDASARKAN ROLE ---
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ];

        // Jika user BUKAN admin, tambahkan aturan validasi untuk input profil baru
        if ($user->role !== 'admin') {
            $rules = array_merge($rules, [
                'asal_provinsi' => ['required', 'string', 'max:255'],
                'asal_kota' => ['required', 'string', 'max:255'],
                'tempat_lahir' => ['required', 'string', 'max:255'],
                'tanggal_lahir' => ['required', 'date'],
                'no_wa' => ['required', 'string', 'max:20'],
                'gender' => ['required', 'in:L,P'],
            ]);
        }

        $validated = $this->validate($rules);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi profil akun dan alamat email Anda.
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        {{-- Nama --}}
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required
                autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        Alamat email Anda belum terverifikasi.

                        <button wire:click.prevent="sendVerification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Tautan verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- --- KONDISI KECUALI ADMIN --- --}}
        @if (auth()->user()->role !== 'admin')
            {{-- No WhatsApp --}}
            <div>
                <x-input-label for="no_wa" value="No. WhatsApp" />
                <x-text-input wire:model="no_wa" id="no_wa" name="no_wa" type="text" class="mt-1 block w-full"
                    required placeholder="Contoh: 08123456789" />
                <x-input-error class="mt-2" :messages="$errors->get('no_wa')" />
            </div>

            {{-- Gender --}}
            <div>
                <x-input-label for="gender" value="Jenis Kelamin" />
                <select wire:model="gender" id="gender" name="gender"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>

            {{-- Grid: Tempat & Tanggal Lahir --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                    <x-text-input wire:model="tempat_lahir" id="tempat_lahir" name="tempat_lahir" type="text"
                        class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
                </div>

                <div>
                    <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                    <x-text-input wire:model="tanggal_lahir" id="tanggal_lahir" name="tanggal_lahir" type="date"
                        class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                </div>
            </div>

            {{-- Grid: Provinsi & Kota --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="asal_provinsi" value="Provinsi Asal" />
                    <x-text-input wire:model="asal_provinsi" id="asal_provinsi" name="asal_provinsi" type="text"
                        class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('asal_provinsi')" />
                </div>

                <div>
                    <x-input-label for="asal_kota" value="Kota/Kabupaten Asal" />
                    <x-text-input wire:model="asal_kota" id="asal_kota" name="asal_kota" type="text"
                        class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('asal_kota')" />
                </div>
            </div>
        @endif

        {{-- Tombol Simpan --}}
        <div class="flex items-center gap-4">
            <x-primary-button>Simpan Perubahan</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                Berhasil disimpan.
            </x-action-message>
        </div>
    </form>
</section>
