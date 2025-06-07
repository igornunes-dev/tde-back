<?php

use Slim\App;
use Src\Controller\ProdutoController;
use Src\Controller\EstatisticaController;

return function (App $app) {
    $app->post('/produtos', [ProdutoController::class, 'store']);
    $app->get('/estatistica', [EstatisticaController::class, 'getEstatisticas']);
    // $app->put('/tarefas/{id}', [TarefaController::class, 'update']);
    // $app->delete('/tarefas/{id}', [TarefaController::class, 'destroy']);
};
