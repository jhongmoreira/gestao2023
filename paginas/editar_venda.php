<?php
  $banco = new BancoDeDados;
  $bancoQuery = new BancoDeDados;
  $clienteId = @$_GET['cliente'];
  $codVenda = @$_GET['venda'];
  $banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND clientes.id = $clienteId AND id_venda = $codVenda AND vendas.servico = servicos.id_servico ORDER BY vendas.id_venda");
  foreach ($banco->result() as $dados) {}
?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-list"></li> Editar Venda</h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form method="post" onsubmit="btnEnvia.disabled=true" autocomplete="off" enctype="multipart/form-data">


  <div class="row">
    <div class="col-md-2 mb-4">
      <button type="submit" name="btnEnvia" class="btn btn-info form-control"><li class="fa fa-plus"></li> Salvar</button>
    </div>

    <div class="col-md-2 mb-8">
      <!-- Coluna ajuste -->
    </div>
  </div>

  <!-- Linha 1 -->
  <div class="row">

    <div class="col-md-3">
      <div class="form-group">
        <label for="idCliente">Cliente:</label>
            <input type="text" class="form-control" id="idCliente" value=" <?php echo $dados['nome']; ?>" readonly>
               
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="idServico">Serviço: </label>
            <!-- <input class="form-control" type="text" name="servico" id="idServico" required=""/> -->
            <select class="form-control" required="" name="servico" id="idCliente">
                <option></option>
                <?php
                $bancoQuery->query("SELECT id_servico, servico FROM servicos");

                    foreach ($bancoQuery->result() as $dadosServico)
                    {
                      echo "<option value=".$dadosServico['id_servico'].">".$dadosServico['servico']."</option>";
                    }
                ?>
            </select>
      </div>
    </div>   

    <div class="col-md-6">
      <div class="form-group">
        <label for="idDesc">Descrição: </label>
            <input class="form-control" type="text" name="descricao" id="idDesc" required="" value="<?php echo $dados['descricao']; ?>"/>
      </div>
    </div>     
  </div>

<!-- Linha 2 -->
<div class="row">

    <div class="col-md-3">
        <div class="form-group">
            <label for="idDataLancamento">Data Venda: </label>
                <input class="form-control" type="date" name="data_venda" id="idDataLancamento" required="" value="<?php echo $dados['data_venda']; ?>"/>
        </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="idDataVencimento">Data Vencimento: </label>
            <input class="form-control" type="date" name="data_venc" id="idDataVencimento" required="" value="<?php echo $dados['data_venc']; ?>"/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idQnt">Qnt.:</label>
          <input class="form-control" type="number" name="qnt" id="idQnt" required="" value="<?php echo $dados['qnt']; ?>"/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idValorUnitario">Valor Uni.:</label>
          <input class="form-control" type="number" step="0.01" min="0.01" name="vlr_uni" id="idValorUnitario" required="" value="<?php echo $dados['valor_unitario']; ?>"/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idPago">Pago:</label>
            <select id="idPago" name="pago" class="form-control" required="">
                <option></option>
                <?php
                  $bancoQuery->query("SELECT * FROM vendas WHERE id_venda = $codVenda");
                  foreach ($bancoQuery->result() as $dadosPago){}
                  $status = $dadosPago['pago'];

                  if ($status == 1){
                    echo "<option value='0'>Não</option>";
                    echo "<option value='1' selected>Sim</option>";
                  }else{
                    echo "<option value='0' selected>Não</option>";
                    echo "<option value='1'>Sim</option>";
                  }
                ?>
            </select>
      </div>
    </div>

</div>

<div class="row">
    <!-- <div class="col-md-4">
      <div class="form-group-file">
          <input id="idFoto" type="file" name="arquivo" class="mt-2">
      </div>
    </div>   -->
</div>

  <!-- Linha 3 -->
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="idObs">Observações:</label>
        <textarea id="idObs" name="obs" class="form-control" rows="4">
        <?php echo $dados['obs']; ?>
        </textarea>
      </div>
    </div>
  </div>

</form>

<div class="row">
  <div class="col-md-12">
    <?php

      if ($_SERVER["REQUEST_METHOD"] == 'POST')
      {
        $servico = addslashes($_POST["servico"]);
        $descricao = addslashes($_POST["descricao"]);
        $dtVenda = addslashes($_POST["data_venda"]);
        $dataVenc = addslashes($_POST["data_venc"]);
        $qnt = addslashes($_POST["qnt"]);
        $vlr_uni = addslashes($_POST["vlr_uni"]);
        $pago = addslashes($_POST["pago"]);
        $obs = addslashes($_POST["obs"]);

        $CodVendaDB = $dados['id_venda'];

        $banco->query("UPDATE vendas SET data_venc = '$dataVenc', data_venda = '$dtVenda', descricao = '$descricao', obs = '$obs', pago = $pago, qnt = $qnt, servico = '$servico', valor_unitario = $vlr_uni WHERE id_venda = '$CodVendaDB'");

        $total = $banco->linhas();

        if ($total != 0)
        {
          echo "<div class='alert alert-info'>Venda Lançacada</div>";
          echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=8'/>";
        }else
        {
          echo "<div class='alert alert-danger'>Impossível inserir dados.</div>";
        }
      }
    ?>
  </div>
</div>
</div>