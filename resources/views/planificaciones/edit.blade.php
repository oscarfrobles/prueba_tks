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
               <th scope="col">Valoración</th>
               @if ($planificaciones->status == 1 && $planificaciones->user_id == Auth::user()->id )
                  <th scope="col"> Finalizar job </th>
               @endif
            </tr>
         </thead>
         <tbody>
               
         <tr>        
           <td> {{ $planificaciones->id }} </td>
           <td> {{ $planificaciones->name }}  </td>
           <td> 
              @if (($planificaciones->status == 1 && $planificaciones->user_id != Auth::user()->id) || $planificaciones->status == 2 )
                   {{ $planificaciones->dt_job }}
              @else
                  <input type='text' id='datetimepicker' value="{{ ($planificaciones->dt_job) ? $planificaciones->dt_job : ''}}">
               @endif
            </td>
            <td>  @if ($planificaciones->status == 2 ) 
                  <span class="verde">Job Completo</span> 
                  @elseif ($planificaciones->status == 1) 
                  <span class="naranja">Asignado</span>
                  @else
                  <span class="azul">Por asignar</span>
                  @endif 
            </td>
            <td>
                  @if ($planificaciones->status == 2 ) 
                     {{ $planificaciones->txt_valoraciones }}
                  @else
                     <textarea id="txt_valoraciones_visible">{{ $planificaciones->txt_valoraciones }}</textarea>
                  @endif
            </td>
           @if ($planificaciones->status == 1 && $planificaciones->user_id == Auth::user()->id )
                  <td> Check para finalizar <input type="checkbox" onclick="$('#status').val(2);">  </td>
           @endif
         </tr>                       
     
         </tbody>
            </table>
    @else
       <p> No se han encontrado planificaciones <a href="/planificaciones/create">¿Crear?</a> </p>
    @endif
      </div>
   </div>

   @if ($planificaciones->status < 2 && ($planificaciones->user_id == Auth::user()->id || is_null($planificaciones->user_id)) )
      <div class="row">         
            <div class="col-12">
                  <form id="update_planificacion-form"  method="POST" action="/planificaciones/update">
                     {{ csrf_field() }}   
                     <input type="hidden" name="id" value="{{ $planificaciones->id }}"/>   
                     <input type="hidden" id="dt_job" name="dt_job"/>   
                     <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
                     <input type="hidden" id="status" name="status" value="1"/>   
                     <input type='hidden' name="valoracion" value="{{ $planificaciones->valoracion_id }}"/> 
                     <input type='hidden' id="txt_valoraciones" name="txt_valoraciones"/>
                     <input type="button" id="btn_update_planificacion" value="Actualizar" />
                  </form> 
            </div>
      </div>
   @endif

  

   <script type="text/javascript">
          $(document).ready(function(){
              $('#datetimepicker').datetimepicker({
                  format: 'YYYY-MM-DD HH:mm:ss',
                  //locale: moment.locale('es_ES'),
              });
              $("#btn_update_planificacion").on("click", function(e){
               e.preventDefault(); 
               $('#dt_job').val($('#datetimepicker').val()); 
               
               if($('#txt_valoraciones_visible').val().length > 0){
                  $('#txt_valoraciones').val($('#txt_valoraciones_visible').val());
               }
               else{
                  $('#txt_valoraciones').remove();
               }
               $('#update_planificacion-form').submit();
              });
          });
  </script> 


@endsection