<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// Rota para usuários


/**
 * Lista todos usuários com as empresas
 */

$router->group(['prefix' => 'usuarios'], function () use ($router) {
    $router->get('/', 'UsuariosController@listarTodos');
    $router->get('/{id}', 'UsuariosController@listarPorId');
});
