<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Operacao extends Model
{
    protected $table = 'operacao';
    use SoftDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuarios()
    {
        return $this->hasOne(Usuarios::class);

    }

    public function addUser(Usuarios $usuarios)
    {
        return $this->usuarios()->save($usuarios);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Usuarios::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function papels()
    {
        return $this->hasMany(Papel::class);
    }

    public function addPapel(Papel $papel)
    {
        return $this->papels()->save($papel);
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function corretora()
    {
        return $this->hasMany(Corretora::class);
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

}
