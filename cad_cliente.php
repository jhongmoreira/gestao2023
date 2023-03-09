<?php
  $banco = new BancoDeDados;
?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-user-plus"></li> Cadastrar Cliente</h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form action="index.php?pg=2&action=salvar-registro" method="post" onsubmit="btnEnvia.disabled=true" autocomplete="off">

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
        <label for="idNome">Nome:</label>
          <input class="form-control" type="text" name="nome" id="idNome" required=""/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idTipoCliente">Empresa?</label>
            <select id="idTipoCliente" name="tipoempresa" class="form-control" required="">
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label for="idCNPJCPF">CNPJ/CPF:</label>
          <input class="form-control" type="text" name="cnpjcpf" id="idCNPJCPF" required=""/>
      </div>
    </div>

  </div>

  <!-- Linha 2 -->
  <div class="row">
  <div class="col-md-2">
      <div class="form-group">
        <label for="idTelefone">Telefone:</label>
          <input class="form-control" type="text" name="telefone" id="idTelefone" minlength="10" maxlength="10" pattern="[0-9]+$"/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idCelular">Celular:</label>
          <input class="form-control" type="text" name="celular" id="idCelular" required="" minlength="11" maxlength="11" pattern="[0-9]+$"/>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label for="idEmail">E-mail:</label>
          <input class="form-control" type="email" name="email" id="idEmail"/>
      </div>
    </div>
  </div>

  <hr/>

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
        $nome = addslashes($_POST["nome"]);
        $cnpj = addslashes($_POST["cnpjcpf"]);
        $telefone = addslashes($_POST["telefone"]);
        $celular = addslashes($_POST["celular"]);
        $email = addslashes($_POST["email"]);
        $juridica = addslashes($_POST["tipoempresa"]);
        $obs = addslashes($_POST["obs"]);

        $banco->query("INSERT INTO clientes VALUES('', '$nome', '$cnpj', '$telefone', '$celular', '$email', '$juridica', '$obs')");

        $total = $banco->linhas();

        if ($total != 0)
        {
          echo "<div class='alert alert-info'>Registro inserido com sucesso</div>";
          echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=3'/>";
        }else
        {
          echo "<div class='alert alert-danger'>Impossível inserir dados.</div>";
        }
      }
    ?>
  </div>
</div>
</div>