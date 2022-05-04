<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function listarTodos()
    {
        $usuario = Usuarios::join('empresas_usuarios', 'empresas_usuarios.idUsuario', '=', 'usuarios.id')
            ->join('empresas', 'empresas.id', '=', 'empresas_usuarios.idEmpresa')
            ->select(
                Usuarios::raw('usuarios.id, usuarios.nome, usuarios.email, usuarios.telefone, usuarios.cidadeNascimento, usuarios.dataNascimento'),
                Usuarios::raw('GROUP_CONCAT(empresas.nome) AS nomeEmpresa')
            )
            ->groupBy('usuarios.id')
            ->get();
        return $usuario;
    }
    public function listarPorId($id)
    {
        $usuario = Usuarios::join('empresas_usuarios', 'empresas_usuarios.idUsuario', '=', 'usuarios.id')
            ->join('empresas', 'empresas.id', '=', 'empresas_usuarios.idEmpresa')
            ->select(
                Usuarios::raw('usuarios.id, usuarios.nome, usuarios.email, usuarios.telefone, usuarios.cidadeNascimento, usuarios.dataNascimento'),
                Usuarios::raw('GROUP_CONCAT(empresas.nome) AS nomeEmpresa')
            )
            ->where('usuarios.id', $id)
            ->groupBy('usuarios.id')
            ->get();
        return $usuario;
    }
}
