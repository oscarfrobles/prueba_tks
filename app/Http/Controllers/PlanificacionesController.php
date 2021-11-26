<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planificaciones;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Helpers\Helpers;

class PlanificacionesController extends Controller
{
    public function index(){
        $planificaciones = Planificaciones::leftJoin('users', 'users.id', '=', 'planificaciones.user_id')
                                            ->get(['planificaciones.*', 'users.name']);
        return view('planificaciones.index')->with('planificaciones', $planificaciones);
    }

    public function create(){
        $planificaciones = new Planificaciones();
        return view('planificaciones.create')->with('planificaciones', $planificaciones);
    }

    public function show($id){
        $id = (integer) $id;
        $cod = 200;
        $headers = [];
        $resp = [];
        try{
            $id = Planificaciones::find($id);
            if(strtoupper($id) == NULL){
                $resp = ['response' => 'No existe esta planificación']; 
            }
        }
        catch (Throwable $t){
            $resp = ['error' => $t];
            $cod = 404;            
        }
        return response()->json($resp, $cod, $headers); 
    }

    public function store(){
        $data = request()->all();
        Planificaciones::create([
            'state' => false,
        ]);
        return  Redirect::to('planificaciones/')->with('notice', 'La planificación ha sido creada');
    }

    public function edit($id){
        $id = (integer) $id;
        $planificaciones = Planificaciones::leftJoin('users', 'users.id', '=', 'planificaciones.user_id')
                                            ->get(['planificaciones.*', 'users.name'])
                                            ->find($id);
        return view('planificaciones.edit')->with('planificaciones', $planificaciones);
    }

    public function update(){
        $data = request()->all();
        $id = (integer) $data['id'];
        date_default_timezone_set(Helpers::getUserTimeZone());
        $dt_job = strtotime($data['dt_job']);
        $data['dt_job'] = Carbon::parse($dt_job, 'UTC')->setTimezone('UTC')->format('Y-m-d H:i:s');
        $planificacion = Planificaciones::find( $id );
        $planificacion->update($data);
        return Redirect::to('planificaciones/')->with('notice', 'La planificación '.$id.' ha sido actualizada');
    }

    public function destroy()
    {
        $data = request()->all();
        $id = (integer) $data['id'];        
        $planificacion = Planificaciones::find( $id );
        $planificacion->delete();    
        return Redirect::to('planificaciones/')->with('notice', 'La planificación con id '. $id .' ha sido borrada');
    }
}
