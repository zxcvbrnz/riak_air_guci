<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage-Movement School') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (request()->routeIs('movement-school.edit'))
                @livewire('layout.admin.movement-school.form', ['schoolId' => $schoolId])
            @else
                @livewire('layout.admin.movement-school.form')
            @endif
        </div>
    </div>
</x-app-layout>
