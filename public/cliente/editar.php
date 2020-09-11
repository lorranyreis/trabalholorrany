<?php

require_once(__DIR__ . '/../../templates/template-html.php');

require_once(__DIR__ . '/../../db/Db.php');
require_once(__DIR__ . '/../../model/Cliente.php');
require_once(__DIR__ . '/../../dao/DaoCliente.php');
require_once(__DIR__ . '/../../config/config.php');

$conn = Db::getInstance();

if (! $conn->connect()) {
    die();
}

$daoCliente = new DaoCliente($conn);
$cliente= $daoCliente->porId( $_GET['id'] );
    
if (! $cliente)
    header('Location: ./index.php');

else {  
    ob_start();

?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Clientes</h2>
        </div>
        <div class="row">
            <div class="col-md-12" >

              <form action="atualizar.php" class="card p-2 my-4" method="POST">
                  <div class="input-group">
                      <input type="hidden" name="id" 
                          value="<?php echo $cliente->getId(); ?>">                      

                          <input type="text" placeholder="Nome do Fornecedor" 
                          value="<?php echo $cliente->getNome(); ?>"
                          class="form-control" name="nome" required>

                        <input type="text" placeholder="Endereço" 
                        value="<?php echo $cliente->getEndereco(); ?>"
                            class="form-control" name="endereco" required>
                
                        <input type="text" placeholder="Telefone" 
                        value="<?php echo $cliente->getTelefone(); ?>"
                            class="form-control" name="telefone" required>
                
                        <input type="text" placeholder="Cidade" 
                        value="<?php echo $cliente->getCidade(); ?>"
                            class="form-control" name="cidade">
                    
                        <input type="text" placeholder="Estado" 
                        value="<?php echo $cliente->getEstado(); ?>"
                            class="form-control" name="estado">


                      <div class="input-group-append">
                          <button type="submit" class="btn btn-primary">
                              Salvar
                          </button>
                      </div>
                  </div>
              </form>
              <a href="index.php" class="btn btn-secondary ml-1" role="button" aria-pressed="true">Cancelar</a>

            </div>
        </div>
    </div>
<?php

    $content = ob_get_clean();
    echo html( $content );
} // else-if

?>
