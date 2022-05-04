<?php

namespace App\Http\Controllers;

use App\AppConfigs;
use App\Models\Empresas;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class EmpresasController extends Controller
{
    protected int $status = AppConfigs::HTTP_STATUS_BAD_REQUEST;
    public function listarTodos()
    {
        $resposta = array();
        try {
            $empresa = Empresas::join("empresas_usuarios", "empresas_usuarios.idEmpresa", "=", "empresas.id")
                ->join("usuarios", "usuarios.id", "=", "empresas_usuarios.idUsuario")
                ->select(
                    Empresas::raw("empresas.id, empresas.nome, empresas.cnpj, empresas.endereco"),
                    Empresas::raw("GROUP_CONCAT(usuarios.nome) AS nomeUsuario")
                )
                ->groupBy("empresas.id")
                ->get();
            $resposta = array(
                "mensagem" => AppConfigs::SUCESSO_AO_PESQUISAR,
                "dados" => $empresa
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
            $empresa = Empresas::join("empresas_usuarios", "empresas_usuarios.idEmpresa", "=", "empresas.id")
                ->join("usuarios", "usuarios.id", "=", "empresas_usuarios.idUsuario")
                ->select(
                    Empresas::raw("empresas.id, empresas.nome, empresas.cnpj, empresas.endereco"),
                    Empresas::raw("GROUP_CONCAT(usuarios.nome) AS nomeUsuario")
                )
                ->groupBy("empresas.id")
                ->having("empresas.id", $id)
                ->get();
            $resposta = array(
                "mensagem" => AppConfigs::SUCESSO_AO_PESQUISAR,
                "dados" => $empresa
            );
            $this->status = AppConfigs::HTTP_STATUS_OK;
            if (!sizeof($empresa)) {
                $resposta = array(
                    "mensagem" => AppConfigs::NENHUM_REGISTRO_COM_ESTE_ID,
                    "dados" => $empresa
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

    public function deletar($id)
    {
        $resposta = array();
        $empresa = Empresas::find($id);
        if ($empresa) {
            try {
                $empresa->delete();
                $resposta = array(
                    "mensagem" => AppConfigs::SUCESSO_AO_DELETAR,
                    "dados" => $empresa
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
        $empresa = Empresas::find($id);
        if ($empresa) {
            $empresa->nome = $request->nome;
            $empresa->cnpj = $request->cnpj;
            $empresa->endereco =  $request->endereco;

            try {
                $empresa->save();
                $resposta = array(
                    "mensagem" => AppConfigs::SUCESSO_AO_ATUALIZAR,
                    "dados" => array($empresa)
                );
                $this->status = AppConfigs::HTTP_STATUS_OK;
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

    public function cadastrar(Request $request)
    {
        $resposta = array();
        $empresa = new Empresas();
        $empresa->nome = $request->nome;
        $empresa->cnpj = $request->cnpj;
        $empresa->endereco =  $request->endereco;
        try {
            $empresa->save();

            $resposta = array(
                "mensagem" => AppConfigs::SUCESSO_AO_CADASTRAR,
                "dados" => array($empresa)
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
}
