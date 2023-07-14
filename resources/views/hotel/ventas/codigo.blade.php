<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="{{ asset('sass/detalles.scss') }}">
    <link rel="stylesheet" href="{{ asset('css/colores.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
</head>

<body class="u-body">

    <div id="app">
      
        <!-- ESTE APARTADO ES EL LA BARRA QUE SE MUESTRA ARRIBITA -->
        <nav id="dezliz-sombra" class="desliz-sombrita shadow-sm navbar navbar-expand-lg fixed-top bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">Booking Hive</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('hoteles',['id' => auth()->user()->id]) }}">Home</a>
                        </li>
                        
                        @auth
                        @if (auth()->user()->rol == 'G')
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{route('cuentas')}}">Administrar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="https://marketingplatform.google.com/intl/es/about/analytics/">Rendimiento</a>
                            </li>
                        @endif
                        @endauth

                        @php use App\Models\Hotel @endphp
                        
                        @auth
                            @if (auth()->user()->rol == 'M')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('graficas')}}">Gráficas</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('hotel',['ruc_hotel' => Hotel::getRuc(auth()->user()->email), 'id_user' => auth()->user()->id])}}">Hotel</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    @auth
                        <form class="d-flex search-container" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar en Google" aria-label="Search">
                            <ul class="search-results"></ul>
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form><pre>     </pre> 
                    @endauth
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        
                        @if (Route::has('login'))
                        @auth
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @auth

                                @if (auth()->user()->rol == 'M' || auth()->user()->rol == 'R')
                                <a class="dropdown-item" href="{{route('perfil',auth()->user()->id)}}">Configuración</a>
                                
                                @endif

                                @if (auth()->user()->rol == 'R')
                                <a class="dropdown-item" href="{{route('ventas',auth()->user()->id)}}">Compras</a>
                                @endif
                                
                                @if (auth()->user()->rol == 'M')
                                <a class="dropdown-item" href="{{route('ventas',auth()->user()->id)}}">Ventas</a>
                                @endif

                                @endauth
                                
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>
                        </li>    
                        @else

                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Log in</a></li>

                        @if (Route::has('register'))
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                        @endif
                        
                        @endauth
                    
                        @endif
                    </ul>

                </div>

            </div>
        </nav><br/><br/><br/> 
      
        <!-- ESTE ES EL CONTENIDO QUE SE MUESTRA - TIENES QUE ESTAR LOGEADO -->
        <div class="card row">
            <input class="col-4" type="text" id="randomString" value="{{ $codigo }}">
            <button class="col-4" onclick="copyToClipboard()">Copiar</button>
        </div>

        <a href="{{ route('home') }}">Regresar</a>




    </div>






<!-- SCRIPT QUE SE DEBEN CARGAR 1RO -->

    <!-- SISTEMA DE BÚSQUEDA -->
    <script>
      const searchInput = document.querySelector('.search-container input');
      const searchResults = document.querySelector('.search-results');

      const lista = [];
      @foreach ($hoteles_full as $hot)
          lista.push('{{ $hot->titulo }}');
      @endforeach

      searchInput.addEventListener('input', function() {
          const searchText = searchInput.value.trim();
          if (searchText === '') {
              searchResults.innerHTML = '';
              return;
          }

          // Simulación de resultados de búsqueda
          const results = lista;

          const matchedResults = results.filter(result => result.toLowerCase().includes(searchText.toLowerCase())).slice(0, 5);

          searchResults.innerHTML = '';
          if (matchedResults.length === 0) {
              searchResults.style.display = 'none';
          } else {
              searchResults.style.display = 'block';
              matchedResults.forEach(result => { 
                  const link = document.createElement('a'); // Nueva etiqueta 'a'
                  const li = document.createElement('li');
                  link.href = "{{ route('hotel', ['ruc_hotel' => 0, 'id_user' => auth()->user()->id]) }}" + "/?letrero=" + result; // Establece el enlace deseado aquí
                  li.addEventListener('click', function() {
                      searchInput.value = result;
                      searchResults.style.display = 'none';
                  });
                  
                  link.appendChild(li); // Anida el <li> dentro del <a>
                  li.textContent = result;
                  link.classList.add('link-offset-2', 'link-underline', 'link-underline-opacity-0');

                  searchResults.appendChild(link);
              });
          }
      });

      document.addEventListener('click', function(event) {
          if (!searchResults.contains(event.target)) {
              searchResults.style.display = 'none';
          }
      });
    </script>

    <!-- ADIICIONALES -->
    <script src="{{ asset('js/animaciones.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script> -->
    <!-- <script src="sweetalert2/dist/weetalert2.all.min.js"></script> -->
    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("randomString");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // Para dispositivos móviles
            document.execCommand("copy");
            alert("¡Texto copiado!");
        }
    </script>
</body>

</html>
