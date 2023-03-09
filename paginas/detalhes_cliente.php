<?php
  include_once("funcoes/funcoes.php");
  $banco = new BancoDeDados;
  $clienteId = (int)$_GET['cliente'];
  $banco->query("SELECT * FROM clientes where id = ".$clienteId);
  foreach ($banco->result() as $dados) {}
?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-eye"></li> <b>Empresa: </b> <?php echo $dados['nome']; ?></h5>
    <hr/>
  </div>
</div>

<!-- Linha 1 -->
<div class="row mb-2">
  <div class="col-md-3 mb-2">
      <label class="label-detalhes mb-0" for="nome">Nome:</label>
        <div id="nome">
          <?php          
            if ($dados["p_juridica"] == 0)
            {
              echo "<span class='badge badge-primary'>Física</span>";
            }else  
            {
              echo "<span class='badge badge-secondary'>Jurídica</span>";
            }

            echo " ".$dados["nome"]; 
          ?>
        </div>
  </div>

  <div class="col-md-2 mb-2">
      <label class="label-detalhes mb-0" for="email">CNPJ/CPF:</label>
        <div id="cnpj"><?php echo $dados["cnpjcpf"]; ?></div>
  </div>

  <div class="col-md-2 mb-2">
      <label class="label-detalhes mb-0" for="email">E-mail:</label>
        <div id="email"><?php echo $dados["email"]; ?></div>
  </div>

  <div class="col-md-2 mb-2">
      <label class="label-detalhes mb-0" for="telefone">Telefone:</label>
        <div id="telefone"><?php echo @formatar('(%s%s) %s%s%s%s-%s%s%s%s', $dados["telefone"]); ?></div>
  </div>

  <div class="col-md-2 mb-2">
      <label class="label-detalhes mb-0" for="celular">Celular:</label>
        <div id="celular"><?php echo @formatar('(%s%s) %s%s%s%s%s-%s%s%s%s', $dados["celular"]); ?> </div>
  </div>

</div>

<hr/>

<div class="row">
  <div class="col-md-12">
    <label class="label-detalhes mb-0" for="obs">Observações:</label>
      <div id="obs">

        <?php
          if ($dados["obs"] == '')
          {
            echo "<i>Nenhuma observação inserida para este cliente.</i>";
          }else

          {
            echo $dados["obs"];
          }
        ?>

      </div>
  </div>
</div>

<!-- Tabela -->
<div class="row mt-5">
  <div class="col-md-12">
    <h5 class="cor-txt-padrao"><li class="fa fa-clock"></li> Ultimas movimentações</h5>
<!-- Tabela -->
<table id="exemple" class="table">
    <thead class="cor-txt-padrao">
      <th scope="col">COD</th>
      <th scope="col">Empresa</th>
      <th scope="col">Serviço</th>
      <th scope="col">Vencimento</th>
      <th scope="col">Valor</th>
      <th scope="col">Ações</th>
    </thead>
      <tbody>
        <tr>

          <?php


            $banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND clientes.id = $clienteId AND vendas.servico = servicos.id_servico ORDER BY vendas.id_venda");

            $total = $banco->linhas();

              if ($total != 0)
              {
                foreach ($banco->result() as $dados)
                {
                  $idVenda = $dados['id_venda'];
            ?>
                  <td><a href="index.php?pg=9&cliente=<?php echo $clienteId; ?>&venda=<?php echo $idVenda ?>"><?php echo $idVenda ?></a></td>
                  <td><?php echo $dados['nome']; ?></td>
                  <td><?php echo $dados['servico']; ?></td>
                  <td <?php //if ($dados['pago'] == 1){ echo "style='background-color:green'";}else{echo "style='background-color:red'";}?> >
                      <?php
                        $data_Venc = new DateTime($dados['data_venc']); // Pega o momento atual
                        echo $data_Venc->format('d/m/Y'); // Exibe no formato desejado
                      ?>
                </td>
                  <td>
                      <?php 
                        $valor_total = $dados['valor_unitario']*$dados['qnt'];
                        echo 'R$ '.number_format($valor_total,2, ',', '.').' '; 

                        if ($dados['pago'] == 1){ 
                          echo "<span class='badge badge-success'>Pago</span>";
                          }                        
                      ?>
                    </td>
                    <td>
                    <?php 
                      if ($dados['pago'] == 0)
                      { 
                        echo "<a href='index.php?pg=4&cliente=$clienteId&baixar=$idVenda' class='text-success'><li class='fa fa-check-circle'></li></a>";
                        }else{
                          echo "<a href='index.php?pg=4&cliente=$clienteId&refaturar=$idVenda' class='text-danger'><li class='fa fa-times-circle'></li></a>";
                      }
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
</div>
</div>

<?php
  @$idBaixa = $_GET['baixar'];
  if(isset($idBaixa)){
    $banco->query('UPDATE vendas SET pago = 1 WHERE id_venda = '.$idBaixa);
    unset($idBaixa);
    echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=4&cliente=$clienteId'/>";
  }

  @$idRefaturar = $_GET['refaturar'];
  if(isset($idRefaturar)){
    $banco->query('UPDATE vendas SET pago = 0 WHERE id_venda = '.$idRefaturar);
    unset($idRefaturar);
    echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=4&cliente=$clienteId'/>";
  }
?>
</div>