@extends('layout')

@section('content')   

<div class="container">
        <div class="row">
                <div class="col-12">
            @guest
            Debes conectar primero para poder crear una planificación
            @else
            <form  method="POST" action="/planificaciones/store">
                {{ csrf_field() }}
                
                        <input type="submit" value="Crear planificación" />
                   
            </form>
            @endguest
        </div>
    </div>
@endsection
