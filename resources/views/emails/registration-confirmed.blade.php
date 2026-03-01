@php($r=$registration)
<p>Bonjour {{ $r->name }},</p>
<p>Votre inscription à l'événement <strong>{{ $r->event->title }}</strong> a bien été prise en compte.</p>
<p>Réponse : <strong>{{ strtoupper($r->rsvp) }}</strong> — Invités supplémentaires : {{ $r->guests_count }}</p>
<p>À bientôt !</p>
