<?php
namespace App\Http\Controllers;

use App\Models\Papel as papelmodel;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\Console\Input\Input;

class PapelsController extends Controller
{
    /**
     * @return Papel[]|\Illuminate\Database\Eloquent\Collection
     */



    public function index(Request $request)
    {
        $showAll = papelmodel::all();
       // return $request->papel()->latest()->paginate(); BUG
        return $showAll;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $showAll = papelmodel::all();
        return $showAll;
//        $papel = $request->Auth::guard('api')->papel()->find($id);
//        if (!$papel instanceof papelmodel) {
//            return Response::json(["error"=>[
//                "message"=> "Não é possível listar os papeis"
//            ]], 404);
//        }
//        return Response::json($papel, 200);
    }

    /**
     * @param Request $request
     * @param \App\Models\Usuarios $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sigla' => 'required|unique:papel',
            'descricao' => 'required',
        ]);

        if ($validator->fails()) {
            return array(
                'success' => false,
                'message' => $validator->errors()->all()
            );
        }

        $papel =  new papelmodel;

        $papel->sigla= $request->sigla;
        $papel->descricao= $request->descricao;
        $papel->usuario_id = Auth::id();
        $papel->save();

        return \response()->json(['success' => true, 'papel' => $papel], 200);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sigla' => 'required|unique:papel',
            'descricao' => 'required',
        ]);

        if ($validator->fails()) {
            return array(
                'success' => false,
                'message' => $validator->errors()->all()
            );
        }

        $papel =  new papelmodel;

        $papel->sigla= $request->sigla;
        $papel->descricao= $request->descricao;
        $papel->usuario_id = Auth::id();
        $papel->save();

        return \response()->json(['success' => true, 'papel' => $papel], 200);


    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
            $papel = papelmodel::find($id);
            $papel -> sigla = $request->sigla;
            $papel -> descricao = $request->descricao;
            $papel -> save();


    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {

            $papel=papelmodel::find($id);
            if (!$papel instanceof papelmodel) {
                $response = Response::json(
                    [
                        "error"=>[
                            "message" => "O Papel não foi encontrado."
                        ]],
                    400
                );
                return $response;
            }
                $papel->delete();
            return response()->json(['data'=>'Papel foi deletado com sucesso! ', 'id'=>$id],200);

    }

    public function onlyTrashed(papelmodel $papel)
    {
        $papel = papelmodel::onlyTrashed()->where('id', 1)->get();
        return view('path.name-view', compact('papel'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @param $id
     */
    public function restore(Request $request, $id)
    {

        papelmodel::withTrashed()
            ->where('id', $id)
            ->restore();

    }

}
