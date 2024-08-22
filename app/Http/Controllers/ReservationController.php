<?php

namespace App\Http\Controllers;

use App\Actions\CreateDummyData;
use App\Actions\CreateReservationDummyData;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = User::with('reservation.groups.guests')->find(Auth::user()->id);

        if (!$user->reservation) {
            CreateReservationDummyData::for($user->defaultPage());
            $user->load('reservation.groups.guests');
        }

        
       return Inertia::render('Reservations/Index', [
        'reservation' => $user->reservation
       ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {

       $validated = $request->validate([
            'rsvp_questions' => 'required|array',
        ]);

        $reservation->update($validated);
    }

}
