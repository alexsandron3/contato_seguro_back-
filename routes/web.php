<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/**
 * Grupo de rotas para usuários
 */
$router->group(['prefix' => 'usuario'], function () use ($router) {
    $router->get('/', 'UsuariosController@listarTodos');
    $router->get('/{id}', 'UsuariosController@listarPorId');
    $router->delete('/{id}', 'UsuariosController@deletar');
    $router->put('/{id}', 'UsuariosController@atualizar');
    $router->post('/', 'UsuariosController@cadastrar');
});

/**
 * Grupo de rotas para empresas
 */
$router->group(['prefix' => 'empresa'], function () use ($router) {
    $router->get('/', 'EmpresasController@listarTodos');
    $router->get('/{id}', 'EmpresasController@listarPorId');
});
