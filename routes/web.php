<?php

/** @var \Laravel\Lumen\Routing\Router $router */





/**
 * Lista todos usuários com as empresas
 */

$router->group(['prefix' => 'usuarios'], function () use ($router) {
    $router->get('/', 'UsuariosController@listarTodos');
    $router->get('/{id}', 'UsuariosController@listarPorId');
    $router->delete('/{id}', 'UsuariosController@deletar');
    $router->post('/', 'UsuariosController@cadastrar');
});
