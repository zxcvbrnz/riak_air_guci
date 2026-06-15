<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // jika tidak memiliki member dan bukan admin, akan di arahkan ke halaman input uniuque code, jika sudah memiliki member, akan di arahkan ke dashboard
        if (!auth()->user()->member && auth()->user()->role !== 'admin') {
            $this->redirect(route('input-unique-code', absolute: false), navigate: true);
        } else {
            // jika admin maka akan di arahkan ke dashboard admin, jika user biasa maka akan di arahkan ke dashboard user
            if (auth()->user()->role === 'admin') {
                $this->redirect(route('dashboard.admin', absolute: false), navigate: true);
            } else {
                $this->redirect(route('dashboard.user', absolute: false), navigate: true);
            }
        }
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-riak-cream/30 px-4 py-12">
    <div class="bg-white p-8 md:p-10 rounded-sm border border-riak-army/5 shadow-[0_4px_30px_rgba(0,0,0,0.02)] w-full max-w-md">
        
        <div class="text-center mb-8">
            <h2 class="font-serif text-xl md:text-2xl tracking-[0.2em] text-riak-army uppercase">
                @id Masuk Akun @endid @en Log In @enden
            </h2>
            <div class="w-12 h-[1px] bg-riak-honey mx-auto mt-3"></div>
        </div>

        @if (session('status'))
            <div class="mb-5 p-3 bg-green-50 border border-green-100 rounded-sm text-green-600 text-xs tracking-wide">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="login" class="space-y-5">
            
            <div>
                <label for="email" class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-1.5">
                    Email
                </label>
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                    class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">
                
                @error('form.email')
                    <span class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="password" class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70">
                        Password
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/50 hover:text-riak-honey transition-colors focus:outline-none"
                            href="{{ route('password.request') }}" wire:navigate>
                            @id Lupa? @endid @en Forgot? @enden
                        </a>
                    @endif
                </div>
                
                <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-2.5 px-4 text-riak-army text-sm placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">
                
                @error('form.password')
                    <span class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="flex items-center">
                <label for="remember" class="inline-flex items-center cursor-pointer select-none">
                    <input wire:model="form.remember" id="remember" type="checkbox" name="remember"
                        class="rounded-sm border-riak-army/30 text-riak-honey shadow-sm focus:ring-0 focus:ring-offset-0 w-4 h-4 checked:bg-riak-honey checked:border-riak-honey">
                    <span class="ms-2.5 text-[10px] uppercase tracking-[0.15em] font-bold text-riak-army/60">
                        @id Ingat Saya @endid @en Remember Me @enden
                    </span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-riak-army/5">
                <a class="text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/60 hover:text-riak-honey transition-colors rounded focus:outline-none"
                    href="{{ route('register') }}" wire:navigate>
                    @id Belum punya akun? @endid @en Create Account @enden
                </a>

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full sm:w-auto px-8 py-3 text-[10px] uppercase tracking-[0.2em] font-bold bg-riak-army text-riak-cream border border-riak-army rounded-sm hover:bg-transparent hover:text-riak-army transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-riak-army disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove>@id Masuk @endid @en Log In @enden</span>
                    <span wire:loading>@id Memproses... @endid @en Processing... @enden</span>
                </button>
            </div>
        </form>
    </div>
</div>