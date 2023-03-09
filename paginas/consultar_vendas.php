<?php
  $banco = new BancoDeDados;
  include_once("funcoes/funcoes.php");
  $lista = (isset($_GET['lista']))? $_GET['lista'] : 1;
  $banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND vendas.servico = servicos.id_servico");
  $total = $banco->linhas();
  $registros = 10;
  $numPaginas = ceil($total/$registros);
  $inicio = ($registros*$lista)-$registros;

  if (!isset($_GET['action']))
  {
    $_GET['action'] = '';
  }

  $acao = $_GET["action"];
?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-search"></li> Consultar Vendas
      <?php 
      if ($acao == 'aberto'){
        echo ' em Aberto'; 
      }else{
        if($acao == 'pago'){
        echo ' Pagas';
        }
      }
      ?>
    </h5>
  </div>
</div>
  <!-- Tabela -->
  <table id="exemple" class="table">
    <thead class="cor-txt-padrao">
      <!--<th scope="col">#</th>-->
      <th scope="col">Empresa</th>
      <th scope="col">Serviço</th>
      <th scope="col">Vencimento</th>
      <th scope="col">Valor</th>
    </thead>
      <tbody>
        <tr>

          <?php

          if ($acao == 'listar-todos')
          {
            $banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND vendas.servico = servicos.id_servico ORDER BY vendas.id_venda LIMIT $inicio, $registros");
          }

          if ($acao == 'aberto')
          {
            $banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND pago = 0 AND vendas.servico = servicos.id_servico ORDER BY vendas.id_venda LIMIT $inicio, $registros");
          }

          if ($acao == 'pago')
          {
            $banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND pago = 1 AND vendas.servico = servicos.id_servico ORDER BY vendas.id_venda LIMIT $inicio, $registros");
          }

              $total = $banco->linhas();

              if ($total != 0)
              {
                foreach ($banco->result() as $dados)
                {
                  $id_cliente = $dados['id'];
                  $id_venda = $dados['id_venda'];
            ?>
                  <!--<th scope="row"><?php /*echo $dados['id']; */?></th>-->
                  <td><?php echo $dados['nome']; ?></td>
                  <td><a href="index.php?pg=9&cliente=<?php echo $id_cliente;?>&venda=<?php echo $id_venda;?>"><li class="fa fa-folder"></li><?php echo ' '.$dados['servico']; ?></a></td>
                  <td>
                      <?php
                        $data_Venc = new DateTime($dados['data_venc']); // Pega o momento atual
                        echo $data_Venc->format('d/m/Y'); // Exibe no formato desejado
                      ?>
                </td>
                  <td>
                      <?php 
                        $valor_total = $dados['valor_unitario']*$dados['qnt'];
                        echo 'R$ '.number_format($valor_total,2, ',', '.'); 
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

    <div class="mb-5 row" style="text-align: center;">
      <div class="col-md-12">
        <?php
          for($i = 1; $i < $numPaginas + 1; $i++)
          {
            echo "<a class='btn btn-info mb-1' href='index.php?pg=8&action=$acao&lista=$i'>".$i."</a> ";
          }
        ?>
      </div>
    </div>

    </div>
  </div>