<?php

namespace App\Http\Controllers;

use App\AppConfigs;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class UsuariosController extends Controller
{
    protected int $status = AppConfigs::HTTP_STATUS_BAD_REQUEST;
    public function listarTodos()
    {
        $resposta = array();
        try {
            $usuario = Usuarios::join("empresas_usuarios", "empresas_usuarios.idUsuario", "=", "usuarios.id")
                ->join("empresas", "empresas.id", "=", "empresas_usuarios.idEmpresa")
                ->select(
                    Usuarios::raw("usuarios.id, usuarios.nome, usuarios.email, usuarios.telefone, usuarios.cidadeNascimento, usuarios.dataNascimento"),
                    Usuarios::raw("GROUP_CONCAT(empresas.nome) AS nomeEmpresa")
                )
                ->groupBy("usuarios.id")
                ->get();
            $resposta = array(
                "mensagem" => AppConfigs::SUCESSO_AO_PESQUISAR,
                "dados" => $usuario
            );
            $this->status = AppConfigs::HTTP_STATUS_OK;
        } catch (\Throwable $th) {
            $resposta = array(
                "mensagem" => AppConfigs::FALHA_AO_PESQUISAR,
                "erro" => $th->getMessage(),
                "dados" => array()
            );
        }
        return (new Response($resposta, $this->status));
    }
    public function listarPorId($id)
    {
        $resposta = array();
        try {
            $usuario = Usuarios::join("empresas_usuarios", "empresas_usuarios.idUsuario", "=", "usuarios.id")
                ->join("empresas", "empresas.id", "=", "empresas_usuarios.idEmpresa")
                ->select(
                    Usuarios::raw("usuarios.id, usuarios.nome, usuarios.email, usuarios.telefone, usuarios.cidadeNascimento, usuarios.dataNascimento"),
                    Usuarios::raw("GROUP_CONCAT(empresas.nome) AS nomeEmpresa")
                )
                ->where("usuarios.id", $id)
                ->groupBy("usuarios.id")
                ->get();
            $resposta = array(
                "mensagem" => AppConfigs::SUCESSO_AO_PESQUISAR,
                "dados" => $usuario
            );
            $this->status = AppConfigs::HTTP_STATUS_OK;
            if (!sizeof($usuario)) {
                $resposta = array(
                    "mensagem" => AppConfigs::NENHUM_REGISTRO_COM_ESTE_ID,
                    "dados" => $usuario
                );
                $this->status = AppConfigs::HTTP_STATUS_NOT_FOUND;
            }
        } catch (\Throwable $th) {
            $resposta = array(
                "mensagem" => AppConfigs::FALHA_AO_PESQUISAR,
                "erro" => $th->getMessage(),
                "dados" => array()
            );
        }
        return (new Response($resposta, $this->status));
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
                "mensagem" => AppConfigs::SUCESSO_AO_CADASTRAR,
                "dados" => array($empresas, $usuario)
            );
            $this->status = AppConfigs::HTTP_STATUS_CREATED;
        } catch (\Throwable $th) {
            $resposta = array(
                "mensagem" => AppConfigs::FALHA_AO_CADASTRAR,
                "erro" => $th->getMessage(),
                "dados" => array()
            );
        }
        return (new Response($resposta, $this->status));
    }

    public function deletar($id)
    {
        $resposta = array();
        $usuario = Usuarios::find($id);
        if ($usuario) {
            try {
                $usuario->delete();
                $resposta = array(
                    "mensagem" => AppConfigs::SUCESSO_AO_DELETAR,
                    "dados" => $usuario
                );
                $this->status = AppConfigs::HTTP_STATUS_OK;
            } catch (\Throwable $th) {
                $resposta = array(
                    "mensagem" => AppConfigs::FALHA_AO_DELETAR,
                    "erro" => $th->getMessage(),
                    "dados" => array()
                );
            }
        } else {
            $resposta = array(
                "mensagem" => AppConfigs::NENHUM_REGISTRO_COM_ESTE_ID,
                "dados" => array()
            );
            $this->status = AppConfigs::HTTP_STATUS_NOT_FOUND;
        }
        return (new Response($resposta, $this->status));
    }

    public function atualizar($id, Request $request)
    {
        $resposta = array();
        $usuario = Usuarios::find($id);
        if ($usuario) {
            $usuario->email = $request->email;
            $usuario->telefone = $request->telefone;
            $usuario->dataNascimento = empty($request->dataNascimento) ? null : $request->dataNascimento;
            $usuario->cidadeNascimento = $request->cidadeNascimento;
            $usuario->nome = $request->nome;

            try {
                $usuario->save();
                $empresas = $request->empresas;

                $usuario->empresas()->sync($empresas);
                $resposta = array(
                    "mensagem" => AppConfigs::SUCESSO_AO_ATUALIZAR,
                    "dados" => array($empresas, $usuario)
                );
            } catch (\Throwable $th) {
                $resposta = array(
                    "mensagem" => AppConfigs::FALHA_AO_ATUALIZAR,
                    "erro" => $th->getMessage(),
                    "dados" => array()
                );
            }
        } else {
            $resposta = array(
                "mensagem" => AppConfigs::NENHUM_REGISTRO_COM_ESTE_ID,
                "dados" => array()
            );
            $this->status = AppConfigs::HTTP_STATUS_NOT_FOUND;
        }
        return (new Response($resposta, $this->status));
    }
}
