<?php


namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Corretora extends Model
{
    use SoftDeletes;

    protected $table = 'corretora';

    public function addCorretora(Corretora $corretora)
    {
        return $this->corretora()->save($corretora);
    }

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
}
