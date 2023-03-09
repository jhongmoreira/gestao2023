<?php
include_once("funcoes/funcoes.php");
$banco = new BancoDeDados;
$idCli = (int)$_GET['cliente'];
$dataInicial = $_GET['data_inicio'];
$dataFim = $_GET['data_fim'];
$obs = $_GET['obs'];
$forma = $_GET['forma'];
$banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND pago = 0 AND vendas.servico = servicos.id_servico AND clientes.id = $idCli");
foreach ($banco->result() as $dados) {
}
?>

<div class="container-fluid">
  <!-- Título -->
  <div class="row p-2">
    <div class="col-md-10 cor-txt-padrao">
      <h5>
        <li class="fa fa-eye"></li> <b>Empresa: </b>
        <?php
        echo $dados['nome'] . " ";
        if ($dados["p_juridica"] == 0) {
          echo "<span class='badge badge-primary'>Física</span>";
        } else {
          echo "<span class='badge badge-secondary'>Jurídica</span>";
        }
        ?>
      </h5>
    </div>

    <div class="col-md-2">
      <input class="form-control button btn-secondary" type="button" value="Imprimir" onClick="window.print()" />
    </div>


  </div>
  <hr />
  <!-- Linha 1 -->
  <div class="row mb-2">
    <div class="col-md-2 mb-2">
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

  <div class="row mb-2">

    <div class="col-md-2 mb-2">
      <label class="label-detalhes mb-0" for="nome">Data de Vencimento:</label>
      <div id="nome">
        <?php
        echo dataFormato($dados["data_venc"]);
        ?>
      </div>
    </div>

    <div class="col-md-3 mb-2">
      <label class="label-detalhes mb-0" for="nome">Forma de Pagamento: </label>
      <div id="nome">
        <?php
        echo $forma;
        ?>
      </div>
    </div>

    <div class="col-md-7 mb-2">
      <label class="label-detalhes mb-0" for="nome">OBS.: </label>
      <div id="nome">
        <?php
        echo $obs;
        ?>
      </div>
    </div>

  </div>


  <hr />

  <div class="row">
    <div class="col-md-12">
      <label class="label-detalhes mb-0" for="obs">Observações:</label>
      <div id="obs">

        <?php
        if ($dados["obs"] == '') {
          echo "<i>Nenhuma observação inserida para este cliente.</i>";
        } else {
          echo $dados["obs"];
        }
        ?>

      </div>
    </div>
  </div>

  <!-- Tabela -->
  <div class="row mt-5">
    <div class="col-md-12">
      <h5 class="cor-txt-padrao">
        <li class="fa fa-clock"></li> Ultimas movimentações
      </h5>
      <!-- Tabela -->
      <!-- Tabela -->
      <table id="exemple" class="table">
        <thead class="cor-txt-padrao">
          <th scope="col">Data de Venda</th>
          <th scope="col">Produto</th>
          <th scope="col">Qnt.</th>
          <th scope="col">Valor Unitario</th>
          <th scope="col">Valor Total</th>
        </thead>
        <tbody>
          <tr>

            <?php


            $banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND pago = 0 AND vendas.servico = servicos.id_servico AND clientes.id = $idCli AND data_venda BETWEEN '$dataInicial' AND '$dataFim'");

            $total = $banco->linhas();

            if ($total != 0) {
              foreach ($banco->result() as $dados) {
            ?>
                <td><?php echo dataFormato($dados['data_venda']); ?></td>
                <td><?php echo $dados['servico']; ?></td>
                <td><?php echo $dados['qnt']; ?></td>
                <td><?php echo 'R$ ' . number_format($dados['valor_unitario'], 2, ',', '.'); ?></td>
                <td><?php echo 'R$ ' . number_format($dados['valor_unitario'] * $dados['qnt'], 2, ',', '.'); ?></td>
          </tr>
      <?php
              }
            } else {
              echo "Nada encontrado";
            }
      ?>
      <tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row float-right">
    <div class="col-md-12">
      <b>Total Final</b>:

      <?php
      $banco->query("SELECT SUM(valor_unitario*qnt) as total_soma FROM vendas, servicos, clientes WHERE vendas.cliente = clientes.id AND vendas.pago = 0 AND vendas.servico = servicos.id_servico AND clientes.id = $idCli AND data_venda BETWEEN '$dataInicial' AND '$dataFim'");
      foreach ($banco->result() as $dados) {
      }
      echo ' R$ ' . number_format($dados['total_soma'], 2, ',', '.');
      ?>
      <div>
        <tr>
          </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
</div>