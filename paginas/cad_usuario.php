<?php
  $banco = new BancoDeDados;
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-user-plus"></li> Cadastrar Usuário</h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form action="" method="post" id="cadUsuario">

  <div class="row">
    <div class="col-md-2 mb-4">
      <button onclick="btnEnvia.disabled=true" name="btnEnvia" class="btn btn-info form-control" id="salvar"><li class="fa fa-plus"></li> Cadastrar</button>
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

    <div class="col-md-3">
      <div class="form-group">
        <label for="idUsuario">Usuário:</label>
          <input class="form-control" type="text" name="usuario" id="idUsuario" required=""/>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="idSenha">Senha:</label>
          <input class="form-control" type="password" name="senha" id="idSenha" required=""/>
      </div>
    </div>

  </div>

</form>

<div class="row mt-2">
  <div class="col-md-12">
      <h5 class="cor-txt-padrao"><li class="fa fa-user"></li> Usuários</h5>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
<!-- Tabela -->
<table id="exemple" class="table">
    <thead class="cor-txt-padrao">
      <!--<th scope="col">#</th>-->
      <th scope="col">ID</th>
      <th scope="col">Nome</th>
      <th scope="col">Usuário</th>
    </thead>
      <tbody>
        <tr>

          <?php

          $banco->query("SELECT id, nome, usuario FROM usuarios ORDER BY id");
          $total = $banco->linhas();

              if ($total != 0)
              {
                foreach ($banco->result() as $dados)
                {
            ?>
                  <!--<th scope="row"><?php /*echo $dados['id']; */?></th>-->
                  <td><?php echo $dados['id']; ?></td>
                  <td><?php echo $dados['nome']; ?></td>
                  <td><?php echo $dados['usuario']; ?></td>
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

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        /// Quando usuário clicar em salvar será feito todos os passo abaixo
        $('#salvar').click(function() {

            var dados = $('#cadUsuario').serialize();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'paginas/cadastrar.php?action=gravar',
                async: true,
                data: dados,
                success: function(response) {
                    location.reload();
                },
                error: function(response){
                  alert('Preencha usuário e senha');
                  document.querySelector('#salvar').disabled=false;
                }
            });

            return false;
        });
    })
</script>
</div>