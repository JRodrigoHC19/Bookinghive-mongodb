<!-- NOMBRE DE TABLA -->
<div class='container-fluid'>
    <div class="row align-item-start">
        <div class="col fs-1">Lista de Usuarios
        </div>
    </div>
</div>

<!-- TABLA -->
<div class="p-4">
    <table class="table table-striped">
        <thead>
            <tr class="card-header">
                <th scope="col">#</th> <th scope="col">ID</th>  <th scope="col">Nombre de Usuario</th> <th scope="col">Correo Electrónico</th> <th scope="col">País</th> <th scope="col">Creado en</th> <th scope="col">Actualizado en</th> <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            
            @php use App\Models\Persona; $contador = 1; @endphp
            @foreach ($usuarios as $filas1)
                <tr>
                    <td scope="row">{{ $contador }}</td>
                    <td  > {{ $filas1->id }} </td> <td> {{ $filas1->name }} </td> <td> {{ $filas1->email }} </td> <td> {{ Persona::getPais($filas1->email); }} </td> <td> {{ $filas1->created_at }} </td> <td> {{ $filas1->updated_at }} </td>
                
                    <td><a href="#"><button class="btn btn btn-outline-danger btn-sm" ><i class="bi bi-trash3"></i></button></a></td>
                    @php $contador += 1 @endphp
                </tr>
            @endforeach

        </tbody>

        
    </table>
</div>