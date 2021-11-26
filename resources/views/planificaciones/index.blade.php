@extends('layout')

@section('content')

@if(Session::has('notice'))
<div class="row">
      <div class="col-12">
<p> <strong> {{ Session::get('notice') }} </strong> </p>
      </div>
</div>
@endif

      Uso horario: {{ Helpers::getUserTimeZone() }}

      <div class="row">
         <div class="col-12">
            @guest
            <p> Debes hacer login para acceder a las planificaciones </p>
              
            @else
            @if($planificaciones->count())
            <table class="table">
                 <thead>
               <tr>
                 <th scope="col"> Id </th>
                 <th scope="col"> Usuario asignado </th>
                 <th scope="col"> Fecha </th>
                 <th scope="col"> Estado </th>
                 <th scope="col"> Autoasignarla </th>
                 <th scope="col">Eliminar</th>
              </tr>
           </thead>
           <tbody>
            @foreach($planificaciones as $item)   
               <tr>        
                 <td> {{ $item->id }} </td>
                 <td> {{ ($item->user_id != NULL) ? $item->user_id : 'No asignado' }}  </td>
                 <td> {{ (!is_null($item->dt_job)) ? $item->dt_job : 'No asignada' }} </td> 
                 <td>  @if ($item->status == 2 ) 
                        <span class="verde">Job Completo</span> 
                        @elseif ($item->status == 1) 
                        <span class="naranja">Asignado</span>
                        @else
                        <span class="azul">Por asignar</span>
                        @endif 
                  </td>
                 <td>
                     @if ($item->status == 0 ) 
                        <a href="/planificaciones/{{ $item->id }}/edit">Editar para {{ Auth::user()->name }}</a>
                     @else 
                        <a href="/planificaciones/{{ $item->id }}/edit">Ver</a>
                     @endif
                 </td>  
                 <td>                  
                     @if (strtoupper(Auth::user()->name) == 'ADMIN')
                     <a href="#" onclick="event.preventDefault; $('#delete-id').val('{{ $item->id }}'); $('#delete_planificacion-form').submit();">Eliminar</a>
                     
                     @else
                        X
                     @endif
                 </td>
               </tr>                       
            @endforeach
           </tbody>
              </table>    
         </div>
      </div>
      <div class="row">
            <div class="col-12">
               @if (strtoupper(Auth::user()->name) == 'ADMIN')
                  <a onclick="event.preventDefault(); document.getElementById('create_planificacion-form').submit();" href="#">Nueva planificación</a>
               @endif
            </div>
      </div>
      @else
      <div class="row">
            <div class="col-12">
               <p> No se han encontrado planificaciones 
                  @if (strtoupper(Auth::user()->name) == 'ADMIN')
                     <a onclick="event.preventDefault(); document.getElementById('create_planificacion-form').submit();" href="#">¿Crear?</a> </p>
                  @endif
            </div>
      </div>
      @endif 
   
   @endguest
      

  

   <form id="create_planificacion-form"  method="POST" action="/planificaciones/store">
      {{ csrf_field() }}              
   </form> 

   <form id="delete_planificacion-form" action="/planificaciones/destroy" method="POST">
      {{ csrf_field() }} 
    <input id="delete-id" type="hidden" name="id" value="">
   </form>


@endsection