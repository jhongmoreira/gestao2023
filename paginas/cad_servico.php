<?php
  $banco = new BancoDeDados;
?>

<style>
    @media print
    {    
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2 no-print">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-user-plus"></li> Cadastrar Serviço </h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form action="index.php?pg=15&action=salvar-registro" method="post" onsubmit="btnEnvia.disabled=true" autocomplete="off" class="no-print">

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
        <label for="idNome">Produto:</label>
          <input class="form-control" type="text" name="nome" id="idNome" required=""/>
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="form-group">
        <label for="idCusto">Custo:</label>
          <input class="form-control" type="number" name="custo" id="idCusto" step="0.01" required=""/>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="idValor">Valor:</label>
          <input class="form-control" type="number" name="valor" id="idValor" step="0.01" required=""/>
      </div>
    </div>

  </div>
</form>

<div class="row mt-3">
  <div class="col-md-12">
    <h5 class="cor-txt-padrao"><li class="fa fa-clock"></li> Serviços Cadastrados</h5>
<!-- Tabela -->
<table id="exemple" class="table">
    <thead class="cor-txt-padrao">
      <th scope="col">ID</th>
      <th scope="col">Serviço</th>
      <th scope="col">Custo</th>
      <th scope="col">Preço</th>
    </thead>
      <tbody>
        <tr>

          <?php


            $banco->query("SELECT * FROM servicos");

            $total = $banco->linhas();

              if ($total != 0)
              {
                foreach ($banco->result() as $dados)
                {
            ?>
                  <td><?php echo $dados['id_servico']; ?></td>
                  <td><?php echo $dados['servico']; ?></td>
                  <td><?php echo 'R$ '.number_format($dados['custo'],2, ',', '.');?></td>
                  <td><?php echo 'R$ '.number_format($dados['valor_uni'],2, ',', '.');?></td>
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
  </div>
</div>


<div class="row">
  <div class="col-md-12">
    <?php

      if ($_SERVER["REQUEST_METHOD"] == 'POST')
      {
        $nome = addslashes($_POST["nome"]);
        $custo = addslashes($_POST["custo"]);
        $valor = addslashes($_POST["valor"]);

        $banco->query("INSERT INTO servicos VALUES('', '$nome', '$custo', '$valor')");

        $total = $banco->linhas();

        if ($total != 0)
        {
          echo "<div class='alert alert-info'>Registro inserido com sucesso</div>";
          echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=15'/>";
        }else
        {
          echo "<div class='alert alert-danger'>Impossível inserir dados.</div>";
        }
      }
    ?>
  </div>
</div>
</div>