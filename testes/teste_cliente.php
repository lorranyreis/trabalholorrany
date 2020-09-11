<?php

require_once('../db/Db.php');
require_once('../model/Cliente.php');
require_once('../dao/DaoCliente.php');

function DaoCli_testar_inserir(DaoCliente $dao, Cliente $cli): bool {
  echo "Testando 'inserir'... ";
  $ret = $dao->inserir($cli);
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoCli_testar_porId(DaoCliente $dao, Cliente $cli): bool {
  echo "Testando 'porId()'... ";
  $id = $cli->getId();
  $cliById = $dao->porId($id);
  $ret =  (!is_null($cliById)) && 
          $cliById->getId() == $cli->getId() &&
          $cliById->getNome() == $cli->getNome() && 
          $cliById->getEndereco() == $cli->getEndereco() &&
          $cliById->getTelefone() == $cli->getTelefone() &&
          $cliById->getCidade() == $cli->getCidade() &&
          $cliById->getEstado() == $cli->getEstado() &&;
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;

}

function DaoCli_testar_todos(DaoCliente $dao, Cliente $cli): bool {
  echo "Testando 'todos()'... ";
  $ret = false;
  $clis = $dao->todos();
  if (is_array($clis) && count($clis)>0 ) {
    foreach($clis as $c) {
      $ret =  $c->getId() == $cli->getId() &&
              $c->getNome() == $cli->getNome()
              $c->getEndereco() == $cli->getEndereco()
              $c->getTelefone() == $cli->getTelefone()
              $c->getCidade() == $cli->getCidade()
              $c->getEstado() == $cli->getEstado();
      if ($ret) break;
    }
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoCli_testar_atualizar(DaoCliente $dao, Cliente $cli): bool {
  echo "Testando 'atualizar()'... ";
  $ret = false;
  $novoNome = $cli->getNome() . '[modificado]';
  $cli->setNome( $novoNome );
  if ( $dao->atualizar($dep) ) {
    $cliAtualizado = $dao->porId( $cli->getId() );
    $ret = $cliAtualizado->getNome() === $novoNome;
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}

function DaoCli_testar_remover(DaoCliente $dao, Cliente $cli): bool {
  echo "Testando 'remover()'... ";
  $ret = false;
  if ( $dao->remover($cli) ) {
    $cliRemovido = $dao->porId( $cli->getId() );
    $ret = is_null($cliRemovido);
  }
  echo ($ret) ? "Ok <br>\n" : "Erro <br>\n";
  return $ret;
}




function testar_DaoCliente(): bool {
  echo "<h2>Testando DaoCliente</h2>\n"; 

  $db = new Db("localhost", "user", "user", "vendas");

  if ($db->connect()) {
    $daoCli= new DaoCliente($db);
    $Cli = new Cliente("cliente teste");

    DaoCli_testar_inserir($daoCli, $cli);
    DaoCli_testar_porId($daoCli, $cli);
    DaoCli_testar_todos($daoCli, $cli);
    DaoCli_testar_atualizar($daoCli, $cli);
    DaoCli_testar_remover($daoCli, $cli);

    return true;
  }
  else {
    echo "<p>Erro na conexão com o banco de dados.</p>\n";
    return false;
  }    
}

// testar_DaoCliente();