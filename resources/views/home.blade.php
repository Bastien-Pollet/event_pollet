<x-layout>
  <x-slot name="title">Accueil — MyEvents</x-slot>
  <section class="hero">
    <h1>Organisez des événements avec élégance</h1>
    <p>Créez, gérez et suivez vos événements. Inscriptions simples sans compte.</p>
    <a class="btn" href="/admin">Entrer dans la plateforme</a>
  </section>

  <section>
    <h2>Événements publics à venir</h2>
    <div class="grid">
      @forelse($events as $event)
        <article class="card">
          <h3><a href="{{ route('events.show', $event) }}">{{ $event->title }}</a></h3>
          @if($event->starts_at)
            <p class="muted">{{ $event->starts_at->translatedFormat('d F Y H:i') }}</p>
          @endif
          <p class="muted">{{ Str::limit($event->description, 120) }}</p>
        </article>
      @empty
        <p>Aucun événement public pour le moment.</p>
      @endforelse
    </div>
  </section>
</x-layout>
