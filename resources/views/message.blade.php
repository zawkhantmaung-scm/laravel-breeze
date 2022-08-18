<!DOCTYPE html>
<html>
<head>
  <title>{{ $message }}</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
  <section>
    <p>
      {{ $message }}
    </p>
    <button onclick="window.location='{{ route('dashboard') }}'" style="height: 50px">
      to Dashboard
    </button>
  </section>
</body>
</html>