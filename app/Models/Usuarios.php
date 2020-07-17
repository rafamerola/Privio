<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Lumen\Routing\Controller;
use Controller\UsuarioController;

class Usuarios extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    use SoftDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function papel()
    {
        return $this->hasMany(Papel::class);
    }

    public function addPapel(Papel $papel)
    {
        return $this->papel()->save($papel);
    }

    public function deletePapel($id)
    {
        $this->papel()->find($id)->delete();
        return ["message"=>"Papel deletado com sucesso!"];
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function corretora()
    {
        return $this->hasMany(Corretora::class, 'usuario_id')->latest();
    }
    public function addCorretora(Corretora $corretora)
    {
        return $this->corretora()->save($corretora);
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteCorretora($corretoraId)
    {
        $this->corretora()->find($corretoraId)->delete();
        return ["message"=>"Corretora deletada com sucesso!"];
    }




    public function operacao()
    {
        return $this->hasMany(Operacao::class);
    }

    public function addOperacao(Operacao $operacao, $corretora_id)
    {
        return $this->operacao()->find($corretora_id)->operacao()->create([
            "data_operacao"=>$operacao->data_operacao,
            "tipo_operacao"=>$operacao->tipo_operacao,
            "quantidade"=>$operacao->quantidade,
            "valor"=>$operacao->valor_operacao,
            "usuario_id"=> $this->id

        ]);
    }


}
