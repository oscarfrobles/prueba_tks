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
                 <th scope="col"> Autoasignármela </th>
              </tr>
           </thead>
           <tbody>
            @foreach($planificaciones as $item)   
               <tr>        
                 <td> {{ $item->id }} </td>
                 <td> {{ ($item->user_id != NULL) ? $item->user_id : 'No asignado' }}  </td>
                 <td> {{ (!is_null($item->dt_job)) ? $item->dt_job : 'No asignada' }} </td> 
                 <td>
                     @if ($item->status == 0 ) 
                        <a href="/planificaciones/{{ $item->id }}/edit">Editar para {{ Auth::user()->name }}</a>
                     @else 
                        ASIGNADO <a href="/planificaciones/{{ $item->id }}/edit">Ver</a>
                     @endif
                 </td>  
               </tr>                       
            @endforeach
           </tbody>
              </table>    
         </div>
      </div>
      <div class="row">
            <div class="col-12"><a onclick="event.preventDefault(); document.getElementById('create_planificacion-form').submit();" href="#">Nueva planificación</a></div>
      </div>
      @else
      <div class="row">
            <div class="col-12">
               <p> No se han encontrado planificaciones <a onclick="event.preventDefault(); document.getElementById('create_planificacion-form').submit();" href="#">¿Crear?</a> </p>
            </div>
      </div>
      @endif 
   
   @endguest
      

  

   <form id="create_planificacion-form"  method="POST" action="/planificaciones/store">
      {{ csrf_field() }}              
   </form> 


@endsection