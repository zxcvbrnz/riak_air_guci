<div class="min-h-screen flex items-center justify-center bg-riak-cream/30 px-4">
    <div
        class="bg-white p-8 md:p-10 rounded-sm border border-riak-army/5 shadow-[0_4px_30px_rgba(0,0,0,0.02)] w-full max-w-md">

        <!-- Header / Judul -->
        <div class="text-center mb-8">
            <h2 class="font-serif text-xl md:text-2xl tracking-[0.2em] text-riak-army uppercase">
                @id
                    Verifikasi Kode
                @endid @en Verify Code @enden
            </h2>
            <div class="w-12 h-[1px] bg-riak-honey mx-auto mt-3"></div>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="submit" class="space-y-6">
            <div>
                <label for="unique_code"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-2">
                    Unique Code
                </label>

                <input wire:model="unique_code" id="unique_code" type="text" placeholder="e.g. RIAK-XXXX-XXXX"
                    class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-3 px-4 text-riak-army font-mono placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">

                @error('unique_code')
                    <span class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1.5">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full text-center py-3 text-xs uppercase tracking-[0.2em] font-bold bg-riak-army text-riak-cream border border-riak-army rounded-sm hover:bg-transparent hover:text-riak-army transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-riak-army">
                    @id
                        Kirim
                    @endid @en Submit @enden
                </button>
            </div>
        </form>
    </div>
</div>
