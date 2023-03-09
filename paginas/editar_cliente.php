<?php
  include_once("funcoes/funcoes.php");
  $banco = new BancoDeDados;
  $clienteId = $_GET['cliente'];
  $banco->query("SELECT * FROM clientes where id = ".$clienteId);
  foreach ($banco->result() as $dados) {}

?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-user-plus"></li> Editar Aluno <?php echo $dados['nome']; ?></h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form method="post" onsubmit="btnEnvia.disabled=true">

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

    <div class="col-md-5">
      <div class="form-group">
        <label for="idNome">Nome:</label>
          <input value="<?php echo $dados['nome']; ?>" class="form-control" type="text" name="nome" id="idNome" required=""/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="tipoempresa">Empresa?</label>
            <?php
                if ($dados["p_juridica"] == 1){
                    $vlr = 1;
                }else{
                    $vlr = 0;
                }
            ?>
                <select name="tipoempresa" id="tipoempresaId" class="form-control">
                    <option value="1" <?php verSelecao(1,$vlr);?> >Sim</option>
                    <option value="0" <?php verSelecao(0,$vlr);?>>Não</option>
                </select>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idCNPJ">CNPJ/CPF:</label>
          <input value="<?php echo $dados['cnpjcpf']; ?>" class="form-control" type="text" name="cnpjcpf" id="idCNPJ"/>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="idEmail">E-mail:</label>
          <input value="<?php echo $dados['email']; ?>" class="form-control" type="text" name="email" id="idEmail"/>
      </div>
    </div>
</div>

  <!-- Linha 2 -->
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="idTelefone">Telefone:</label>
          <input value="<?php echo $dados['telefone']; ?>" class="form-control" type="text" name="telefone" id="idTelefone" minlength="10" maxlength="10" pattern="[0-9]+$"/>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <label for="idCelular">Celular:</label>
          <input value="<?php echo $dados['celular']; ?>" class="form-control" type="text" name="celular" id="idCelular" required="" minlength="11" maxlength="11" pattern="[0-9]+$"/>
      </div>
    </div>
  </div>

  <hr/>

  <!-- Linha 3 -->
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="idObs">Observações:</label>
        <textarea id="idObs" name="obs" class="form-control" rows="4"><?php echo $dados['obs']; ?></textarea>
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

        $banco->query("UPDATE clientes SET nome ='$nome', cnpjcpf = '$cnpj', telefone = '$telefone', celular = '$celular', email = '$email', p_juridica = '$juridica', obs = '$obs' WHERE id = '$clienteId';");

        $total = $banco->linhas();

        if ($total != 0)
        {
          echo "<div class='alert alert-info'>Registro alterado com sucesso</div>";
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