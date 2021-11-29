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
* @OA\Server(url="/")
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
                                            ->get(['planificaciones.*', 'users.name', 'valoraciones.txt_valoraciones']);
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
    *     ),
    *      @OA\Response(
    *          response=419,
    *          description="Unauthenticated",
    *      ),
    * )
    */
    public function store(Request $request)
    {
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
    *      @OA\Parameter(
    *          name="user_id",
    *          description="Id de usuario 1 Admin, 2 Oscar[Madrid], 3 John Smith[London], 4 Vinicio del Pozo [Mexico_City]",
    *          required=false,
    *          in="query",
    *          @OA\Schema(
    *              type="string",
    *              enum={"1", "2", "3", "4"},
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
        if(isset($request->user_id)){
            $user_timezone = Helpers::getUserTimeZoneFromId($request->user_id);
            $tm = date_default_timezone_set($user_timezone);
        }
        $no_res = ['message' => 'No hay resultados para el id seleccionado'];
        $planificaciones = Planificaciones::leftJoin('users', 'users.id', '=', 'planificaciones.user_id')
                                            ->leftJoin('valoraciones', 'valoraciones.id', '=', 'planificaciones.valoracion_id')
                                            ->get(['planificaciones.*', 'users.name', 'valoraciones.txt_valoraciones'])->find($request->id);
        $res = (is_null($planificaciones)) ? $no_res : $planificaciones;
        return $res;
    }

    /**
    * @OA\Put(
    *     path="/api/planificaciones/{id}",
    *     summary="Modificar planificación con id",
    *     @OA\Response(
    *         response=200,
    *         description="Actualizar planificación."
    *     ),
    *     @OA\Parameter(
    *          name="id",
    *          description="Planificación id",
    *          required=true,
    *          in="query",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *     @OA\Parameter(
    *          name="status",
    *          description="Status planificación 0 [Creación], 1 [Asignación] ó 2 [Finalizada]",
    *          required=false,
    *          in="query",
    *          @OA\Schema(
    *              type="string",
    *              enum={"0", "1", "2"},
    *          )
    *      ),
    *     @OA\Parameter(
    *          name="dt_job",
    *          description="Datetime con formato YYYY-mm-dd HH:mm:ss",
    *          required=false,
    *          in="query",
    *          @OA\Schema(
    *              type="string",
    *              format="date-time",
    *          )
    *      ),
     *     @OA\Parameter(
    *          name="valoracion",
    *          description="String de valoración",
    *          required=false,
    *          in="query",
    *          @OA\Schema(
    *              type="String"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="user_id",
    *          description="Id de usuario 1 Admin, 2 Oscar[Madrid], 3 John Smith[London], 4 Vinicio del Pozo [Mexico_City]",
    *          required=true,
    *          in="query",
    *          @OA\Schema(
    *              type="string",
    *              enum={"1", "2", "3", "4"},
    *          )
    *      ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *      ),
    *     @OA\Response(
    *          response=419,
    *          description="Unauthenticated",
    *      ),
    * )
    */
    public function update(Request $request)
    {        
        $planificacion_id = $request->id;
        //return ['message' => $request->dt_job];
        $no_id = 'No es posible actualizar sin id de planificación y sin estar conectado';
        $no_user_id = 'No existe user_id y es necesario';
        $err_dt_job = 'Es necesario un atributo dt_job con valor de datetime en formato YYYY-mm-dd HH:mm:ss';
        $data = [];

        if(!isset($request->id)){
            return ['message' => $no_id];
        }
        if(!isset($request->dt_job)){
            return ['message' => $err_dt_job];
        }
        if(!isset($request->user_id)){
            return ['message' => $no_user_id];
        }        


        $data['status'] = $request->status;
        $data['user_id']= $request->user_id;
        $user_timezone = Helpers::getUserTimeZoneFromId($request->user_id);
        $tm = date_default_timezone_set($user_timezone);

        $planificacion = Planificaciones::find( $request->id );
        $id_valoracion_old = $planificacion->valoracion_id;

        if(isset($request->valoracion)){
            $valoraciones = Valoraciones::create([
                'txt_valoraciones' => $request->valoracion,
            ]);
            $data['valoracion_id'] = $valoraciones->id;            
        }
        
        try{
           $dt_job = strtotime($request->dt_job);
           $data['dt_job'] = Carbon::parse($dt_job, 'UTC')->setTimezone('UTC')->format('Y-m-d H:i:s');           
           $planificacion->update($data);
           if(isset($data['valoracion_id'])){
                $valoracion_old = $valoraciones->find($id_valoracion_old);
                if($valoracion_old != NULL){
                    $valoracion_old->delete();
                }
           }
        }
        catch(Exception $e){
           echo $e;
        }
        return Planificaciones::find( $request->id );
    }

    /**
    * @OA\Delete(
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
    public function destroy(Request $request)
    {
        $no_res = 'No hay resultados para el id %s seleccionado';
        $res    = 'Planificacion %s borrada';
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
