<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Guest $guest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guest $guest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'rsvp_data' => 'required|json',
        ]);
        
        $rsvpData = json_decode($validated['rsvp_data'], true);
        $attendance = collect($rsvpData)->firstWhere('question_id', 1);
        
        $guest->is_attending = $attendance['answer'] === 'Yes';
        $guest->rsvp_data = $rsvpData;
        $guest->answered_at = now();
        $guest->save();
        
        return redirect()->back()->with('success', 'Guest updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guest $guest)
    {
        //
    }
}