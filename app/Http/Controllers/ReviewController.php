<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        if (Auth::user()->role !== 'korisnik') {
            abort(403);
        }

        $request->validate([
            'ocena' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        $vecPostoji = Review::where('user_id', Auth::id())
            ->where('frizer_id', $id)
            ->exists();

        if ($vecPostoji) {
            return back()->with('error', 'Već ste ocenili ovog frizera.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'frizer_id' => $id,
            'ocena' => $request->ocena,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Recenzija uspešno dodata.');
    }

    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $reviews = Review::with(['user', 'frizer'])
            ->latest()
            ->get();

        return view('admin.reviews', compact('reviews'));
    }

    public function myReviews()
{
    if (auth()->user()->role !== 'korisnik') {
        abort(403);
    }

    $reviews = \App\Models\Review::with('frizer')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('reviews.my-reviews', compact('reviews'));
}
}