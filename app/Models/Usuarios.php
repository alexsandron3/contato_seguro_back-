<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    //
    public function empresas()
    {
        return $this->belongsToMany(Usuarios::class, 'empresas_usuarios','idUsuario', 'idUsuario');
    }
}
