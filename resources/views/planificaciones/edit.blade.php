@extends('layout')

@section('content')

@if(Session::has('notice'))
<div class="row">
      <div class="col-12">
<p> <strong> {{ Session::get('notice') }} </strong> </p>
      </div>
</div>
@endif

      <div class="row">
         <div class="col-12">
    @if($planificaciones->count())
          <table class="table">
               <thead>
             <tr>
               <th scope="col"> Id </th>
               <th scope="col"> Usuario </th>
               <th scope="col"> Fecha </th>
               <th scope="col"> Estado </th>
            </tr>
         </thead>
         <tbody>
               
         <tr>        
           <td> {{ $planificaciones->id }} </td>
           <td> {{ Auth::user()->name }}  </td>
           <td> 
              @if ($planificaciones->status > 0 )
                   {{ $planificaciones->dt_job }} 
                @else
                  <input type='text' id='datetimepicker'>
               @endif
            </td>
           <td> {{ ($planificaciones->status == 2 ) ? 'Completado el trabajo': ($planificaciones->status == 1) ? 'Asignado' : 'Por asignar' }} </td>  
         </tr>                       
     
         </tbody>
            </table>
    @else
       <p> No se han encontrado planificaciones <a href="/planificaciones/create">¿Crear?</a> </p>
    @endif
      </div>
   </div>

   <div class="row">         
         <div class="col-12">
               <form id="update_planificacion-form"  method="POST" action="/planificaciones/update">
                  {{ csrf_field() }}   
                  <input type="hidden" name="id" value="{{ $planificaciones->id }}"/>   
                  <input type="hidden" id="dt_job" name="dt_job"/>   
                  <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
                  <input type="hidden" name="status" value="1"/>    
                  <input type="button" id="btn_update_planificacion" value="Actualizar" />
               </form> 
         </div>
   </div>

  

   <script type="text/javascript">
          $(document).ready(function(){
              $('#datetimepicker').datetimepicker({
                  format: 'YYYY-MM-DD HH:mm:ss',
                  //locale: moment.locale('es_ES'),
              });
              $("#btn_update_planificacion").on("click", function(e){
               e.preventDefault(); 
               $('#dt_job').val($('#datetimepicker').val()); 
               $('#update_planificacion-form').submit();
              });
          });
  </script> 


@endsection