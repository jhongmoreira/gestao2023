<?php
  $banco = new BancoDeDados;
  include_once("funcoes/funcoes.php");
  $lista = (isset($_GET['lista']))? $_GET['lista'] : 1;
  $banco->query("SELECT id, ipcli, pagina, DATE_FORMAT(data,'%d/%m/%Y') as data_acesso, hora FROM acessos_site");
  $total = $banco->linhas();
  $registros = 10;
  $numPaginas = ceil($total/$registros);
  $inicio = ($registros*$lista)-$registros;

?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-search"></li> Consultar Acessos</h5>
  </div>
</div>
  <!-- Tabela -->
  <table id="exemple" class="table">
    <thead class="cor-txt-padrao">
      <!--<th scope="col">#</th>-->
      <th scope="col">Página</th>
      <th scope="col">Data</th>
      <th scope="col">Hora</th>
      <th scope="col">IP</th>
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
            $banco->query("SELECT id, ipcli, pagina, DATE_FORMAT(data,'%d/%m/%Y') as data_acesso, hora FROM acessos_site  ORDER BY data_acesso DESC LIMIT 10");
          }

          if ($acao == 'listar-todos')
          {
            $banco->query("SELECT id, ipcli, pagina, DATE_FORMAT(data,'%d/%m/%Y') as data_acesso, hora FROM acessos_site  ORDER BY data limit $inicio, $registros");
          }



              $total = $banco->linhas();

              if ($total != 0)
              {
                foreach ($banco->result() as $dados)
                {
            ?>
                  <!-- <td><?php //echo $dados['ipcli']; ?></td> -->
                  <td><?php echo $dados['pagina']; ?></td>
                  <td><?php echo $dados['data_acesso']; ?></td>
                  <td><?php echo $dados['hora']; ?></td>
                  <td><?php echo $dados['ipcli']; ?></td>
          </tr>
            <?php
                }
              }else
              {
                echo "Nada encontrado";
              }
          ?>
      </tbody>
    </table>

    <div class="mb-5 row" style="text-align: center;">
      <div class="col-md-12">
        <?php
          for($i = 1; $i < $numPaginas + 1; $i++)
          {
            echo "<a class='btn btn-info mb-1' href='index.php?pg=1&action=listar-todos&lista=$i'>".$i."</a> ";
          }
        ?>
      </div>
    </div>