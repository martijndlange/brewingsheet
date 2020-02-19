<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="stylesheet" href="/css/app.css">
  <title>Kasboek BUK</title>
</head>
<body>
<div id="app">
<buk
  saldo="{{ $saldo }}"
  :data-fields="{{ $data }}"
  :mutations="{{ $mutations }}"
></buk>
</div>
<script src="{{ asset('js/app.js')}}"></script>
</body>
</html>
