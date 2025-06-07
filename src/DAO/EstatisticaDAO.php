<?php
namespace Src\DAO;
use PDO;
use Src\Config\Conexao;
use Src\Model\estatistica;

class EstatisticaDAO {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConn();
    }

    public function calcularEstatisticas() {
        $compras = $this->conn->query("SELECT * FROM compras")->fetchAll(PDO::FETCH_ASSOC);
        $parcelas = $this->conn->query("SELECT * FROM parcelas")->fetchAll(PDO::FETCH_ASSOC);

        $count = count($compras);
        $sum = 0;
        $sumTx = 0;

        foreach ($compras as $compra) {
            $idCompra = $compra['id'];
            $entrada = (float) $compra['valorEntrada'];

            $parcelasCompra = array_filter($parcelas, function($p) use ($idCompra) {
                return $p['idCompra'] === $idCompra;
            });

            $totalParcelas = 0;
            $totalJuros = 0;

            foreach ($parcelasCompra as $p) {
                $totalParcelas += (float) $p['valor'];
                $totalJuros += (float) $p['juros'];
            }

            $totalCompra = $entrada + $totalParcelas;
            $sum += $totalCompra;
            $sumTx += $totalJuros;
        }

        $avg = $count > 0 ? $sum / $count : 0;
        $avgTx = $count > 0 ? $sumTx / $count : 0;

        return new estatistica($count, $sum, $avg, $sumTx, $avgTx);
    }
}
