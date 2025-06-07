<?php
namespace Src\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Src\DAO\EstatisticaDAO;

class EstatisticaController {

    public function getEstatisticas(Request $request, Response $response, array $args): Response {
        try {
            $dao = new EstatisticaDAO();
            $estatistica = $dao->calcularEstatisticas();

            // Verificação opcional: se não houver estatísticas, pode retornar 404 (Not Found)
            if (!$estatistica) {
                return $response->withStatus(404);
            }

            // Converte o objeto de estatísticas para um array e depois para JSON
            $payload = json_encode($estatistica->toArray());

            // Escreve o JSON no corpo da resposta
            $response->getBody()->write($payload);

            // Retorna a resposta com o status 200 (OK) e o cabeçalho de Content-Type
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (\PDOException $e) {
            // Captura erros de banco de dados
            error_log('PDOException (500) em getEstatisticas: ' . $e->getMessage());
            return $response->withStatus(500); // Internal Server Error
        } catch (\Throwable $e) {
            // Captura qualquer outro erro inesperado
            error_log('Erro inesperado (500) em getEstatisticas: ' . $e->getMessage());
            return $response->withStatus(500); // Internal Server Error
        }
    }
}
