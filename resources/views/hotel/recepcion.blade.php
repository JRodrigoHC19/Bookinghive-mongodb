<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Booking Hive</title>
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    
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
            padding:0;
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
        list-style-type: none;
        }

        .search-results li:hover {
        background-color: #e9e9e9;
        }
    </style>
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    
    <!-- ESTOS 4 SON PARA LA FECHA DE MULTIPLES DÍAS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
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



      <!-- APARTADO DE LA RESERVACION -->
      <!-- PASOS PARA LA RESERVACIÓN --> 
      <div class="row">
        <div class="col-4">
          <form class="col" action="{{ route('concretar-reservacion') }}" method="POST">
            @csrf
            <div class="row">
              <div class="p-3 col-sm-5">
                <label class="form-label">Tipo de habitacion</label>
                <select class="form-select" id="opciones" onchange="mostrarLista()">
                        <option value="1">Individual</option>
                        <option value="2">Doble</option>
                        <option value="3">Familiar</option>
                        <option value="4">Matrimonial</option>
                        <option value="5">King</option>
                </select>
              </div>
            </div>
          
          
            <!-- LISTA QUE SE MUESTRA SEGUN EL TIPO -->
            <div>
              <ul id="lista1" class="grupo" style="display: none;">
                @foreach ($hab_indi as $habitacion)
                <li>
                  <input type="radio" class="btn-check" name="hab" value="{{ $habitacion->id }}" id="opcion{{ $habitacion->id}}" autocomplete="off" required>
                  <label class="btn btn-outline-success" for="opcion{{ $habitacion->id}}">
                    Habitacion: {{ $habitacion->id_hab }} --- PISO: {{ $habitacion->piso }} <br/>
                    PRECIO: {{ $habitacion->precio }} --- CAPACIDAD: {{ $habitacion->capacidad }}
                  </label>
                </li>
                @endforeach
              </ul>
              
              <ul id="lista2" class="grupo" style="display: none;">
                @foreach ($hab_dobl as $habitacion)
                <li>
                  <input type="radio" class="btn-check" name="hab" value="{{ $habitacion->id }}" id="opcion{{ $habitacion->id}}" autocomplete="off" required>
                  <label class="btn btn-outline-success" for="opcion{{ $habitacion->id}}">
                    Habitacion: {{ $habitacion->id_hab }} --- PISO: {{ $habitacion->piso }} <br/>
                    PRECIO: {{ $habitacion->precio }} --- CAPACIDAD: {{ $habitacion->capacidad }}
                  </label>
                </li>
                @endforeach
              </ul>
              
              <ul id="lista3" class="grupo" style="display: none;">
                @foreach ($hab_fami as $habitacion)
                <li>
                  <input type="radio" class="btn-check" name="hab" value="{{ $habitacion->id }}" id="opcion{{ $habitacion->id}}" autocomplete="off" required>
                  <label class="btn btn-outline-success" for="opcion{{ $habitacion->id}}">
                    Habitacion: {{ $habitacion->id_hab }} --- PISO: {{ $habitacion->piso }} <br/>
                    PRECIO: {{ $habitacion->precio }} --- CAPACIDAD: {{ $habitacion->capacidad }}
                  </label>
                </li>
                @endforeach
              </ul>

              <ul id="lista4" class="grupo" style="display: none;">
                @foreach ($hab_matr as $habitacion)
                <li>
                  <input type="radio" class="btn-check" name="hab" value="{{ $habitacion->id }}" id="opcion{{ $habitacion->id}}" autocomplete="off" required>
                  <label class="btn btn-outline-success" for="opcion{{ $habitacion->id}}">
                    Habitacion: {{ $habitacion->id_hab }} --- PISO: {{ $habitacion->piso }} <br/>
                    PRECIO: {{ $habitacion->precio }} --- CAPACIDAD: {{ $habitacion->capacidad }}
                  </label>
                </li>
                @endforeach
              </ul>
            
              <ul id="lista5" class="grupo" style="display: none;">
                @foreach ($hab_king as $habitacion)
                <li>
                  <input type="radio" class="btn-check" name="hab" value="{{ $habitacion->id }}" id="opcion{{ $habitacion->id}}" autocomplete="off" required>
                  <label class="btn btn-outline-success" for="opcion{{ $habitacion->id}}">
                    Habitacion: {{ $habitacion->id_hab }} --- PISO: {{ $habitacion->piso }} <br/>
                    PRECIO: {{ $habitacion->precio }} --- CAPACIDAD: {{ $habitacion->capacidad }}
                  </label>
                </li>
                @endforeach
              </ul>
            </div>

            <!-- FECHA DE RESERVACION -->
            <div class="col-md-4">
              <label for="validationDefault05" class="form-label">Fecha de la Reservación</label>
              <div class="row">
                <input class="col-4 g-3 btn btn-primary" type="button" name="datefilter" value="Establcer Fecha"/>
                <input class="col-4 g-3" type="text" name="inicio" readonly />
                <input class="col-4 g-3" type="text" name="final" readonly />
              </div>
            </div>

            <!-- DATOS ADICIONALES -->
            <input type="text" value="{{ auth()->user()->email }}" name="cliente" hidden />
            <input type="text" value="{{ $hotel->id }}" name="ruc" hidden />
            <input type="submit" value="Realizar Reservación" @auth @if (auth()->user()->rol == 'M') disabled  @endif @endauth >

          </form>
        </div>
        
        <!--SE MUESTRAN LAS RESEÑAS DEL HOTEL -->
        <div class="col-6">
          <div class="card">
            <div class="card-header">
              Reseñas
            </div>
            <ul class="list-group ">
              @php use App\Models\User @endphp
              @foreach ($resenas as $resena )
                <li class="list-group-item">
                Enviado a las {{$resena->created_at}} <br/> <strong>{{user::where('email',$resena->email)->first()->name}}:</strong> {{$resena->msg}} 
                </li>
              @endforeach
            </ul>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
              Comentar
            </button>
          </div>

          <!-- Button trigger modal -->
            




          <!-- SUBIR LA FOTOS PARA EL HOTEL - HABITACIONES -->
          @auth
            @if (auth()->user()->rol == 'M')
              <form action="{{ route('registrar-foto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="photo">
                <button type="submit">Subir Foto</button>
              </form>
            @endif
          @endauth

          <!-- MOSTRAR LAS FOTOS DEL HOTEL - HABITACIONES -->
          <div>
            @foreach ($fotos as $figura)
              <img width="30%" height="30%" src="{{ asset('fotos/'.$figura->nombre) }}" alt="{{$figura->nombre}}">
            @endforeach
          </div>

        </div>
      </div>

    </div>


<!-- VENTANAS EMERGENTES -->

  <!-- ENVIARCOMENTARIOS -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Realizar Comentario</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('comentar') }}" method="POST">
        @csrf
        @auth
          @if (auth()->user()->rol == 'R')
            <div class="modal-body">
            
                <!-- REGISTRAR RESEÑA -->
                
                  <!-- VALORACIONES -->
                  
                  <ul class="row"><label class="form-label">calidad de la Recepcion</label>
                    @for ($i = 0; $i <= 5; $i++)
                    <li class="col-1"> 
                      <input type="radio" class="btn-check" name="cal_rep" value="{{ $i }}" id="cal_rep{{ $i }}" autocomplete="off" required>
                      <label class="btn btn-outline-success" for="cal_rep{{ $i }}">{{ $i }}</label>
                    </li>
                    @endfor
                  </ul>

                  <ul class="row"><label class="form-label">calidad de las Instalaciones</label>
                    @for ($i = 0; $i <= 5; $i++)
                    <li class="col-1"> 
                      <input type="radio" class="btn-check" name="cal_ins" value="{{ $i }}" id="cal_ins{{ $i }}" autocomplete="off" required>
                      <label class="btn btn-outline-success" for="cal_ins{{ $i }}">{{ $i }}</label>
                    </li>
                    @endfor
                  </ul>

                  <ul class="row"><label class="form-label">calidad de la habitacion</label>
                    @for ($i = 0; $i <= 5; $i++)
                    <li class="col-1"> 
                      <input type="radio" class="btn-check" name="cal_hab" value="{{ $i }}" id="cal_hab{{ $i }}" autocomplete="off" required>
                      <label class="btn btn-outline-success" for="cal_hab{{ $i }}">{{ $i }}</label>
                    </li>
                    @endfor
                  </ul>

                  <ul class="row"><label class="form-label">Nivel de Limpieza</label>
                    @for ($i = 0; $i <= 5; $i++)
                    <li class="col-1"> 
                      <input type="radio" class="btn-check" name="cal_limp" value="{{ $i }}" id="cal_limp{{ $i }}" autocomplete="off" required>
                      <label class="btn btn-outline-success" for="cal_limp{{ $i }}">{{ $i }}</label>
                    </li>
                    @endfor
                  </ul>

                  <ul class="row"><label class="form-label">Calidad - Precio</label>
                    @for ($i = 0; $i <= 5; $i++)
                    <li class="col-1"> 
                      <input type="radio" class="btn-check" name="cal_pre" value="{{ $i }}" id="cal_pre{{ $i }}" autocomplete="off" required>
                      <label class="btn btn-outline-success" for="cal_pre{{ $i }}">{{ $i }}</label>
                    </li>
                    @endfor
                  </ul>
                  
                  <ul class="row"><label class="form-label">¿Recomienda el Hotel?</label>
                    @for ($i = 0; $i <= 5; $i++)
                    <li class="col-1"> 
                      <input type="radio" class="btn-check" name="cal_rcm" value="{{ $i }}" id="cal_rcm{{ $i }}" autocomplete="off" required>
                      <label class="btn btn-outline-success" for="cal_rcm{{ $i }}">{{ $i }}</label>
                    </li>
                    @endfor
                  </ul>

                  <!--SE RELLENA UNA RESEÑA -->
                  <label class="form-label">Comentario</label>
                  <input type="text" name="msg" required>

                  <!-- DATOS ADICIONALES - OCULTOS -->
                  <input type="hidden" name="user_email" value="{{auth()->user()->email}}">
                  <input type="hidden" name="ruc_hotel" value="{{ $hotel->id }}">
                
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Comentar</button>
            </div>
          @endif
        @endauth
        </form>
      </div>
    </div>
  </div>



<!-- SCRIPT QUE SE DEBEN CARGAR 1RO -->

    <!-- SISTEMA DE FECAHAS -->
    <script>
      // CALENDARIO DE DOBLE FECHA
      $(function() {
          $('input[name="datefilter"]').daterangepicker({
              autoUpdateInput: false,
              locale: {cancelLabel: 'Clear'},
              isInvalidDate: function(date) {
                  // Array de fechas bloqueadas
                  var blockedDates = [
                      '2023-06-25',
                      '2023-06-28',
                      '2023-06-30'
                  ];
    
                  // Verificar si la fecha está en el array de fechas bloqueadas
                  var formattedDate = date.format('YYYY-MM-DD');
                  return blockedDates.includes(formattedDate);
              }   
          });
          
          $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
              $('input[name="inicio"]').val(picker.startDate.format('MM/DD/YYYY'));
              $('input[name="final"]').val(picker.endDate.format('MM/DD/YYYY'));
          });
          
          $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
              $('input[name="inicio"]').val('');
              $('input[name="final"]').val('');
          });
      });
    </script>

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
</body>

</html>
