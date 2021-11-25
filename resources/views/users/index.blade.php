@extends('layout')

@section('content')

      <div class="row">
         <div class="col-12">
    @if($users->count())
          <table class="table table-responsive table-hover">
               <thead>
             <tr>
               <th scope="col"> Nombre </th>
               <th scope="col"> Email </th>
               <th scope="col"> Timezone </th>
            </tr>
         </thead>
         <tbody>
          @foreach($users as $item)     
             <tr>        
               <td> {{ $item->name }} </td>
               <td> {{ $item->email }} </td>
               <td> {{ $item->timezone }} </td>    
             </tr>                       
          @endforeach
         </tbody>
            </table>
    @else
       <p> No se han encontrado usuarios </p>
    @endif
      </div>
   </div>


@endsection