<?php

use App\Models\CreativeKit;
use App\Models\UniqueCode;
use Livewire\Volt\Component;

new class extends Component {
    public $kitId;
    public $kit;
    public $code;
    public $kitVariant = ''; // Menampung variant terpilih dari dropdown

    protected $rules = [
        'code' => 'required|string|unique:unique_codes,code',
        'kitVariant' => 'required|string', // Validasi varian wajib dipilih
    ];

    public function mount($creativeKitId = null)
    {
        $kitId = $creativeKitId;
        $this->kitId = $kitId;
        // Memuat CreativeKit beserta daftar varian yang dimilikinya
        $this->kit = CreativeKit::with('variants')->findOrFail($kitId);
    }

    public function store()
    {
        $this->validate();

        UniqueCode::create([
            'type' => 'kit', // Mengisi type sebagai kit sesuai skema migration baru
            'creative_kit_id' => $this->kitId,
            'product_id' => null, // Dipastikan null karena konteksnya adalah kit
            'kit_variant' => $this->kitVariant, // Menyimpan nama varian terpilih
            'code' => strtoupper($this->code),
            'is_used' => false,
        ]);

        $this->reset(['code', 'kitVariant']);
        session()->flash('message', 'Kode unik untuk kit berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $code = UniqueCode::where('creative_kit_id', $this->kitId)->findOrFail($id);

        if ($code->is_used) {
            session()->flash('error', 'Kode yang sudah digunakan tidak dapat dihapus.');
            return;
        }

        $code->delete();
        session()->flash('message', 'Kode unik berhasil dihapus.');
    }

    public function with()
    {
        return [
            // Membaca data kode unik milik kit ini beserta relasi member penggunanya
            'uniqueCodes' => UniqueCode::where('creative_kit_id', $this->kitId)
                ->with(['member.user'])
                ->latest()
                ->get(),
        ];
    }
}; ?>

<div class="max-w-7xl mx-auto pb-20 px-6">
    <x-slot name="header">Kelola Kode Unik Kit</x-slot>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
        <div>
            <h2 class="font-serif italic text-4xl text-riak-army">Unique Codes (Kit)</h2>
            <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-riak-honey mt-2">
                Creative Kit: <span class="text-riak-army">{{ $kit->name_id }}</span>
            </p>
        </div>
        <a href="{{ route('creative-kit.index') }}" wire:navigate
            class="text-[10px] font-bold uppercase tracking-widest text-riak-khaki hover:text-riak-army transition-colors flex items-center gap-2">
            ← Kembali ke Creative Kit
        </a>
    </div>

    @if (session()->has('message'))
        <div
            class="mb-6 p-4 bg-riak-cream border border-riak-honey/20 text-riak-army rounded-2xl text-[10px] font-bold uppercase tracking-widest">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div
            class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-[10px] font-bold uppercase tracking-widest">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="bg-white rounded-[2rem] border border-riak-honey/10 p-8 shadow-sm">
            <h3 class="font-serif italic text-xl text-riak-army mb-6">Generate Code</h3>

            <form wire:submit.prevent="store" class="space-y-5">
                <div>
                    <label Gaza="kitVariant"
                        class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey mb-2">
                        Pilih Varian Kit
                    </label>
                    <select wire:model="kitVariant" id="kitVariant"
                        class="w-full px-5 py-3.5 bg-riak-cream/20 border border-riak-honey/10 rounded-2xl focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey text-xs font-bold text-riak-army transition">
                        <option value="">-- Pilih Varian --</option>
                        @foreach ($kit->variants as $variant)
                            <option value="{{ $variant->variant_name }}">{{ $variant->variant_name }}</option>
                        @endforeach
                    </select>
                    @error('kitVariant')
                        <span
                            class="text-[10px] font-bold text-red-500 mt-2 block tracking-wider uppercase">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey mb-2">
                        Input Kode Baru
                    </label>
                    <input type="text" wire:model="code" placeholder="CONTOH: KIT-RIAC99"
                        class="w-full px-5 py-3.5 bg-riak-cream/20 border border-riak-honey/10 rounded-2xl focus:outline-none focus:border-riak-honey focus:ring-1 focus:ring-riak-honey text-xs font-bold uppercase tracking-wider text-riak-army transition placeholder-riak-khaki/50">
                    @error('code')
                        <span
                            class="text-[10px] font-bold text-red-500 mt-2 block tracking-wider uppercase">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3.5 bg-riak-army text-riak-cream rounded-full text-[10px] font-bold uppercase tracking-widest shadow-lg hover:bg-riak-honey transition-all flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="store">Simpan Kode</span>
                    <span wire:loading wire:target="store"
                        class="animate-spin rounded-full h-3 w-3 border-2 border-riak-cream border-t-transparent"></span>
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-[2rem] border border-riak-honey/10 overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-riak-cream/30 border-b border-riak-honey/10">
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey w-20">No
                        </th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Unique
                            Code</th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Varian
                        </th>
                        <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Status /
                            User</th>
                        <th
                            class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-riak-honey/5">
                    @forelse ($uniqueCodes as $index => $item)
                        <tr class="group hover:bg-riak-cream/10 transition-colors">
                            <td class="px-6 py-5 text-xs text-riak-khaki">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="font-mono text-sm font-bold tracking-wider text-riak-army bg-riak-cream/40 px-3 py-1.5 rounded-xl border border-riak-honey/5">
                                    {{ $item->code }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="text-xs font-semibold text-riak-army bg-riak-honey/10 px-2.5 py-1 rounded-lg">
                                    {{ $item->kit_variant ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col gap-1.5 items-start">
                                    @if ($item->is_used)
                                        <span
                                            class="px-2.5 py-0.5 rounded-full bg-red-50 border border-red-100 text-red-600 text-[9px] font-bold uppercase tracking-widest">
                                            Used
                                        </span>
                                        <span class="text-xs font-medium text-riak-army">
                                            Oleh: <span
                                                class="font-bold italic">{{ $item->member->user->name ?? 'User' }}</span>
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-[9px] font-bold uppercase tracking-widest">
                                            Available
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex justify-end">
                                    <button wire:click="delete({{ $item->id }})"
                                        @if ($item->is_used) disabled @endif
                                        wire:confirm="Hapus kode unik ini?"
                                        class="p-2 transition-colors {{ $item->is_used ? 'text-gray-300 cursor-not-allowed' : 'text-red-400 hover:text-red-600' }}"
                                        title="{{ $item->is_used ? 'Kode sudah digunakan' : 'Hapus Kode' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center font-serif italic text-riak-khaki">
                                Belum ada data kode unik untuk creative kit ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
