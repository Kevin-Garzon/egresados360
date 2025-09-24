<h1>Ofertas Laborales</h1>

<ul>
  @foreach($ofertas as $oferta)
    <li>
      <strong>{{ $oferta->titulo }}</strong> - {{ $oferta->empresa }} <br>
      {{ $oferta->ubicacion }} <br>
      <a href="{{ $oferta->url_externa }}" target="_blank">Ver más</a>
      <hr>
    </li>
  @endforeach
</ul>