<?php
namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuarios;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Http\ResponseFactory;
use function MongoDB\BSON\toJSON;

class UsuarioController extends BaseController
{
    use SoftDeletes;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

    }
    /**
     * Create a new token.
     *
     * @param  \App\Models\Usuarios   $user
     * @return string
     */
    protected function jwt(Usuarios $user)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 3600*3600 // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuarios   $user
     * @return mixed
     */
    public function authenticate(Usuarios $user)
    {
        $this->validate($this->request, [
            'email'     => 'required|email',
            'senha'  => 'required'
        ]);
        $user = Usuarios::where('email', $this->request->input('email'))->first();
        if (!$user) {
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }
        if (Hash::check($this->request->input('senha'), $user->senha)) {
            return response()->json(['success'=> true,
                'access_token' => $this->jwt($user),
                'resposta:'=>'Logado com sucesso!'
            ], 200);
        }
        return response()->json([

             'error' => 'Email or password is wrong.',
//            'senha'=>$this->request->input('senha')

        ], 400);
    }

    /**
     * Registration method
     *
     * @param Request $request registration request
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|unique:usuarios',
            'senha' => 'required',
            'email' => 'required|email|unique:usuarios'
        ]);

        if ($validator->fails()) {
            return array(
                'success' => false,
                'message' => $validator->errors()->all()
            );
        }

        $user =  new Usuarios;

        $user->nome= $request->nome;
        $user->email= $request->email;
        $user->senha= app('hash')->make($request->senha);
        $user->save();

        unset($user->senha);
        return \response()->json(['success' => true, 'usuario  ' => $user], 200);

    }

    public function show(Request $request){

        $all = Auth::user()->all();
       // $all = $userNome.'+'.$userEmail;

        return $all;
    }

    public function destroy(Request $request, $id)
    {

        $usuario=Usuarios::find($id);


        if (!$usuario instanceof Usuarios) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "Usuário não foi encontrado."
                    ]],
                400
            );
            return $response;
        }
        $usuario->delete();

       return response()->json(['data'=>'O Usuário foi deletado com sucesso! ', 'id'=>$id],200);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @param $id
     */
    public function restore(Request $request, $id)
    {

        Usuarios::withTrashed()
            ->where('id', $id)
            ->restore();

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = Usuarios::find($id);
        $user -> nome = $request->nome;
        $user -> senha = app('hash')->make($request->senha);
        $user -> email = $request->email;
        $user -> save();


    }

    public function dashboard(){
        return "dashboard";
    }

}
