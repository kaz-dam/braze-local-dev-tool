<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <wireui:scripts />
        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased flex h-screen bg-gray-50">
        <!-- Sidebar for desktop -->
        <aside class="hidden lg:block w-64 bg-white border-r shadow-sm p-4">
            {{-- @include('partials.sidebar') --}}
            some sidebar content
            @livewire('components.dev-file-list')
        </aside>

        <!-- Drawer for mobile -->
        {{-- <x-modal.card wire:model.defer="showSidebar" maxWidth="sm" blur> --}}
            {{-- @include('partials.sidebar') --}}
        {{-- </x-modal.card> --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="flex items-center justify-between px-4 py-3 bg-white border-b shadow-sm">
                <!-- Mobile menu toggle -->
                <button class="lg:hidden" wire:click="$set('showSidebar', true)">
                    menu
                </button>

                <!-- Title or branding -->
                <h1 class="text-xl font-semibold text-gray-800">Dev Tool</h1>

                <!-- Dropdown menu -->
                <x-dropdown>
                    <x-slot name="trigger">
                        {{-- <x-button flat icon="menu" /> --}}
                        menu
                    </x-slot>

                    <x-dropdown.item label="Add User" href="#" />
                    <x-dropdown.item label="User Attributes" href="#" />
                </x-dropdown>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-hidden">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
