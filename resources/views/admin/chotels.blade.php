

<!-- HEADER DE TABLA -->
<div class='container-fluid'>
    <div class="row align-item-start">
        <div class="col fs-1">Lista de Hoteles
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Registrar</button>
        </div>
    </div>
</div>

<!-- CONTENIDO DE LA TABLA -->
<div class="p-4">
    <table class="table table-striped">
        <thead>
            <tr class="card-header">
                <th scope="col">#</th> <th scope="col">RUC</th>  <th scope="col">Nombre de Usuario</th> <th scope="col">Correo Electrónico</th>  <th scope="col">País</th> <th scope="col">Ciudad</th> <th scope="col">Creado en</th> <th scope="col">Actualizado en</th> <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            
            @php use App\Models\Hotel; $contador = 1; @endphp
            
            @foreach ($hoteles as $filas)
                <tr>
                    <td scope="row">{{ $contador }}</td>
                    <td> {{ Hotel::getRuc($filas->email) }} </td> <td> {{ $filas->name}} </td> <td> {{ Hotel::getEmail($filas->email); }} </td> <td> {{ Hotel::getPais($filas->email) }} </td> <td> {{ Hotel::getCiudad($filas->email) }} </td> <td> {{ $filas->created_at }} </td> <td>{{ $filas->updated_at }}</td>

                    <td><a href="#"><button class="btn btn btn-outline-danger btn-sm" ><i class="bi bi-trash3"></i></button></a></td>
                    @php $contador += 1 @endphp
                </tr>
                
                <?php //$nro_indice = $nro_indice + 1;?>
                
            @endforeach

            
        </tbody>

        
    </table>
</div>



<!-- VENTANAS EMERGENTES -->
    
    <!-- REGISTRAR HOTEL -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                
                <div class="modal-content">

                    <!-- BOTONES -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Registrar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- FORMULARIO -->
                    <div class="modal-body">
                        <form class="row g-3" action="{{ Route('registrar_hot') }}" method="POST">
                            @csrf
                            <!-- RUC -->
                            <div class="mb-3">
                                <label for="RUC" class="form-label">RUC del Hotel</label>
                                <input type="text" class="form-control" id="RUC" name="id" required>
                            </div>

                            <!-- TITULO -->
                            <div class="col-md-6">
                                <label for="TITULO" class="form-label">Nombre Oficial del Hotel</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                    <input type="text" class="form-control" aria-describedby="inputGroupPrepend" id="TITULO" name="name" required>
                                </div>
                            </div>

                            <!-- ROL -->
                            <div class="col-md-6">
                                <label class="form-label">Rol</label>
                                <select name="rol" class="form-select" aria-label="Disabled select example" disabled>
                                    <option value="M" selected>Hotel</option>
                                </select>
                            </div>

                            <!-- CORREO -->
                            <div class="col-md-6">
                                <label for="EMAIL" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="EMAIL" placeholder="test@example.com" name="email" required>
                            </div>

                            <!-- CONTRASEÑA -->
                            <div class="col-md-6">
                                <label for="PASSWORD" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="PASSWORD" name="password" required>
                            </div>

                            <!-- TIPO -->
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label">TIPOS</label>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="hidden" value="0" name="A">
                                            <input class="form-check-input" type="checkbox" value="1" id="Ax" name="A">
                                            <label class="form-check-label" for="Ax">Aeropuerto</label>
                                            
                                        </div>
                                        
                                        <div class="form-check">
                                            <input type="hidden" value="0" name="F">
                                            <input class="form-check-input" type="checkbox" value="1" id="Fx" name="F">
                                            <label class="form-check-label" for="Fx">Familiar</label>
                                            
                                        </div>

                                        <div class="form-check">
                                            <input type="hidden" value="0" name="C">
                                            <input class="form-check-input" type="checkbox" value="1" id="Cx" name="C" >
                                            <label class="form-check-label" for="Cx">Casino</label>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="hidden" value="0" name="D">
                                            <input class="form-check-input" type="checkbox" value="1" id="Dx" name="D" >
                                            <label class="form-check-label" for="Dx">Deportivo</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="hidden" value="0" name="P">
                                            <input class="form-check-input" type="checkbox" value="1" id="Px" name="P" >
                                            <label class="form-check-label" for="Px">Playa</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="hidden" value="0" name="B">
                                            <input class="form-check-input" type="checkbox" value="1" id="Bx" name="B" >
                                            <label class="form-check-label" for="Bx">Balneario</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="hidden" value="0" name="N">
                                            <input class="form-check-input" type="checkbox" value="1" id="Nx" name="N" >
                                            <label class="form-check-label" for="Nx">Naturaleza</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="hidden" value="0" name="R">
                                            <input class="form-check-input" type="checkbox" value="1" id="Rx" name="R" >
                                            <label class="form-check-label" for="Rx">Rústico</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="hidden" value="0" name="T">
                                            <input class="form-check-input" type="checkbox" value="1" id="Tx" name="T" >
                                            <label class="form-check-label" for="Tx">Turístico</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RUC -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="telefono1" class="form-label"> Telefono 1</label>
                                        <input type="number" class="form-control" id="telefono1" name="telefono1" required>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="hidden" value="0" name="telefono2">
                                        <label for="telefono2" class="form-label"> Telefono 2 (opcional)</label>
                                        <input type="number" class="form-control" id="telefono2" name="telefono2">
                                    </div>
                                </div>
                            </div>

                            <!-- PAIS - CIUDAD - DIRECCION -->
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <div class="input-group">
                                    
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
                                            <option value="{{ $pais }}" @if ($pais == Hotel::getPais(auth()->user()->email) ) selected @endif>{{ $pais }}</option>
                                        @endforeach
                                    </select>

                                    <input type="text" class="form-control" placeholder="Indique su ciudad" name="ciudad" required>

                                    <input type="text" class="form-control" placeholder="1234 Main St" name="direccion" required>

                                </div>
                            </div>

                            <!-- BOTON ENVIAR - CANCELAR -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <input type="submit" class="btn btn-primary" value="Crear Cuenta">
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>

