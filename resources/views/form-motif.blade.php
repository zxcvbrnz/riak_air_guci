<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage-Motif') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (request()->routeIs('motif.edit'))
                @livewire('layout.admin.motif.form', ['motifId' => $motifId])
            @else
                @livewire('layout.admin.motif.form')
            @endif
        </div>
    </div>
</x-app-layout>
