<div class="min-h-screen flex items-center justify-center bg-riak-cream/30 px-4">
    <div
        class="bg-white p-8 md:p-10 rounded-sm border border-riak-army/5 shadow-[0_4px_30px_rgba(0,0,0,0.02)] w-full max-w-md">

        <div class="text-center mb-8">
            <h2 class="font-serif text-xl md:text-2xl tracking-[0.2em] text-riak-army uppercase">
                @id
                    Verifikasi Kode
                @endid @en Verify Code @enden
            </h2>
            <div class="w-12 h-[1px] bg-riak-honey mx-auto mt-3"></div>
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">
            <div>
                <label for="unique_code"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-riak-army/70 mb-2">
                    Unique Code
                </label>

                <input wire:model="code" id="unique_code" type="text" placeholder="e.g. RIAK-XXXX-XXXX"
                    class="w-full bg-riak-cream/10 border border-riak-army/20 rounded-sm py-3 px-4 text-riak-army font-mono placeholder-riak-army/30 transition-all duration-300 focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey">

                @error('code')
                    <span class="flex items-center text-red-500 text-xs font-medium tracking-wide mt-1.5">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                    class="w-full text-center py-3 text-xs uppercase tracking-[0.2em] font-bold bg-riak-army text-riak-cream border border-riak-army rounded-sm hover:bg-transparent hover:text-riak-army transition-all duration-300 focus:outline-none focus:ring-1 focus:ring-riak-army flex justify-center items-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:bg-riak-army disabled:hover:text-riak-cream">

                    <span wire:loading.remove wire:target="submit">
                        @id
                            Kirim
                        @endid @en Submit @enden
                    </span>

                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                        <svg class="animate-spin h-3.5 w-3.5 text-current" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        @id
                            Memproses...
                        @endid @en Processing... @enden
                    </span>

                </button>
            </div>
        </form>
    </div>
</div>
