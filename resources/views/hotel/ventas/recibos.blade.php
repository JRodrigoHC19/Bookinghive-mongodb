
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Booking Hive</title> 

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


</head>
<body>
    
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

        <!-- CRUD HABITACION -->
        @auth
            @if (auth()->user()->rol == 'M')
            <label class="form-label">Registrar Habitacion</label>
            <form action="{{ route('registrar-habitacion') }}" method="get">
                
                <label class="form-label">N° HABITACION</label>
                <input type="number" name="id_hab">
                
                <label class="form-label">PISO</label>
                <input type="number" name="piso">
                
                <label class="form-label">PRECIO</label>
                <input type="number" name="precio">
                
                <label class="form-label">CAPACIDAD</label>
                <input type="number" name="capac">

                <label class="form-label">TIPO</label>
                <select class="form-select" name="tipo" id="tipo">
                        <option value="I">Individual</option>
                        <option value="D">Doble</option>
                        <option value="F">Familiar</option>
                        <option value="M">Matrimonial</option>
                        <option value="K">King</option>
                </select>

                <input type="text" name="hotel" value="{{ Hotel::getRuc(auth()->user()->email)}}" hidden>

                <input type="submit" value="Añadir">
            </form>
            


            <!-- TABLA DE HABITACIONES -->
            <label class="form-label">Habitaciones Registradas</label>
            @php $x = 1 @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">N° de Habitación</th>
                        <th scope="col">Piso</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Capacidad</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($habitaciones_hotel as $elemento)
                        <tr>
                            <th scope="row">{{ $x }}</th>
                            <td>{{ $elemento->id_hab }}</td>
                            <td>{{ $elemento->piso }}</td>
                            <td>{{ $elemento->precio }}</td>
                            <td>{{ $elemento->capacidad }}</td>
                            <td>{{ $elemento->tipo }}</td>
                            <td>{{ $elemento->estado }}</td>
                            <td class="btn btn-primary">Borrar</td>
                        </tr>
                        @php $x += 1 @endphp
                    @endforeach
                </tbody>
            </table>
            @endif
        @endauth


        
        @auth
            @if (auth()->user()->rol == 'M')
                <!-- PENDIENTES -->
                <label class="form-label">Reservaciones Pendientes</label>
                @php $x = 1 @endphp
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código de Habitación</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Fecha Inicial</th>
                        <th scope="col">Fecha Final</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Codigo de Validación</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaciones_hotel_P as $elemento)
                            <tr>
                                <th scope="row">{{ $x }}</th>
                                <td>{{ $elemento->id_hab }}</td>
                                <td>{{ $elemento->email_cli }}</td>
                                <td>{{ $elemento->inicio }}</td>
                                <td>{{ $elemento->final }}</td>
                                <td>{{ $elemento->created_at }}</td>
                                <td>{{ $elemento->codigo }}</td>
                                <td class="btn btn-primary">Mostrar más detalles</td>
                            </tr>
                            @php $x += 1 @endphp
                        @endforeach
                    </tbody>
                </table>

                <!-- VENCIDOS -->
                <label class="form-label">Reservaciones Vencidas</label>
                @php $x = 1 @endphp
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código de Habitación</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Fecha Inicial</th>
                        <th scope="col">Fecha Final</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Codigo de Validación</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaciones_hotel_V as $elemento)
                            <tr>
                                <th scope="row">{{ $x }}</th>
                                <td>{{ $elemento->id_hab }}</td>
                                <td>{{ $elemento->email_cli }}</td>
                                <td>{{ $elemento->inicio }}</td>
                                <td>{{ $elemento->final }}</td>
                                <td>{{ $elemento->created_at }}</td>
                                <td>{{ $elemento->codigo }}</td>
                                <td class="btn btn-primary">Mostrar más detalles</td>
                            </tr>
                            @php $x += 1 @endphp
                        @endforeach
                    </tbody>
                </table>

                <!-- CANCELADOS -->
                <label class="form-label">Reservaciones Confirmadas</label>
                @php $x = 1 @endphp
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código de Habitación</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Fecha Inicial</th>
                        <th scope="col">Fecha Final</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Codigo de Validación</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaciones_hotel_C as $elemento)
                            <tr>
                                <th scope="row">{{ $x }}</th>
                                <td>{{ $elemento->id_hab }}</td>
                                <td>{{ $elemento->email_cli }}</td>
                                <td>{{ $elemento->inicio }}</td>
                                <td>{{ $elemento->final }}</td>
                                <td>{{ $elemento->created_at }}</td>
                                <td>{{ $elemento->codigo }}</td>
                                <td class="btn btn-primary">Mostrar más detalles</td>
                            </tr>
                            @php $x += 1 @endphp
                        @endforeach
                    </tbody>
                </table>

                <!-- ANULADOS -->
                <label class="form-label">Reservaciones Anuladas</label>
                @php $x = 1 @endphp
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código de Habitación</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Fecha Inicial</th>
                        <th scope="col">Fecha Final</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Codigo de Validación</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaciones_hotel_A as $elemento)
                            <tr>
                                <th scope="row">{{ $x }}</th>
                                <td>{{ $elemento->id_hab }}</td>
                                <td>{{ $elemento->email_cli }}</td>
                                <td>{{ $elemento->inicio }}</td>
                                <td>{{ $elemento->final }}</td>
                                <td>{{ $elemento->created_at }}</td>
                                <td>{{ $elemento->codigo }}</td>
                                <td class="btn btn-primary">Mostrar más detalles</td>
                            </tr>
                            @php $x += 1 @endphp
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endauth

        @auth
            @if (auth()->user()->rol == 'R')
                <!-- PENDIENTES -->
                <label class="form-label">Reservaciones Pendientes</label>
                @php $x = 1 @endphp
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código de Habitación</th>
                        <th scope="col">Fecha Inicial</th>
                        <th scope="col">Fecha Final</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Codigo de Validación</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaciones_usuario_P as $elemento)
                            <tr>
                                <th scope="row">{{ $x }}</th>
                                <td>{{ $elemento->id_hab }}</td>
                                <td>{{ $elemento->inicio }}</td>
                                <td>{{ $elemento->final }}</td>
                                <td>{{ $elemento->created_at }}</td>
                                <td>{{ $elemento->codigo }}</td>
                                <td class="btn btn-primary">Mostrar más detalles</td>
                            </tr>
                            @php $x += 1 @endphp
                        @endforeach
                    </tbody>
                </table>

                <!-- VENCIDOS -->
                <label class="form-label">Reservaciones Vencidas</label>
                @php $x = 1 @endphp
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código de Habitación</th>
                        <th scope="col">Fecha Inicial</th>
                        <th scope="col">Fecha Final</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Codigo de Validación</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaciones_usuario_V as $elemento)
                            <tr>
                                <th scope="row">{{ $x }}</th>
                                <td>{{ $elemento->id_hab }}</td>
                                <td>{{ $elemento->inicio }}</td>
                                <td>{{ $elemento->final }}</td>
                                <td>{{ $elemento->created_at }}</td>
                                <td>{{ $elemento->codigo }}</td>
                                <td class="btn btn-primary">Mostrar más detalles</td>
                            </tr>
                            @php $x += 1 @endphp
                        @endforeach
                    </tbody>
                </table>

                <!-- CANCELADOS -->
                <label class="form-label">Reservaciones Confirmadas</label>
                @php $x = 1 @endphp
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código de Habitación</th>
                        <th scope="col">Fecha Inicial</th>
                        <th scope="col">Fecha Final</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Codigo de Validación</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaciones_usuario_C as $elemento)
                            <tr>
                                <th scope="row">{{ $x }}</th>
                                <td>{{ $elemento->id_hab }}</td>
                                <td>{{ $elemento->inicio }}</td>
                                <td>{{ $elemento->final }}</td>
                                <td>{{ $elemento->created_at }}</td>
                                <td>{{ $elemento->codigo }}</td>
                                <td class="btn btn-primary">Mostrar más detalles</td>
                            </tr>
                            @php $x += 1 @endphp
                        @endforeach
                    </tbody>
                </table>

                <!-- ANULADOS -->
                <label class="form-label">Reservaciones Anuladas</label>
                @php $x = 1 @endphp
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código de Habitación</th>
                        <th scope="col">Fecha Inicial</th>
                        <th scope="col">Fecha Final</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Codigo de Validación</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaciones_usuario_A as $elemento)
                            <tr>
                                <th scope="row">{{ $x }}</th>
                                <td>{{ $elemento->id_hab }}</td>
                                <td>{{ $elemento->inicio }}</td>
                                <td>{{ $elemento->final }}</td>
                                <td>{{ $elemento->created_at }}</td>
                                <td>{{ $elemento->codigo }}</td>
                                <td class="btn btn-primary">Mostrar más detalles</td>
                            </tr>
                            @php $x += 1 @endphp
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endauth
        
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
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->

    <!-- PARA LAS NOTIFICACIOENS -->
    <!-- <script src="sweetalert2/dist/weetalert2.all.min.js"></script> -->
</body>
</html>