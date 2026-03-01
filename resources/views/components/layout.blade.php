<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'MyEvents' }}</title>
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
  <header class="container">
    <a href="/" class="brand">MyEvents</a>
    <nav>
      <a href="/admin">Admin</a>
    </nav>
  </header>
  <main class="container">
    {{ $slot }}
  </main>
  <footer class="container small">© {{ date('Y') }} MyEvents</footer>
</body>
</html>
