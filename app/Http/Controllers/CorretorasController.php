<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 22/07/2018
 * Time: 14:43
 */

namespace App\Http\Controllers;

use App\Models\Corretora;
use Illuminate\Http\Request;
use App\Http\Resources\CorretoraResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class CorretorasController extends Controller
{
    /**
     * @return Papel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $showAll = Corretora::all();
        //return CorretoraResource::collection($request);
//       return $request->auth->corretora()->latest()->paginate();
        return $showAll;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $corretora = $request->auth->corretora()->find($id);
        if (!$corretora instanceof Papel) {
            return Response::json(["error"=>[
                "message"=> "Não é possível listar as Corretoras"
            ]], 404);
        }
        return Response::json($corretora, 200);
    }

    /** @return \Models\Corretora
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|unique:corretora',
        ]);

        if ($validator->fails()) {
            return array(
                'success' => false,
                'message' => $validator->errors()->all()
            );
        }

        $corretora =  new Corretora;

        $corretora->nome= $request->nome;
        $corretora->usuario_id = \Illuminate\Support\Facades\Auth::id();
        $corretora->save();

        dd($corretora);
        //return \response()->json(['success' => true, 'corretora' => $corretora], 200);


    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $corretora = Corretora::find($id);
        $corretora -> nome = $request->nome;
        $corretora -> save();


    }

    public function destroy(Request $request, $id)
    {

        $usuario=Corretora::find($id);


        if (!$usuario instanceof Corretora) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "Corretora não foi encontrado."
                    ]],
                400
            );
            return $response;
        }
        $usuario->delete();

        return response()->json(['data'=>'O Corretora foi deletado com sucesso! ', 'id'=>$id],200);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @param $id
     */
    public function restore(Request $request, $id)
    {

        Corretora::withTrashed()
            ->where('id', $id)
            ->restore();

    }



}
