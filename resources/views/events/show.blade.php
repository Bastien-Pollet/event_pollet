<x-layout>
  <x-slot name="title">{{ $event->title }} — MyEvents</x-slot>
  <article class="event">
    <h1>{{ $event->title }}</h1>
    @if($event->image_path)
      <img class="banner" src="{{ asset($event->image_path) }}" alt="{{ $event->title }}" />
    @endif
    @if($event->starts_at)
      <p class="muted">Le {{ $event->starts_at->translatedFormat('d F Y à H:i') }} @if($event->location) — {{ $event->location }} @endif</p>
    @endif

    <p>{{ $event->description }}</p>
  </article>

  <section class="card">
    <h2>S'inscrire</h2>
    @if(session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif
    <form method="post" action="{{ route('events.register', $event) }}">
      @csrf
      <div class="row">
        <label>Nom complet
          <input type="text" name="name" value="{{ old('name') }}" required>
        </label>
        @error('name')<div class="error">{{ $message }}</div>@enderror
      </div>
      <div class="row">
        <label>Email
          <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        @error('email')<div class="error">{{ $message }}</div>@enderror
      </div>
      <div class="row">
        <label>Réponse
          <select name="rsvp" required>
            <option value="yes">Je viens</option>
            <option value="no">Je ne viens pas</option>
            <option value="maybe">Peut-être</option>
          </select>
        </label>
      </div>
      <div class="row">
        <label>Contraintes alimentaires
          <input type="text" name="dietary" value="{{ old('dietary') }}" placeholder="végétarien, allergies...">
        </label>
      </div>
      <div class="row">
        <label>Invités supplémentaires
          <input type="number" min="0" max="10" name="guests_count" value="{{ old('guests_count', 0) }}">
        </label>
      </div>
      <button class="btn" type="submit">Valider l'inscription</button>
    </form>
  </section>
</x-layout>
