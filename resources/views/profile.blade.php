<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- jika user terdapat input unique code yang tidak bisa di ubah sama sekali dan ada detail produk nya beserta gambarnya --}}
            @if (auth()->user()->role === 'user' && auth()->user()->member)
                <div class="w-full bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 sm:p-8">

                        <!-- Kolom Kiri: Detail Informasi -->
                        <div class="flex flex-col justify-between">
                            <div>
                                <!-- Section Kode Unik -->
                                <div class="mb-6">
                                    <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-2">Unique
                                        Code</h2>
                                    <span
                                        class="inline-block bg-indigo-50 text-indigo-700 font-mono text-xl font-bold px-4 py-2 rounded-lg border border-indigo-100 shadow-sm">
                                        {{ auth()->user()->member->uniqueCode->code }}
                                    </span>
                                </div>

                                <hr class="border-gray-100 my-6">

                                <!-- Section Detail Produk -->
                                <div>
                                    <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-2">
                                        Product Detail</h2>
                                    <h3 class="text-2xl font-bold text-gray-800 mb-1">
                                        {{ auth()->user()->member->uniqueCode->product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        Gunakan kode unik di atas untuk keperluan verifikasi atau klaim produk.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Gambar Produk -->
                        <div class="w-full h-64 md:h-auto min-h-[250px] relative">
                            <img src="{{ asset('storage/' . auth()->user()->member->uniqueCode->product->image) }}"
                                alt="Product Image"
                                class="w-full h-full object-cover rounded-xl shadow-inner border border-gray-100">
                        </div>

                    </div>
                </div>
            @endif
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
