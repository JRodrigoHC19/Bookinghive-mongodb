<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Booking Hive</title> 
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="{{ asset('sass/detalles.scss') }}">
    <link rel="stylesheet" href="{{ asset('css/colores.css') }}">
    <style>
        .search-container {
            position: relative;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 200px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-top: none;
            z-index: 1;
        }

        .search-results li {
        padding: 8px;
        cursor: pointer;
        }

        .search-results li:hover {
        background-color: #e9e9e9;
        }
    </style>
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- ESTOS 4 SON PARA LAS GRÁFICAS -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

</head>

<body class="antialiased">
    <!-- ESTE ES LA BARRA DE ARRRIBA QUE SE QUEDA ESTATICO -->
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


    <div class="container-fluid ">
        <div class="row">
          <div class="col-auto sidebar" id="sidebar">
            <div class="d-flex justify-content-between">

                <ul class="nav flex-column list-unstyled ps-0">

                    <li class="nav-item sidebar-tamano">
                        <div class="btn-group dropend">
                            <button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i>
                                <span class="nav-link-text">Graficoas</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Menu item</a></li>
                                <li><a class="dropdown-item" href="#">Menu item</a></li>
                                <li><a class="dropdown-item" href="#">Menu item</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item sidebar-tamano">
                        <a class="nav-link" href="#">
                            <i class="bi bi-person"></i>
                            <span class="nav-link-text">Perfil</span>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link sidebar-tamano" href="#">
                            <i class="bi bi-gear"></i>
                            <span class="nav-link-text">Configuración</span>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link sidebar-tamano" href="#">
                            <i class="bi bi-box-arrow-left"></i>
                            <span class="nav-link-text">Cerrar sesión</span>
                        </a>
                    </li>

                </ul>

            </div>
        </div>

        <div class="col" style="background-color: burlywood;">

            <h1>Contenido Principal</h1>
            <p>Este es el contenido principal de la página.</p>
            <figure class="highcharts-figure">
                <div id="cont"></div>
                <p class="highcharts-description">
                Bar chart showing horizontal columns. This chart type is often
                beneficial for smaller screens, as the user can scroll through the data
                vertically, and axis labels are easy to read.
                </p>
            </figure>

        </div>
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

    <!-- CREACIÓN DE LA GRÁFICA -->
    <script>        
        Highcharts.chart('cont', {
            chart: {
            type: 'bar'
            },
            title: {
            text: 'Historic World Population by Region',
            align: 'left'
            },
            subtitle: {
            text: 'Source: <a ' +
                'href="https://en.wikipedia.org/wiki/List_of_continents_and_continental_subregions_by_population"' +
                'target="_blank">Wikipedia.org</a>',
            align: 'left'
            },
            xAxis: {
            categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
            title: {
                text: null
            },
            gridLineWidth: 1,
            lineWidth: 0
            },
            yAxis: {
            min: 0,
            title: {
                text: 'Population (millions)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            },
            gridLineWidth: 0
            },
            tooltip: {
            valueSuffix: ' millions'
            },
            plotOptions: {
            bar: {
                borderRadius: '50%',
                dataLabels: {
                enabled: true
                },
                groupPadding: 0.1
            }
            },
            legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
            },
            credits: {
            enabled: false
            },
            series: [{
            name: 'Year 1990',
            data: [631, 727, 3202, 721, 26]
            }, {
            name: 'Year 2000',
            data: [814, 841, 3714, 726, 31]
            }, {
            name: 'Year 2010',
            data: [1044, 944, 4170, 735, 40]
            }, {
            name: 'Year 2018',
            data: [1276, 1007, 4561, 746, 42]
            }]
        });


    </script>

    
    <!-- ADIICIONALES -->
    <script src="{{ asset('js/animaciones.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script> -->
    <!-- <script src="sweetalert2/dist/weetalert2.all.min.js"></script> -->
    
   

</body>
</html>