<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage-Unique-Code-Kit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('layout.admin.creative-kit.unique-code', ['creativeKitId' => $creativeKitId])
        </div>
    </div>
</x-app-layout>
