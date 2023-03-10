<?php
  include_once('classes/database.php');
  $id_orcamento = $_GET['orcamento'];
  $banco = new BancoDeDados;
?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fas fa-list"></li> Observação e Status</h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form action="index.php?pg=13&orcamento=<?php echo $id_orcamento; ?>&action=salvar-registro" method="post" onsubmit="btnEnvia.disabled=true" autocomplete="off">

  <div class="row">
    <div class="col-md-2 mb-4">
      <button type="submit" name="btnEnvia" class="btn btn-success form-control"><li class="fa fa-check"></li> Salvar</button>
    </div>

    <div class="col-md-2 mb-8">
      <!-- Coluna ajuste -->
    </div>
  </div>
<div class="row mb-3">
  <div class="col-md-12">
    <div class="form-group">
      <label for="idProduto"><b>Ordem N°:</b></label>
        <?php

          $bancoQuery = new BancoDeDados;

          $bancoQuery->query("SELECT * FROM orcamento, clientes WHERE orcamento.empresa_cod = clientes.id AND orcamento.id_orcamento = $id_orcamento LIMIT 1");

          foreach ($bancoQuery->result() as $dadosQuery){
            if ($dadosQuery['status_orcamento']==1){
              $msg = "<span class='badge bg-success'>Finalizado</span>";
            }else{
              if ($dadosQuery['status_orcamento']==0){
                $msg = "<span class='badge bg-warning'>Em andamento</span>";
              }else{
                $msg = "<span class='badge bg-danger'>Parado</span>";
              }
            }
            echo $dadosQuery['id_orcamento']."</br><b>Cliente:</b> ".$dadosQuery['nome']."</br><b>Status atual:</b> ".$msg;
          }
      ?>
    </div>
  </div>
</div
  <!-- Linha 1 -->
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="idStatus">Status: </label>
            <select class="form-control" required="" name="status" id="idStatus">
                <!-- <option value="0">Em Andamento</option>
                <option value="1">Finalizado</option>
                <option value="2">Parado</option> -->
                <?php
                $bancoQuery->query("SELECT * FROM orcamento, clientes WHERE orcamento.empresa_cod = clientes.id AND orcamento.id_orcamento = $id_orcamento LIMIT 1");
                foreach ($bancoQuery->result() as $dadosQuery){}
                if ($dadosQuery['status_orcamento']==0){
                  echo "<option value='0' selected>Em Andamento</option>";
                  echo "<option value='1'>Finalizado</option>";
                  echo "<option value='2'>Parado</option>";
                }else{
                  if ($dadosQuery['status_orcamento']==1){
                    echo "<option value='0'>Em Andamento</option>";
                    echo "<option value='1' selected>Finalizado</option>";
                    echo "<option value='2'>Parado</option>";
                  }else{
                    echo "<option value='0'>Em Andamento</option>";
                    echo "<option value='1'>Finalizado</option>";
                    echo "<option value='2' selected>Parado</option>";
                  }
                }
                ?>
            </select>
      </div>
    </div>   
  </div>
    <hr> 
    <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="idObs">Obs.: </label>
         <textarea class="form-control" name="obs" id="idObs"><?php echo $dadosQuery['observacao'];?></textarea>
      </div>
    </div>
  </div>
</form>

<div class="row">
  <div class="col-md-12">
    <?php

      if ($_SERVER["REQUEST_METHOD"] == 'POST')
      {
        $id_orc = $id_orcamento;
        $status = addslashes($_POST["status"]);
        $obs = addslashes($_POST["obs"]);

        $banco->query("UPDATE orcamento SET status_orcamento = $status, observacao = '$obs' WHERE id_orcamento = '$id_orc'");
        
        $total = $banco->linhas();

        if ($total != 0)
        {
          echo "<div class='mt-5 alert alert-info'>Alterações salvas</div>";
          echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=12'/>";
        }else
        {
          echo "<div class='alert alert-danger'>Impossível inserir dados.</div>";
        }
      }
    ?>
  </div>
</div>
</div>