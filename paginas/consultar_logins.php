<?php
  $banco = new BancoDeDados;
  include_once("funcoes/funcoes.php");
  $lista = (isset($_GET['lista']))? $_GET['lista'] : 1;
?>

<div class="container-fluid">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-search"></li> Consultar Logins</h5>
  </div>
</div>
  <!-- Tabela -->
  <table id="exemple" class="table">
    <thead class="cor-txt-padrao">
      <!--<th scope="col">#</th>-->
      <th scope="col">Usuário</th>
      <th scope="col">Data</th>
      <th scope="col">Hora</th>
    </thead>
      <tbody>
        <tr>

          <?php

          if (!isset($_GET['action']))
          {
            $_GET['action'] = '';
          }

          $acao = $_GET["action"];

          if ($acao == '')
          {
            $banco->query("SELECT usuarios.id, usuarios.nome, login_erp.cod_user, DATE_FORMAT(login_erp.data_acesso,'%d/%m/%Y') as data_acesso_user, login_erp.hora_acesso FROM usuarios INNER JOIN login_erp ON usuarios.id = login_erp.cod_user ORDER BY data_acesso_user DESC");
          }
              $total = $banco->linhas();

              if ($total != 0)
              {
                foreach ($banco->result() as $dados)
                {
            ?>
                  <!-- <td><?php //echo $dados['ipcli']; ?></td> -->
                  <td><?php echo $dados['nome']; ?></td>
                  <td><?php echo $dados['data_acesso_user']; ?></td>
                  <td><?php echo $dados['hora_acesso']; ?></td>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </div>