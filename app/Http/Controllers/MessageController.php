<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Frizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, $frizerId)
{
    $request->validate([
        'naslov' => 'required|string|max:255',
        'poruka' => 'required|string|max:2000',
    ]);

    $frizer = Frizer::findOrFail($frizerId);

    Message::create([
        'user_id' => Auth::id(),
        'frizer_id' => $frizer->id,
        'receiver_id' => $frizer->user_id,
        'naslov' => $request->naslov,
        'poruka' => $request->poruka,
    ]);

    return back()->with('success', 'Poruka poslata.');
}

    public function inbox()
    {
        if (Auth::user()->role !== 'frizer') {
            abort(403);
        }

        $frizer = Auth::user()->frizer;

        if (!$frizer) {
            abort(404);
        }

        $messages = Message::with('user')
            ->where('frizer_id', $frizer->id)
            ->where('user_id', '!=', Auth::id())
            ->latest()
            ->get();

        return view('messages.inbox', compact('messages'));
    }

    public function sent()
{
    if (Auth::user()->role !== 'korisnik') {
        abort(403);
    }

    $messages = Message::with('frizer')
        ->where(function ($q) {
            $q->where('user_id', Auth::id())
              ->orWhere('receiver_id', Auth::id());
        })
        ->latest()
        ->get();

    return view('messages.sent', compact('messages'));
}


public function reply(Request $request, $messageId)
{
    if (Auth::user()->role !== 'frizer') {
        abort(403);
    }

    $request->validate([
        'poruka' => 'required|string|max:2000',
    ]);

    $original = Message::findOrFail($messageId);
    $frizer = Auth::user()->frizer;

    if (!$frizer) {
        abort(404);
    }

    $korisnikId = $original->user_id;

    
    if ($korisnikId == Auth::id()) {
        $korisnikId = $original->receiver_id;
    }

    Message::create([
        'user_id' => Auth::id(),
        'frizer_id' => $frizer->id,
        'receiver_id' => $korisnikId, 
        'naslov' => 'Odgovor: ' . $original->naslov,
        'poruka' => $request->poruka,
    ]);

    return back()->with('success', 'Odgovor poslat.');
}
}