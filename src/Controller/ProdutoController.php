<?php
namespace Src\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Src\DAO\ProdutoDAO;
use Slim\Exception\HttpBadRequestException;
use Src\Model\Produto;

class ProdutoController {

    public function index(Request $request, Response $response) {
        $dao = new ProdutoDAO();
        $data = $dao->listar();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, $args) {
        $dao = new ProdutoDAO();
        $tarefa = $dao->buscarPorId($args['id']);
        if (!$tarefa) {
            $response->getBody()->write(json_encode(['erro' => 'Tarefa não encontrada']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
        $response->getBody()->write(json_encode($tarefa));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response {
        try {
            $dados = $request->getParsedBody();
            $contentType = $request->getHeaderLine('Content-Type');

            if (is_array($dados) && (!isset($dados['id']) || !isset($dados['nome']) || !isset($dados['valor']))) {
                return $response->withStatus(400); 
            }

            if (stripos($contentType, 'application/json') !== false && !is_array($dados)) {
                throw new HttpBadRequestException($request, "Corpo da requisição JSON esperado, mas inválido ou ausente.");
            }
            if (stripos($contentType, 'application/json') === false && $request->getBody()->getSize() > 0) {
                 throw new HttpBadRequestException($request, "Content-Type incorreto, esperado application/json.");
            }

            $id = $dados['id'] ?? null;
            $nome = $dados['nome'] ?? null;
            $valor = isset($dados['valor']) ? (float)$dados['valor'] : null;
            $tipo = $dados['tipo'] ?? null;

            $produto = new Produto((string)$id, (string)$nome, (float)$valor, $tipo);
            $idInserido = new ProdutoDAO();
            $idInserido->inserir($produto);

            if ($idInserido === false) {
                return $response->withStatus(422); // Unprocessable Entity, sem corpo
            }

            return $response->withStatus(201); // Created, sem corpo

        } catch (\InvalidArgumentException $e) { // Do Model Produto
            error_log("InvalidArgumentException (422): " . $e->getMessage());
            return $response->withStatus(422);
        } catch (HttpBadRequestException $e) { // Exceção do Slim ou lançada manualmente acima
            error_log("HttpBadRequestException (400): " . $e->getMessage());
            return $response->withStatus(400);
        } catch (\PDOException $e) {
            error_log('PDOException (500) no store: ' . $e->getMessage());
            return $response->withStatus(500);
        } catch (\RuntimeException $e) {
            error_log('RuntimeException (500) no store: ' . $e->getMessage());
            return $response->withStatus(500);
        } catch (\Throwable $e) {
            error_log('Erro inesperado (500) no store: ' . $e->getMessage());
            return $response->withStatus(500);
        }
    }

    // public function update(Request $request, Response $response, $args) {
    //     $id = $args['id'] ?? null;

    //     if (!$id) {
    //         return $response->withStatus(400)->withHeader('Content-Type', 'application/json')
    //                         ->write(json_encode(['erro' => 'ID não informado']));
    //     }

    //     $body = $request->getBody()->getContents();
    //     $dados = json_decode($body, true);

    //     if (!is_array($dados)) {
    //         return $response->withStatus(400)->withHeader('Content-Type', 'application/json')
    //                         ->write(json_encode(['erro' => 'JSON inválido']));
    //     }

    //     $tarefa = new Tarefa();
    //     $tarefa->titulo = $dados['titulo'] ?? null;
    //     $tarefa->status = $dados['status'] ?? 0;

    //     if (empty($tarefa->titulo)) {
    //         return $response->withStatus(400)->withHeader('Content-Type', 'application/json')
    //                         ->write(json_encode(['erro' => 'Título obrigatório']));
    //     }

    //     $dao = new ProdutoDAO();
    //     $ok = $dao->atualizar($id, $tarefa);

    //     if ($ok) {
    //         return $response->withStatus(204); 
    //     }

    //     return $response->withStatus(404)->withHeader('Content-Type', 'application/json')
    //                     ->write(json_encode(['erro' => 'Tarefa não encontrada']));
    // }

    // public function destroy(Request $request, Response $response, $args) {
    //     $dao = new ProdutoDAO();
    //     $ok = $dao->excluir($args['id']);
    //     if ($ok) {
    //         return $response->withStatus(204);
    //     }
    //     return $response->withStatus(404)->withHeader('Content-Type', 'application/json')
    //                     ->write(json_encode(['erro' => 'Tarefa não encontrada']));
    // }
}
