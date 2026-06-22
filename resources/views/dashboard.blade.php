<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            @if (auth()->user()->role === 'user' && auth()->user()->member && auth()->user()->member->uniqueCode)
                @php
                    $uniqueCode = auth()->user()->member->uniqueCode;
                    $isKit = $uniqueCode->type === 'kit';

                    // Memilih objek data utama (Product atau CreativeKit) berdasarkan type
                    $itemData = $isKit ? $uniqueCode->creativeKit : $uniqueCode->product;
                @endphp

                @if ($itemData)
                    <div class="space-y-8">
                        <div class="w-full bg-white shadow sm:rounded-lg overflow-hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 sm:p-8">

                                <div class="flex flex-col justify-between">
                                    <div>
                                        <div class="mb-6">
                                            <h2
                                                class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-2">
                                                Unique Code ({{ ucfirst($uniqueCode->type) }})
                                            </h2>
                                            <span
                                                class="inline-block bg-indigo-50 text-indigo-700 font-mono text-xl font-bold px-4 py-2 rounded-lg border border-indigo-100 shadow-sm">
                                                {{ $uniqueCode->code }}
                                            </span>

                                            @if ($isKit && $uniqueCode->kit_variant)
                                                <div class="mt-2">
                                                    <span
                                                        class="inline-block bg-amber-50 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-md border border-amber-100">
                                                        Variant: {{ $uniqueCode->kit_variant }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <hr class="border-gray-100 my-6">

                                        <div>
                                            <h2
                                                class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-2">
                                                {{ $isKit ? 'Creative Kit Detail' : 'Product Detail' }}
                                            </h2>
                                            <h3 class="text-2xl font-bold text-gray-800 mb-1">
                                                {{ $itemData->name_id ?? $itemData->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                Gunakan kode unik di atas untuk keperluan verifikasi, akses materi, atau
                                                klaim produk.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full h-64 md:h-auto min-h-[250px] relative">
                                    @if ($itemData->image)
                                        <img src="{{ asset('storage/' . $itemData->image) }}" alt="Item Image"
                                            class="w-full h-full object-cover rounded-xl shadow-inner border border-gray-100">
                                    @else
                                        <div
                                            class="w-full h-full bg-gray-100 rounded-xl border border-gray-200 flex items-center justify-center text-gray-400 italic text-sm">
                                            No Image Available
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="mt-8">
                            <livewire:dashboard />
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
