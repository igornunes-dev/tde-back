<?php

use Slim\App;
use Src\Controller\ProdutoController;

return function (App $app) {
    $app->post('/produtos', [ProdutoController::class, 'store']);
    // $app->put('/tarefas/{id}', [TarefaController::class, 'update']);
    // $app->delete('/tarefas/{id}', [TarefaController::class, 'destroy']);
};
