@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registrar_usu') }}">
                        @csrf
                        
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Nombres</label>
                                <input type="text" class="form-control" name="nombres" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" required>
                            </div>


                            
                            <div class="col-md-4">
                                <label class="form-label">Sexo</label> 
                                    <select name="sexo" class="form-select" aria-label="Default select example" required>
                                        <option selected disabled>Indique su género</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="inputEmail4" class="form-label">País</label> 


                                    <select name="pais" class="form-select" aria-label="Default select example" required>
                                            <option disabled >Choose...</option>
                                            @php $lista = array(
                                                        "Afganistán","Albania","Alemania","Andorra","Angola","Antigua y Barbuda","Arabia Saudita","Argelia","Argentina","Armenia","Australia","Austria",
                                                        "Azerbaiyán","Bahamas","Bahrein","Bangladesh","Barbados","Belarús","Bélgica","Belice","Benin","Bhután","Bolivia","Bosnia y Herzegovina","Botswana",
                                                        "Brasil","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cabo Verde","Camboya","Camerún","Canadá","Chad","Chequia","Chile","China","Chipre","Colombia",
                                                        "Comoras","Congo","Costa Rica","Côte D'Ivoire","Croacia","Cuba","Dinamarca","Djibouti","Dominica","Ecuador","Egipto","El Salvador","Emiratos Árabes Unidos",
                                                        "Eritrea","Eslovaquia","Eslovenia","España","Estados Unidos de América","Estonia","Eswatini","Etiopía","Federación de Rusia","Fiji","Filipinas","Finlandia","Francia",
                                                        "Gabón","Gambia","Georgia","Ghana","Granada","Grecia","Guatemala","Guinea","Guinea Bissau","Guinea Ecuatorial","Guyana","Haití","Honduras","Hungría","India","Indonesia","Irán",
                                                        "Iraq","Irlanda","Islandia","Islas Marshall","Islas Salomón","Israel","Italia","Jamaica","Japón","Jordania","Kazajstán","Kenya","Kirguistán","Kiribati",
                                                        "Kuwait","Lesotho","Letonia","Líbano","Liberia","Libia","Liechtenstein","Lituania","Luxemburgo","Macedonia del Norte","Madagascar","Malasia","Malawi","Maldivas","Malí",
                                                        "Malta","Marruecos","Mauricio","Mauritania","México","Micronesia","Mónaco","Mongolia","Montenegro","Mozambique","Myanmar","Namibia","Nauru","Nepal","Nicaragua","Niger",
                                                        "Nigeria","Noruega","Nueva Zelandia","Omán","Paises","Países Bajos","Pakistán","Palau","Panamá","Papúa Nueva Guinea","Paraguay","Perú","Polonia","Portugal","Qatar",
                                                        "Reino Unido","República Árabe Siria","República Centroafricana","República de Corea","República de Moldova","República Democrática del Congo","República Democrática Popular Lao",
                                                        "República Dominicana","República Popular Democrática de Corea","República Unida de Tanzanía","Rumania","Rwanda","Saint Kitts y Nevis","Samoa","San Marino","San Vicente y las Granadinas",
                                                        "Santa Lucía","Santo Tomé y Príncipe","Senegal","Serbia","Seychelles","Sierra Leona","Singapur","Somalia","Sri Lanka","Sudáfrica","Sudán","Sudán del Sur","Suecia","Suiza",
                                                        "Suriname","Tailandia","Tayikistán","Timor-Leste","Togo","Tonga","Trinidad y Tabago","Túnez","Türkiye","Turkmenistán","Tuvalu","Ucrania","Uganda","Uruguay","Uzbekistán",
                                                        "Vanuatu","Venezuela","Viet Nam","Yemen","Zambia","Zimbabwe"
                                                        )
                                            @endphp
                                            @foreach ($lista as $pais)
                                                <option value="{{ $pais }}">{{ $pais }}</option>
                                            @endforeach
                                    </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Celular</label>
                                <input type="number" class="form-control" name="celular" required>
                            </div>


                            <div class="col-md-4">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha" required>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre de Usuario</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Correo Electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
