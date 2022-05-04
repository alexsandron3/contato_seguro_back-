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


    public function cadastrar(Request $request)
    {
        $resposta = array();
        $usuario = new Usuarios();
        $usuario->email = $request->email;
        $usuario->telefone = $request->telefone;
        $usuario->dataNascimento = empty($request->dataNascimento) ? null : $request->dataNascimento;
        $usuario->cidadeNascimento = $request->cidadeNascimento;
        $usuario->nome = $request->nome;
        try {
            $usuario->save();

            $empresas = $request->empresas;

            $usuario->empresas()->attach($empresas);

            $resposta = array(
                'mensagem' => 'Usuário cadastrado com sucesso',
                'usuario' => $usuario,
                'empresas' => $empresas
            );
        } catch (\Throwable $th) {
            $resposta = array(
                'mensagem' => 'Erro ao cadastrar usuário',
                'erro' => $th->getMessage()
            );
        }
        return $resposta;
    }
}
