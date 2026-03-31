<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <p>Dobrodošao, {{ auth()->user()->name }}!</p>

                <div style="margin-top: 20px; display: flex; gap: 15px; flex-wrap: wrap;">

                 <a href="{{ route('frizeri.index') }}">💇 Pogledaj frizere</a>

                  @if(auth()->user()->role === 'korisnik')
                   <a href="{{ route('termini.myBookings') }}">📅 Moje rezervacije</a>
                  @endif

                @if(auth()->user()->role === 'frizer')
                <a href="{{ route('termini.create') }}">➕ Dodaj termin</a>
                  <a href="{{ route('termini.requests') }}">📩 Moji zahtevi</a>
                  <a href="{{ route('termini.myAccepted') }}">✅ Prihvaćeni termini</a>
            @endif

             @if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.frizeri') }}">⚙️ Admin panel</a>
    <a href="{{ route('admin.reviews') }}">⭐ Sve recenzije</a>
    <a href="{{ route('admin.users') }}">👥 Svi korisnici</a>
@endif

            </div>

            </div>
        </div>
    </div>
</x-app-layout>