<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planificaciones;
use App\Models\Valoraciones;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Auth;



/**
* @OA\Info(title="API Planificaciones", version="1.0")
*
* @OA\Server(url="http://127.0.0.1:8000")
*/
class ApiController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/planificaciones",
    *     summary="Mostrar todas las planificaciones",
    *     @OA\Response(
    *         response=200,
    *         description="Mostrar todas las planificaciones."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function index(Request $request)
    {
        $planificaciones = Planificaciones::leftJoin('users', 'users.id', '=', 'planificaciones.user_id')
                                            ->leftJoin('valoraciones', 'valoraciones.id', '=', 'planificaciones.valoracion_id')
                                            ->get(['planificaciones.*', 'users.name', 'valoraciones.txt_value']);
        return $planificaciones;
    }

    /**
    * @OA\Post(
    *     path="/api/planificaciones",
    *     summary="Crear planificación",
    *     @OA\Response(
    *         response=200,
    *         description="Crear planificación."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function store(Request $request)
    {
        $data = request()->all();
        $planificaciones = Planificaciones::create([
            'status' => '0',
        ]);
        return $planificaciones;
    }

    /**
    * @OA\Get(
    *     path="/api/planificaciones/{id}",
    *     summary="Mostrar planificación con id",
    *      @OA\Parameter(
    *          name="id",
    *          description="Planificación id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *     @OA\Response(
    *         response=200,
    *         description="Mostrar planificación con id."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function show(Request $request)
    {
        $no_res = ['message' => 'No hay resultados para el id seleccionado'];
        $planificaciones = Planificaciones::leftJoin('users', 'users.id', '=', 'planificaciones.user_id')
                                            ->leftJoin('valoraciones', 'valoraciones.id', '=', 'planificaciones.valoracion_id')
                                            ->get(['planificaciones.*', 'users.name', 'valoraciones.txt_value'])->find($request->id);
        $res = (is_null($planificaciones)) ? $no_res : $planificaciones;
        return $res;
    }

    /**
     * Update the specified resource in storage. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $no_id = 'No existe id';
        $err_dt_job = 'Es necesario un atributo dt_job con valor de datetime en formato YYYY-mm-dd HH:mm:ss';
        $data = request()->all();
        
        if(!is_numeric($id)){
            return ['message' => $no_id];
        }
        if(isset($data['valoracion'])){
            $valoraciones = Valoraciones::create([
                'txt_value' => $data['valoracion'],
            ]);
            $data['valoracion_id'] = $valoraciones->id;
        }
        
        date_default_timezone_set(Helpers::getUserTimeZone());
        if(!isset($data['dt_job'])){
            return ['message' => $err_dt_job];
        }
        try{
            $dt_job = strtotime($data['dt_job']);
            $data['dt_job'] = Carbon::parse($dt_job, 'UTC')->setTimezone('UTC')->format('Y-m-d H:i:s');
            $planificacion = Planificaciones::find( $id );
            $planificacion->update($data);
        }
        catch(Exception $e){
            echo $e;
        }
        return $planificacion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $no_res = 'No hay resultados para el id %s seleccionado';
        $res    = 'Planificacion %s borrada';
        //return ['message' => $request->id];
        $planificaciones = Planificaciones::leftJoin('users', 'users.id', '=', 'planificaciones.user_id')
                                            ->get(['planificaciones.*', 'users.name'])->find($request->id);
        
        if(is_null($planificaciones)){
            $res = ['message' => sprintf($no_res, $request->id)];
        }   
        else{
            try{
                $delete = $planificaciones->delete();
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
            $res = ['message' => sprintf($res, $request->id)];
        }                                      
        return $res;
    }
}
