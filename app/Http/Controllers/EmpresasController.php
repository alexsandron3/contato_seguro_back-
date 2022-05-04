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
}
