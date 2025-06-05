<?php
namespace Src\DAO;

use Src\Model\Produto;
use Src\Config\Conexao;
use PDO;

class ProdutoDAO {
    private $db;

    public function __construct() {
        $this->db = Conexao::getConn();
    }

    public function listar() {
        $stmt = $this->db->query("SELECT * FROM tarefas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM tarefas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function inserir(Produto $produto) {
        $sql = "INSERT INTO produtos (id, nome, tipo, valor) VALUES (?, ?, ?, ?)";
        try {
            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                $produto->getId(),
                $produto->getNome(),
                $produto->getTipo(),
                $produto->getValor()
            ]);

            return $this->db->lastInsertId();

        } catch (\PDOException $e) {
            echo "Erro no DAO ao inserir produto: " . $e->getMessage();
            return false; 
        }
    }

    // public function atualizar($id, Tarefa $tarefa) {
    //     $stmt = $this->db->prepare("UPDATE tarefas SET titulo = ?, status = ? WHERE id = ?");
    //     return $stmt->execute([$tarefa->titulo, $tarefa->status, $id]);
    // }

    public function excluir($id) {
        $stmt = $this->db->prepare("DELETE FROM tarefas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
