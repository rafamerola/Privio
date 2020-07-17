<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Request;
//use App\Models\Papel;

$router->get('/', function () use ($router) {
    return view('index');
});
$router->get('/login', function () use ($router) {
    return view('usuario');
});

$router->group([

    "prefix"=> "auth"

    ],
    function () use ($router) {

        $router->post("/register", "UsuarioController@register");
        $router->post("/login", ["uses" => "UsuarioController@authenticate"]);
        $router->get("/showall", ["uses" => "UsuarioController@show"]);
        $router->delete("/{id}/del", "UsuarioController@destroy");
        $router->patch("/{id}/restore", "UsuarioController@restore");
        $router->put("/{id}/edit", "UsuarioController@update");

    });


$router->group(
    [
        "middleware" => "jwt.auth",
        "prefix" => "dashboard"
    ],
    function () use ($router) {
        $router->get("/", "UsuarioController@dashboard");
    }
);

$router->group(
    [
        "middleware" => "jwt.auth",
        "prefix" => "papels"
    ],
    function () use ($router) {

        $router->get("/", "PapelsController@index");
        $router->post("/", "PapelsController@store");
        $router->get("/{id}", "PapelsController@show");
        $router->put("/{id}/edit", "PapelsController@update");
        $router->delete("/{id}", "PapelsController@destroy");
        $router->patch("/{id}", "PapelsController@restore");
    });

$router->group(
    [
        "middleware" => "jwt.auth",
        "prefix" => "corretoras"
    ],
    function () use ($router) {
        $router->post("/", "CorretorasController@store");
        $router->get("/", "CorretorasController@index");
        $router->get("/{id}", "CorretorasController@show");
        $router->put("/{id}/edit", "CorretorasController@update");
        $router->delete("/{id}", "CorretorasController@destroy");
        $router->patch("/{id}", "CorretorasController@restore");
    });

    $router->group(
        [
            "middleware" => "jwt.auth",
            "prefix" => "operacao"
        ],
        function () use ($router) {
        $router->post("/", "OperacaosController@store");
        $router->get("/", "OperacaosController@index");
        $router->get("/{id}", "OperacaosController@show");
        $router->put("/{id}/edit", "OperacaosController@update");
        $router->delete("/{id}", "OperacaosController@destroy");
        $router->patch("/{id}", "OperacaosController@restore");
    }
);
