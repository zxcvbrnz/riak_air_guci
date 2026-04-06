<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage-Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (request()->routeIs('product.edit'))
                @livewire('layout.admin.product.form', ['productId' => $productId])
            @else
                @livewire('layout.admin.product.form')
            @endif
        </div>
    </div>
</x-app-layout>
