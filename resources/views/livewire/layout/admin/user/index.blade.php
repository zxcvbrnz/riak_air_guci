<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function with(): array
    {
        return [
            // Menggunakan withCount untuk menghitung jumlah relasi members secara efisien
            'users' => User::where('role', 'user')->withCount('member')->latest()->paginate(10),
        ];
    }
}; ?>

<div class="max-w-6xl mx-auto pb-24 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">User Directory</h2>
    </x-slot>

    {{-- USER TABLE CARD --}}
    <div class="bg-white rounded-[3rem] border border-riak-honey/10 shadow-sm overflow-hidden mt-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-riak-honey/10 bg-riak-cream/10">
                        <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey w-20 text-center">
                            No</th>
                        <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Informasi User
                        </th>
                        <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Role Sistem</th>
                        <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Status Klaim
                        </th>
                        <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Tanggal
                            Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-riak-honey/5">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-riak-cream/5 transition-colors" wire:key="user-row-{{ $user->id }}">
                            {{-- Nomor Index --}}
                            <td class="p-6 text-xs text-riak-khaki text-center font-mono">
                                {{ $users->firstItem() + $index }}
                            </td>

                            {{-- Informasi Utama --}}
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-riak-cream text-riak-army font-serif font-bold italic flex items-center justify-center border border-riak-honey/20 flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-riak-army">{{ $user->name }}</h4>
                                        <p class="text-[10px] text-riak-khaki font-mono mt-0.5">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Badge Role (Berdasarkan kolom 'role' default: 'user') --}}
                            <td class="p-6">
                                <span
                                    class="inline-flex px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-wider 
                                    {{ $user->role === 'admin' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-riak-cream text-riak-army border border-riak-honey/10' }}">
                                    {{ $user->role }}
                                </span>
                            </td>

                            {{-- Status Klaim Member (Mengecek jika members_count > 0) --}}
                            <td class="p-6">
                                @if ($user->members_count > 0)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-green-50 text-green-700 border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                        Sudah Memiliki Member
                                    </span>
                                @else
                                    <span
                                        class="inline-flex px-3 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-gray-50 text-gray-400 border border-gray-200">
                                        Belum Ada Member
                                    </span>
                                @endif
                            </td>

                            {{-- Waktu Registrasi --}}
                            <td class="p-6 text-xs text-riak-khaki">
                                {{ $user->created_at->translatedFormat('d F Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-16 text-center text-riak-khaki italic text-xs">
                                Tidak ada data pengguna dalam sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- NAVIGASI PAGINATION --}}
        @if ($users->hasPages())
            <div class="p-6 border-t border-riak-honey/10 bg-riak-cream/5">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
