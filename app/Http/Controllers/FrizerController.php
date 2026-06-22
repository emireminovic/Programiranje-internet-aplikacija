<?php

namespace App\Http\Controllers;

use App\Models\Frizer;
use App\Models\User;
use Illuminate\Http\Request;

class FrizerController extends Controller
{
    public function index(Request $request)
{
    $query = Frizer::with(['reviews', 'termini']);

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('ime', 'like', '%' . $request->search . '%')
              ->orWhere('prezime', 'like', '%' . $request->search . '%');
        });
    }

    $frizeri = $query->get();

    if ($request->rating) {
        $frizeri = $frizeri->filter(function ($frizer) use ($request) {
            return $frizer->reviews->count() > 0 &&
                round($frizer->reviews->avg('ocena'), 1) >= $request->rating;
        });
    }

    return view('frizeri.index', compact('frizeri'));
}

    public function show($id)
    {
        $frizer = Frizer::findOrFail($id);
        $termini = $frizer->termini()->where('status', 'slobodan')->get();

        return view('frizeri.show', compact('frizer', 'termini'));
    }

   

    public function edit($id)
    {
        $frizer = Frizer::findOrFail($id);
        if (auth()->user()->id !== $frizer->user_id) {
        abort(403);
    }
        return view('frizeri.edit', compact('frizer'));
        
    }

    public function update(Request $request, $id)
{
    $frizer = Frizer::findOrFail($id);

   
    if (auth()->user()->id !== $frizer->user_id) {
        abort(403);
    }

    
    $request->validate([
        'cena' => 'nullable|numeric|min:0',
        'slika' => 'nullable|image|mimes:jpg,jpeg,png|max:50000',
    ]);

    
    if ($request->hasFile('slika')) {
        $path = $request->file('slika')->store('frizeri', 'public');
        $frizer->slika = $path;
    }

   
    $frizer->cena = $request->cena;

    $frizer->save();

    return redirect()->route('frizeri.show', $id)
        ->with('success', 'Profil uspešno ažuriran.');
}

    

    public function requests()
    {
        $frizeri = User::where('role', 'frizer')
            ->where('status', 'pending')
            ->get();

        return view('admin.frizeri', compact('frizeri'));
    }

    public function approve($id)
    {
        $user = \App\Models\User::findOrFail($id);

        $user->status = 'approved';
        $user->save();

        if ($user->role === 'frizer' && !$user->frizer) {
            \App\Models\Frizer::create([
                'user_id' => $user->id,
                'ime' => $user->name,
                'prezime' => '',
                'email' => $user->email,
                'telefon' => '',
            ]);
        }

        return redirect()->back()->with('success', 'Frizer je odobren.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

       return back()->with('success', 'Frizer je odbijen.');
    }


    public function allUsers()
{
    $users = User::orderBy('created_at', 'desc')->get();

    return view('admin.users', compact('users'));
}

public function deleteUser($id)
{
    $user = User::findOrFail($id);

    if ($user->role === 'admin') {
        return back()->with('error', 'Admin korisnik ne može biti obrisan.');
    }

    $user->delete();

    return back()->with('success', 'Korisnik je uspešno obrisan.');
}


public function sendWarning(Request $request, $id)
{
     $request->validate([
        'poruka' => 'required|string|max:500',
    ]);


    $user = User::findOrFail($id);

    \App\Models\Warning::create([
        'user_id' => $user->id,
        'poruka' => $request->poruka,
    ]);

    return back()->with('success', 'Upozorenje poslato.');
}

}