<?php
namespace Src\Model;

class Produto {
    private string $id;
    private string $nome;
    private ?string $tipo; 
    private float $valor; 

    public function __construct(string $id, string $nome, float $valor, ?string $tipo = null) {
        $this->setId($id);
        $this->setNome($nome);   
        $this->setValor($valor);
        $this->setTipo($tipo);   
    }

    public function getId(): string {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        if (trim($nome) === '') {
            throw new \InvalidArgumentException("O nome do produto não pode ser vazio.");
        }
        $this->nome = $nome;
    }

    public function getTipo(): ?string {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): void {
        $this->tipo = $tipo;
    }

    public function getValor(): float {
        return $this->valor;
    }

    public function setValor(float $valor): void {
        if ($valor <= 0) {
            throw new \InvalidArgumentException("O valor do produto deve ser maior que zero. Valor fornecido: " . $valor);
        }
        $this->valor = $valor;
    }
}

