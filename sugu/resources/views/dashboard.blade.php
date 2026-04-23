<x-app-layout>
    <x-slot name="header">
        <div class="hero">
            <div>
                <h1>Sugu Web</h1>
                <p>Plateforme moderne</p>
                <button class="btn btn-luxe">Explorer</button>
                {{ __('Dashboard') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>