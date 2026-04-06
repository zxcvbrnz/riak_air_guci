<?php

use App\Models\Product;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination;

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        session()->flash('message', 'Produk berhasil dihapus.');
    }

    public function with()
    {
        return [
            'products' => Product::orderBy('order', 'asc')->paginate(10),
        ];
    }
}; ?>

<div class="max-w-7xl mx-auto pb-20 px-6">
    <x-slot name="header">Kelola Produk</x-slot>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
        <div>
            <h2 class="font-serif italic text-4xl text-riak-army">Inventory List</h2>
            <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-riak-honey mt-2">Manajemen Stok & Produk</p>
        </div>
        <a href="{{ route('product.create') }}" wire:navigate
            class="px-8 py-3 bg-riak-army text-riak-cream rounded-full text-[10px] font-bold uppercase tracking-widest shadow-lg hover:bg-riak-honey transition-all">
            + Tambah Produk
        </a>
    </div>

    @if (session()->has('message'))
        <div
            class="mb-6 p-4 bg-riak-cream border border-riak-honey/20 text-riak-army rounded-2xl text-[10px] font-bold uppercase tracking-widest">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-riak-honey/10 overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-riak-cream/30 border-b border-riak-honey/10">
                    <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Preview</th>
                    <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Product Name
                    </th>
                    <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Price</th>
                    <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Tag</th>
                    <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Order</th>
                    <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-riak-honey text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-riak-honey/5">
                @forelse ($products as $product)
                    <tr class="group hover:bg-riak-cream/10 transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden border border-riak-honey/10">
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-serif italic text-lg text-riak-army">{{ $product->name_id }}</div>
                            <div class="text-[10px] text-riak-khaki uppercase tracking-tighter">{{ $product->name_en }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-riak-army">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-3 py-1 rounded-full bg-riak-cream text-riak-army text-[9px] font-bold uppercase tracking-widest border border-riak-honey/20">
                                {{ $product->tag }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-riak-khaki">
                            {{ $product->order }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-3">
                                <a href="{{ $product->link_shopee }}" target="_blank"
                                    class="p-2 text-orange-400 hover:text-orange-600 transition-colors"
                                    title="Lihat Shopee">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </a>
                                <a href="{{ route('product.edit', $product->id) }}" wire:navigate
                                    class="p-2 text-riak-army hover:text-riak-honey transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L12 14.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $product->id }})" wire:confirm="Hapus produk ini?"
                                    class="p-2 text-red-400 hover:text-red-600 transition-colors">
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
                        <td colspan="6" class="px-6 py-20 text-center font-serif italic text-riak-khaki">
                            Belum ada data produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
