@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif


@php use App\Models\Hotel @endphp


<!-- MUESTRA LOS HOTELES RECOMENDADOS - SEGÚN SUS GUSTOS -->





<!-- LO QUE SE DEBE MOSTRAR -->

<h1>Lista de Hoteles Registros</h1>

<div class="container">
    <div class="row">
    @foreach ($hoteles_full as $hotelito)
        <div class="col-4 py-3">
            <div class="card">
                <div class="card-header">{{ $hotelito->titulo }}</div>
                <img src="{{ asset('fotos/'.'portada00.webp') }}" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $hotelito->email }}</h5>
                    <p class="card-text">Nos especializamos en mostrar al cliente todo tipo de habitaciones.</p>
                    
                    <!-- BOTÓN - QUE ENVIA - ID DE USUARIO E RUC DE HOTEL --> 
                    <a class="btn btn-primary" href="{{ route('hotel',['id_user' => auth()->user()->id, 'ruc_hotel' => $hotelito->_id]) }}">Mostrar más</a>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>


@endsection
