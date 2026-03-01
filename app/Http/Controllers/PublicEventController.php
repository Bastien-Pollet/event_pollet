<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmed;

class PublicEventController extends Controller
{
    public function home()
    {
        $events = Event::query()
            ->where('is_private', false)
            ->where(function($q){
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->orderBy('starts_at')
            ->limit(12)
            ->get();
        return view('home', compact('events'));
    }

    public function show(Event $event)
    {
        abort_if($event->is_private, 403);
        return view('events.show', compact('event'));
    }

    public function register(Request $request, Event $event)
    {
        abort_if($event->is_private, 403);
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email'],
            'rsvp' => ['required','in:yes,no,maybe'],
            'dietary' => ['nullable','string','max:255'],
            'guests_count' => ['nullable','integer','min:0','max:10'],
        ]);

        $data['token'] = Str::random(32);
        $data['event_id'] = $event->id;
        $registration = Registration::create($data);

        // Envoi d'un email de confirmation (config mail requise)
        try {
            if (config('mail.default')) {
                Mail::to($registration->email)->send(new RegistrationConfirmed($registration));
            }
        } catch (\Throwable $e) {
            // on ignore en dev si mail non configuré
        }

        return redirect()->back()->with('success', "Inscription enregistrée. Un email de confirmation sera envoyé si la messagerie est configurée.");
    }
}
