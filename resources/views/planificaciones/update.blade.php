@extends('layout')

@section('content')   

<div class="container">
        <div class="row">
                <div class="col-12">
            @guest
            Debes conectar primero para poder crear una planificación
            @else
            {{ var_export($planificacion) }}
            @endguest
        </div>
    </div>
@endsection
