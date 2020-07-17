<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 22/07/2018
 * Time: 14:43
 */

namespace App\Http\Controllers;

use App\Models\Operacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class OperacaosController extends Controller
{


    /**
     * @return Papel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $showAll = Operacao::all();
        //return $request->auth->papels()->latest()->paginate();
        return $showAll;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $operacao = $request->auth->operacao()->find($id);


        if (!$operacao instanceof Operacao) {
            return Response::json(["error"=>[
                "message"=> "Não é possível listar as operações"
            ]], 404);
        }
        return Response::json($operacao, 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data_operacao' => 'required',
            'tipo_operacao' => 'required',
            'quantidade' => 'required',
            'valor' => 'required',
            'corretora_id' => 'required',
            'papel_id' => 'required'
        ]);

        if ($validator->fails()) {
            return array(
                'success' => false,
                'message' => $validator->errors()->all()
            );
        }

        $operacao =  new Operacao;

        $operacao->data_operacao= $request->data_operacao;
        $operacao->tipo_operacao= $request->tipo_operacao;
        $operacao->quantidade= $request->quantidade;
        $operacao->valor= $request->valor;
        $operacao->usuario_id= Auth::id();
        $operacao->corretora_id= $request->corretora_id;
        $operacao->papel_id= $request->papel_id;
        $operacao->save();

        return \response()->json(['success' => true, 'operacao' => $operacao], 200);


    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $operacao = Operacao::find($id);
        $operacao -> data_operacao = $request->data_operacao;
        $operacao -> tipo_operacao = $request->tipo_operacao;
        $operacao -> quantidade = $request->quantidade;
        $operacao -> valor = $request->valor;

        $operacao -> save();


    }



    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {

        $operacao=Operacao::find($id);
        if (!$operacao instanceof Operacao) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "Operação nao pode ser encontrada."
                    ]],
                400
            );
            return $response;
        }
        $operacao->delete();
        return response()->json(['data'=>'Operação foi deletado com sucesso! ', 'id'=>$id],200);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @param $id
     */
    public function restore(Request $request, $id)
    {

        Operacao::withTrashed()
            ->where('id', $id)
            ->restore();

    }
}
