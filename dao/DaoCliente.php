<?php 
require_once(__DIR__ . '/../model/Cliente.php');
require_once(__DIR__ . '/../db/Db.php');

// Classe para persistencia de Cliente
// DAO - Data Access Object
class DaoCliente {
    
  private $connection;

  public function __construct(Db $connection) {
      $this->connection = $connection;
  }
  
  public function porId(int $id): ?Cliente {
    $sql = "SELECT nome, endereco, telefone, cidade, estado FROM clientes where id = ?";
    $stmt = $this->connection->prepare($sql);
    $cli = null;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      if ($stmt->execute()) {
        $stmt->bind_result($nome, $endereco, $telefone, $cidade, $estado);
        $stmt->store_result();
        if ($stmt->num_rows == 1 && $stmt->fetch()) {
          $cli = new Cliente ($nome, $endereco, $telefone, $cidade,$estado, $id);
        }
      }
      $stmt->close();
    }
    return $cli;
  }

  public function inserir(Cliente $cliente): bool {
    $sql = "INSERT INTO clientes (nome,endereco,telefone,cidade,estado) VALUES(?,?,?,?,?)";
    $stmt = $this->connection->prepare($sql);
    $res = false;
    if ($stmt) {
      $nome = $cliente->getNome();
      $endereco = $cliente->getEndereco();
      $telefone = $cliente->getTelefone();
      $cidade = $cliente->getCidade();
      $estado = $cliente->getEstado();
      $stmt->bind_param('sssss', $nome, $endereco, $telefone, $cidade, $estado);
      if ($stmt->execute()) {
          $id = $this->connection->getLastID();
          $cliente->setId($id);
          $res = true;
      }
      $stmt->close();
    }
    return $res;
  }

  public function remover(Cliente $cliente): bool {
    $sql = "DELETE FROM clientes where id=?";
    $id = $cliente->getId(); 
    $stmt = $this->connection->prepare($sql);
    $ret = false;
    if ($stmt) {
      $stmt->bind_param('i',$id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  public function atualizar(Cliente $cliente): bool {
    $sql = "UPDATE clientes SET nome = ?, endereco = ?, telefone = ?, cidade = ?, estado = ? WHERE id = ?";
    $stmt = $this->connection->prepare($sql);
    $ret = false;      
    if ($stmt) {
      $id = $cliente->getId();
      $nome = $cliente->getNome();
      $endereco = $cliente->getEndereco();
      $telefone = $cliente->getTelefone();
      $cidade = $cliente->getCidade();
      $estado = $cliente->getEstado();
      $stmt->bind_param('sssssi', $nome, $endereco, $telefone, $cidade, $estado, $id);
      $ret = $stmt->execute();
      $stmt->close();
    }
    return $ret;
  }

  
  public function todos(): array {
    $sql = "SELECT id, nome, endereco, telefone, cidade, estado from clientes";
    $stmt = $this->connection->prepare($sql);
    $cliente = [];
    if ($stmt) {
      if ($stmt->execute()) {
        $id = 0; 
        $nome = '';
        $endereco = '';
        $telefone = '';
        $cidade = '';
        $estado = '';
        $stmt->bind_result($id, $nome, $endereco, $telefone, $cidade, $estado);
        $stmt->store_result();
        while($stmt->fetch()) {
          $cliente [] = new Cliente ($nome, $endereco, $telefone, $cidade, $estado, $id);
        }
      }
      $stmt->close();
    }
    return $cliente;
  }

};
