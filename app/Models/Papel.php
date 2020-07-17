<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Papel extends Model
{
    protected $table = 'papel';
    use SoftDeletes;

    protected $papel = ['deleted_at'];

    public function onlyTrashed(Papel $papel)
    {
        $papelTrashed = $papel->onlyTrashed()->get();

        return view('path.name-view', compact('papelTrashed'));
    }

    public function restore($id)
    {
        $papel =  onlyTrashed()->find($id);

        $papel->restore();

    }

    public function forceDelete()
    {
        $flight = App\Papel::withTrashed();


        $papel = $papel->find($id);

        $papel->forceDelete();


    }
    protected $fillable = [
        'sigla', 'descricao',
    ];

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

    public function papels()
    {
        return $this->hasMany(Papel::class);
    }

    public function addPapel(Papel $papel)
    {
        return $this->papels()->save($papel);
    }

    public function deletePapel($papelId)
    {
        $this->papels()->find($papelId)->delete();
        return ["message"=>"Papel deletado com sucesso!"];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Usuarios::class);
    }
}
