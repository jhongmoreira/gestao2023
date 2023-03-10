<?php
  $banco = new BancoDeDados;
?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fas fa-list"></li> Cadastrar Ordem de Serviço</h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form action="index.php?pg=12&action=salvar-registro" method="post" onsubmit="btnEnvia.disabled=true" autocomplete="off">

  <div class="row">
    <div class="col-md-2 mb-4">
      <button type="submit" name="btnEnvia" class="btn btn-info form-control"><li class="fa fa-plus"></li> Cadastrar</button>
    </div>

    <div class="col-md-2 mb-8">
      <!-- Coluna ajuste -->
    </div>
  </div>

  <!-- Linha 1 -->
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="idEmpresa">Cliente: </label>
            <select class="form-control" required="" name="empresa" id="idCliente">
                <option></option>
                <?php
                $banco->query("SELECT id, nome FROM clientes");

                    foreach ($banco->result() as $dados)
                    {
                      echo "<option value=".$dados['id'].">".$dados['nome']."</option>";
                    }
                ?>
            </select>
      </div>
    </div>   

    <div class="col-md-3">
      <div class="form-group">
      <label for="idDataOrcamento">Data de Início:</label>
          <input class="form-control" type="date" name="dt_orcamento" id="idDataOrcamento" required=""/>
      </div>
    </div>

  </div>
</form>

<div class="row">
  <div class="col-md-12">
    <?php

      if ($_SERVER["REQUEST_METHOD"] == 'POST')
      {
        $empresa = addslashes($_POST["empresa"]);
        $data_orcamento = addslashes($_POST["dt_orcamento"]);
        $status_orcamento = 0;

        $banco->query("INSERT INTO orcamento VALUES('', '$empresa', '$data_orcamento', '$status_orcamento', '')");
        

        $total = $banco->linhas();

        if ($total != 0)
        {
          echo "<div class='mt-2 alert alert-info'>Registro inserido com sucesso</div>";
          echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=12'/>";
        }else
        {
          echo "<div class='alert alert-danger'>Impossível inserir dados.</div>";
        }
      }
    ?>
  </div>
</div>

<div class="row mt-5">
  <div class="col-md-12">
    <h5 class="cor-txt-padrao"><li class="fa fa-clock"></li> Ordens de Serviço</h5>
<!-- Tabela -->
<table id="exemple" class="table">
    <thead class="cor-txt-padrao">
      <th scope="col">N°:</th>
      <th scope="col">Cliente</th>
      <th scope="col">Data</th>
      <th scope="col">Status</th>
    </thead>
      <tbody>
        <tr>

          <?php


            $banco->query("SELECT * FROM clientes, orcamento WHERE orcamento.empresa_cod = clientes.id ORDER BY id_orcamento");

            $total = $banco->linhas();

              if ($total != 0)
              {
                foreach ($banco->result() as $dados)
                {
            ?>
                  <td><a href="index.php?pg=13&orcamento=<?php echo $dados['id_orcamento']; ?>"><?php echo $dados['id_orcamento']; ?></a></td>
                  <td><?php echo $dados['nome']; ?></td>
                  <td>
                    <?php 
                     $data_orc = new DateTime($dados['data_orcamento']); // Pega o momento atual
                     echo $data_orc->format('d/m/Y'); // Exibe no formato desejado
                    ?>
                  </td>
                  <td>
                    <?php
                      if ($dados['status_orcamento']==1){
                        echo "<span class='text-success'><li class='fa fa-check-circle'></li></span>";
                      }
                      if ($dados['status_orcamento']==2){
                        echo "<span class='text-danger'><li class='fa fa-times-circle'></li></a>";
                      }
                      if ($dados['status_orcamento']==0){
                        echo "<span class='text-warning'><li class='fa fa-spinner fa-spin'></li></a>";
                      }
                    ?>
                  </td>
          </tr>
            <?php
                }
              }else
              {
                echo "Nada encontrado";
              }
          ?>
        <tr>
      </tbody>
    </table>

    <?php
      if (@$_GET['acao'] == 'apagar'){

        $num_orcamento = $_GET['orcamento'];

        $banco->query("UPDATE orcamento SET status_orcamento = 1 WHERE id_orcamento = '$num_orcamento'");

        $total = $banco->linhas();

        if ($total != 0)
        {
          echo "<div class='alert alert-info'>Registro removido</div>";
          echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=12'/>";
        }else
        {
          echo "<div class='alert alert-danger'>Impossível remover registro.</div>";
        }
      }
    ?>
</div>
</div>
</div>