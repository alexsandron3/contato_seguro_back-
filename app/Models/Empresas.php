<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    //
    public $timestamps = false;


    public function usuarios()
    {
        return $this->belongsToMany(Empresas::class, 'empresas_usuarios', 'idEmpresa', 'idUsuario');
    }
}
