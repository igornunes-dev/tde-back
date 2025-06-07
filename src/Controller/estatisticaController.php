<?php
require_once '../DAO/estaisticaDAO.php';

class estatisticaController {
    private $dao;

    public function __construct($pdo) {
        $this->dao = new estatisticaDAO($pdo);
    }

    public function getEstatisticas() {
        $estatistica = $this->dao->calcularEstatisticas();
        http_response_code(200);
        echo json_encode($estatistica->toArray());
    }
}
