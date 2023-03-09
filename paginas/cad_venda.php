<?php
  $banco = new BancoDeDados;
?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-list"></li> Cadastrar Venda</h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form action="index.php?pg=7&action=salvar-registro" method="post" onsubmit="btnEnvia.disabled=true" autocomplete="off" enctype="multipart/form-data">


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

    <div class="col-md-3">
      <div class="form-group">
        <label for="idCliente">Cliente:</label>
            <select class="form-control" required="" name="cliente" id="idCliente">
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
        <label for="idServico">Serviço: </label>
            <!-- <input class="form-control" type="text" name="servico" id="idServico" required=""/> -->
            <select class="form-control" required="" name="servico" id="idCliente">
                <option></option>
                <?php
                $banco->query("SELECT id_servico, servico FROM servicos");

                    foreach ($banco->result() as $dados)
                    {
                      echo "<option value=".$dados['id_servico'].">".$dados['servico']."</option>";
                    }
                ?>
            </select>
      </div>
    </div>   

    <div class="col-md-6">
      <div class="form-group">
        <label for="idDesc">Descrição: </label>
            <input class="form-control" type="text" name="descricao" id="idDesc" required=""/>
      </div>
    </div>     
  </div>

<!-- Linha 2 -->
<div class="row">

    <div class="col-md-3">
        <div class="form-group">
            <label for="idDataLancamento">Data Venda: </label>
                <input class="form-control" type="date" name="data_venda" id="idDataLancamento" required=""/>
        </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="idDataVencimento">Data Vencimento: </label>
            <input class="form-control" type="date" name="data_venc" id="idDataVencimento" required=""/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idQnt">Qnt.:</label>
          <input class="form-control" type="number" name="qnt" id="idQnt" required=""/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idValorUnitario">Valor Uni.:</label>
          <input class="form-control" type="number" step="0.01" min="0.01" name="vlr_uni" id="idValorUnitario" required=""/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idPago">Pago:</label>
            <select id="idPago" name="pago" class="form-control" required="">
                <option></option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
      </div>
    </div>

</div>

<div class="row">
    <div class="col-md-4">
      <div class="form-group-file">
          <input id="idFoto" type="file" name="arquivo" class="mt-2">
      </div>
    </div>  
</div>

  <!-- Linha 3 -->
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="idObs">Observações:</label>
        <textarea id="idObs" name="obs" class="form-control" rows="4"></textarea>
      </div>
    </div>
  </div>

</form>

<div class="row">
  <div class="col-md-12">
    <?php

      if ($_SERVER["REQUEST_METHOD"] == 'POST')
      {
        $codCli = addslashes($_POST["cliente"]);
        $servico = addslashes($_POST["servico"]);
        $descricao = addslashes($_POST["descricao"]);
        $dtVenda = addslashes($_POST["data_venda"]);
        $dataVenc = addslashes($_POST["data_venc"]);
        $qnt = addslashes($_POST["qnt"]);
        $vlr_uni = addslashes($_POST["vlr_uni"]);
        $pago = addslashes($_POST["pago"]);
        $obs = addslashes($_POST["obs"]);

        if(isset($_FILES['arquivo'])){

          $extensao = strtolower(substr($_FILES['arquivo']['name'], -4)); //pega a extensao do arquivo
          $novo_nome = md5(time()) . $extensao; //define o nome do arquivo
          $diretorio = "upload/"; //define o diretorio para onde enviaremos o arquivo
      
          move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome); //efetua o upload
      
        }

        $banco->query("INSERT INTO vendas VALUES('', '$codCli', '$servico', '$descricao', '$dtVenda', '$dataVenc', '$qnt', '$vlr_uni', '$pago', '$obs', '$novo_nome')");

        $total = $banco->linhas();

        if ($total != 0)
        {
          echo "<div class='alert alert-info'>Venda Lançacada</div>";
          echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=7'/>";
        }else
        {
          echo "<div class='alert alert-danger'>Impossível inserir dados.</div>";
        }
      }
    ?>
  </div>
</div>
</div>