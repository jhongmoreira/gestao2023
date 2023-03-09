<?php
  include_once("funcoes/funcoes.php");
  $banco = new BancoDeDados;
  $clienteId = (int)$_GET['cliente'];
  $codVenda = (int)$_GET['venda'];
  $banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND clientes.id = $clienteId AND id_venda = $codVenda AND vendas.servico = servicos.id_servico ORDER BY vendas.id_venda");
  foreach ($banco->result() as $dados) {}
?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-11 cor-txt-padrao">
    <h5><li class="fa fa-file"></li> <b>VENDA N°: </b> <?php echo $dados['id_venda']; ?></h5>
    <hr/>
  </div>

  <div class="col-md-1">
        <form>
            <input id="idImprimir" type="button" value="Imprimir" onClick="$('#idImprimir').hide(); window.print();" class="form-control button btn-secondary"/>
        </form>
    </div>
</div>

<!-- Linha 1 -->
<div class="row mb-2">
  <div class="col-md-3 mb-2">
      <label class="label-detalhes mb-0" for="nome">Nome:</label>
        <div id="nome">
          <?php          
            echo $dados["nome"]; 
          ?>
        </div>
  </div>

  <div class="col-md-2 mb-2">
      <label class="label-detalhes mb-0" for="email">CNPJ/CPF:</label>
        <div id="cnpj"><?php echo $dados["cnpjcpf"]; ?></div>
  </div>

  <div class="col-md-3 mb-2">
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

<hr>

<div class="row">

    <div class="col-md-1">
    <label class="label-detalhes mb-0" for="idCodVenda">N°:</label>
      <div id="idCodVenda">
        <?php
            echo $dados['id_venda'];
        ?>
      </div>
    </div>

    <div class="col-md-2">
    <label class="label-detalhes mb-0" for="idDataVenda">Data Venda:</label>
      <div id="idDataVenda">
        <?php
            dataFormato($dados['data_venda']);
        ?>
      </div>
    </div>

    <div class="col-md-2">
    <label class="label-detalhes mb-0" for="idDataVencimento">Data Vencimento:</label>
      <div id="idDataVencimento">
        <?php
            // echo $dados['data_venc'];
            dataFormato($dados['data_venc']);
        ?>
      </div>
    </div>
    
    <div class="col-md-4">
    <label class="label-detalhes mb-0" for="idServico">Item:</label>
      <div id="idDataVenda">
        <?php
            echo $dados['servico'];
        ?>
      </div>
    </div>

    <div class="col-md-1">
    <label class="label-detalhes mb-0" for="idQnt">Qnt:</label>
      <div id="idQnt">
        <?php
            echo $dados['qnt'];
        ?>
      </div>
    </div>

    <div class="col-md-2">
    <label class="label-detalhes mb-0" for="idQnt">Valor(UN):</label>
      <div id="idQnt">
        <?php
            moedaBR($dados['valor_unitario']);
        ?>
      </div>
    </div>

</div>

<div class="row mt-2">
    <div class="col-md-12">
    <label class="label-detalhes mb-0" for="idDescricao">Detalhes:</label>
      <div id="idDescricao">
        <?php
            echo $dados['descricao'];
        ?>
      </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-2">
    <label class="label-detalhes mb-0" for="idSituação">Situação:</label>
      <div id="idSituação">
        <?php
            if ($dados["pago"] == 0)
            {
                echo "Em Aberto";
            }else
            {
                echo "Pago";
            }
        ?>
      </div>
    </div>
</div>

<hr>

<div class="row mt-2">
    <div class="col-md-2">
    <label class="label-detalhes mb-0" for="idTotal"><b>Valor Total:</b></label>
      <div id="idTotal">
        <?php
            $totalVenda = $dados['valor_unitario']*$dados['qnt'];
            echo 'R$ '.number_format($totalVenda,2, ',', '.');
        ?>
      </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-8">
    <label class="label-detalhes mb-0" for="idFoto"><b>Arquivo:</b></label>
      <div id="idFoto">
        <?php
          if (@$img_upload == ''){
            echo "Nada anexado";
          }else{
            echo "<a href='upload/$img_upload'>Baixar</a>";
          }
        ?>
      </div>
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