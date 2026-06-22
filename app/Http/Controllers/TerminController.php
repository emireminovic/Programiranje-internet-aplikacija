<?php

namespace App\Http\Controllers;

use App\Models\Termin;
use App\Models\Frizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerminController extends Controller
{
    public function create()
    {
        if (Auth::user()->role !== 'frizer') {
            abort(403);
        }

        return view('termini.create');
    }

    public function store(Request $request)
{
    if (Auth::user()->role !== 'frizer') {
        abort(403);
    }

    $request->validate([
        'datum' => 'required|date',
        'vreme' =>  'required|date_format:H:i',
    ]);

    $frizer = Auth::user()->frizer;

    if (!$frizer) {
        return back()->with('error', 'Frizer profil nije pronađen.');
    }

    Termin::create([
        'frizer_id' => $frizer->id,
        'datum' => $request->datum,
        'vreme' => $request->vreme,
        'status' => 'slobodan',
    ]);

    return back()->with('success', 'Termin je uspešno dodat.');
}

public function book($id)
{
    if (Auth::user()->role !== 'korisnik') {
        abort(403);
    }

    $termin = Termin::findOrFail($id);

    if ($termin->status !== 'slobodan') {
        return back()->with('error', 'Termin nije dostupan.');
    }

    $termin->user_id = Auth::id();
    $termin->status = 'na_cekanju';
    $termin->save();

    return back()->with('success', 'Zahtev za rezervaciju je poslat.');
}

public function requests()
{
    if (Auth::user()->role !== 'frizer') {
        abort(403);
    }

    $frizer = Auth::user()->frizer;

    if (!$frizer) {
        abort(404, 'Frizer profil nije pronađen.');
    }

    $termini = Termin::where('frizer_id', $frizer->id)
        ->where('status', 'na_cekanju')
        ->with('user')
        ->get();

    return view('termini.requests', compact('termini'));
}

public function approve($id)
{
    if (Auth::user()->role !== 'frizer') {
        abort(403);
    }

    $frizer = Auth::user()->frizer;
    $termin = Termin::findOrFail($id);

    if ($termin->frizer_id !== $frizer->id) {
        abort(403);
    }

    if ($termin->status !== 'na_cekanju') {
        return back()->with('error', 'Ovaj zahtev više nije na čekanju.');
    }

    $termin->status = 'zakazan';
    $termin->save();

    return back()->with('success', 'Rezervacija je prihvaćena.');
}

public function reject($id)
{
    if (Auth::user()->role !== 'frizer') {
        abort(403);
    }

    $frizer = Auth::user()->frizer;
    $termin = Termin::findOrFail($id);

    if ($termin->frizer_id !== $frizer->id) {
        abort(403);
    }

    if ($termin->status !== 'na_cekanju') {
        return back()->with('error', 'Ovaj zahtev više nije na čekanju.');
    }

    $termin->user_id = null;
    $termin->status = 'slobodan';
    $termin->save();

    return back()->with('success', 'Rezervacija je odbijena.');
}

public function myBookings()
{
    if (Auth::user()->role !== 'korisnik') {
        abort(403);
    }

    $termini = Termin::where('user_id', Auth::id())
        ->with('frizer')
        ->orderBy('datum')
        ->orderBy('vreme')
        ->get();

    return view('termini.my-bookings', compact('termini'));
}

public function myAccepted()
{
    if (Auth::user()->role !== 'frizer') {
        abort(403);
    }

    $frizer = Auth::user()->frizer;

    if (!$frizer) {
        abort(404, 'Frizer profil nije pronađen.');
    }

    $termini = Termin::where('frizer_id', $frizer->id)
        ->where('status', 'zakazan')
        ->with('user')
        ->orderBy('datum')
        ->orderBy('vreme')
        ->get();

    return view('termini.my-accepted', compact('termini'));
}


}