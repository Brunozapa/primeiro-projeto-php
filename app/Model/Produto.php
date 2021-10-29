<?php

namespace App\Model;

use App\database\Connection;
use Exception;
use PDO;
use PDOException;

class Produto
{
    private int $idProduto;
    private string $nome;
    private int $quantidade;
    private float $preco;
    private Loja $Loja;

    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function adicionarProduto(array $params, int $fkLoja)
    {
        try {
            $query = "INSERT INTO produto VALUES (null, :nome, :estoque, :preco, :loja)";
            $stmt = $this->conn->setConn()->prepare($query);
            $stmt->bindParam(':nome', $params['nome'], PDO::PARAM_STR);
            $stmt->bindParam(':estoque', $params['estoque'], PDO::PARAM_INT);
            $stmt->bindParam(':preco', $params['preco'], PDO::PARAM_STR);
            $stmt->bindParam(':loja', $fkLoja, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: ../../view/home.php');
        } catch (PDOException $e) {
            throw new Exception('Erro ao tentar adicionar produto');
            die("ERRO: " . $e->getMessage());
        }
    }
    public function deletarProduto(int $idProduto)
    {
        try {
            $query = "DELETE FROM produto WHERE idProduto = :id";
            $stmt = $this->conn->setConn()->prepare($query);
            $stmt->bindParam(':id', $idProduto, PDO::PARAM_INT);

            if ($stmt->execute()) {
                die("deletou!");
            }

            die("não deletou");
        } catch (PDOException $e) {
            throw new Exception('Erro ao deletar tentar deletar o produto');
            die("ERRO: " . $e->getMessage());
        }
    }
    public function recuperarProdutos(int $idLoja)
    {
        try {
            $query = "SELECT * FROM produto WHERE fkLoja = :loja";
            $stmt = $this->conn->setConn()->prepare($query);
            $stmt->bindParam(':loja', $idLoja, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            throw new Exception('Erro ao recuperar os dados da tabela produto');
            die("ERRO: " . $e->getMessage());
        }
    }
}
