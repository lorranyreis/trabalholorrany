<?php

require_once(__DIR__ . '/../../templates/template-html.php');
ob_start();

?>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Clientes</h2>
        </div>
        <div class="row">
            <div class="col-md-12" >

              <form action="salvar.php" class="card p-2 my-4" method="POST">
                  <div class="input-group">
                         <input type="text" placeholder="Nome do Cliente" 
                          class="form-control" name="nome" required>

                          <input type="text" placeholder="Endereco" 
                          class="form-control" name="endereco" required>

                          <input type="text" placeholder="Telefone" 
                          class="form-control" name="telefone" required>

                          <input type="text" placeholder="Cidade" 
                          class="form-control" name="cidade" required>

                          <input type="text" placeholder="Estado" 
                          class="form-control" name="estado" required>

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
    
?>


