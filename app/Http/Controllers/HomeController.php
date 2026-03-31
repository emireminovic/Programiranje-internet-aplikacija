<?php

namespace App\Http\Controllers;

use App\Models\Frizer;

class HomeController extends Controller
{
    public function index()
    {
        $usluge = [
            [
                'naziv' => 'Muško šišanje',
                'opis' => 'Klasično i moderno šišanje uz profesionalan pristup.',
            ],
            [
                'naziv' => 'Žensko šišanje',
                'opis' => 'Savremene frizure, skraćivanje i stilizovanje kose.',
            ],
            [
                'naziv' => 'Farbanje kose',
                'opis' => 'Farbanje, preliv, osvežavanje boje i moderni trendovi.',
            ],
            [
                'naziv' => 'Feniranje i stilizovanje',
                'opis' => 'Feniranje za svakodnevne i svečane prilike.',
            ],
            [
                'naziv' => 'Uređivanje brade',
                'opis' => 'Precizno oblikovanje i održavanje brade.',
            ],
            [
                'naziv' => 'Pakovanje i nega kose',
                'opis' => 'Tretmani za oporavak, sjaj i zdrav izgled kose.',
            ],
        ];

        $aktuelnosti = [
            'Nova mesta za rezervaciju dostupna su svakog dana.',
            'Pratite najbolje ocenjene frizere i njihove slobodne termine.',
            'BookCut omogućava brzo slanje zahteva i pregled recenzija.',
        ];

        $popularniFrizeri = Frizer::with('reviews')
            ->get()
            ->sortByDesc(function ($frizer) {
                return $frizer->reviews->avg('ocena') ?? 0;
            })
            ->take(3);

        return view('home', compact('usluge', 'aktuelnosti', 'popularniFrizeri'));
    }
}