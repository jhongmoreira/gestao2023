<?php
$banco = new BancoDeDados;
?>

<div class="container-fluid">
  <!-- Título -->
  <div class="row p-2">
    <div class="col-md-12 cor-txt-padrao">
      <h5>
        <li class="fa fa-print"></li> Faturar Vendas
      </h5>
      <hr />
    </div>
  </div>

  <!-- DIV opções -->
  <form action="index.php?pg=16&action=salvar-registro" method="post" autocomplete="off" enctype="multipart/form-data" id="formulario" onsubmit="oculta();">


    <div class="row">
      <div class="col-md-2 mb-4">
        <button type="submit" name="btnEnvia" class="btn btn-info form-control" id="btnEnviar">
          <li class=" fa fa-print"></li> Gerar Fatura
        </button>
      </div>

      <div class="col-md-2 mb-8">
        <!-- Coluna ajuste -->
      </div>
    </div>

    <!-- Linha 1 -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="idCliente">Cliente:</label>
          <select class="form-control" required="" name="cliente" id="idCliente">
            <option></option>
            <?php
            $banco->query("SELECT id, nome FROM clientes");

            foreach ($banco->result() as $dados) {
              echo "<option value=" . $dados['id'] . ">" . $dados['nome'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>


      <div class="col-md-3">
        <div class="form-group">
          <label for="idDataInicio">Data Inicial: </label>
          <input class="form-control" type="date" name="data_inicio" id="idDataInicio" required="" />
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label for="idDataFim">Data Final: </label>
          <input class="form-control" type="date" name="data_fim" id="idDataFim" required="" />
        </div>
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-md-3">
        <div class="form-group">
          <label for="idFormaPg">Forma de Pagamento: </label>
          <select class="form-control" name="forma_pg" id="idFormaPg" required="">
            <option value="PIX">PIX</option>
            <option value="BOLETO">Boleto Bancário</option>
            <option value="TED">TED/DOC</option>
            <option value="DINHEIRO">Dinheiro</option>
          </select>
        </div>
      </div>

      <div class="col-md-9">
        <div class="form-group">
          <label for="idObsPg">OBS.: </label>
          <input class="form-control" type="text" name="obs_pg" id="idObsPg" required="" />
        </div>
      </div>

    </div>




  </form>

  <div class="row">
    <div class="col-md-12">
      <table id="exemple" class="table">
        <thead class="cor-txt-padrao">
          <th scope="col">Empresa</th>
          <th scope="col">CNPJ</th>
          <th scope="col">Ação</th>
        </thead>
        <tbody>
          <tr>
            <?php

            if ($_SERVER["REQUEST_METHOD"] == 'POST') {

              $idCli = addslashes($_POST["cliente"]);
              $dataInicio = addslashes($_POST["data_inicio"]);
              $dataFim = addslashes($_POST["data_fim"]);
              $formaPG = addslashes($_POST["forma_pg"]);
              $obsPG = addslashes($_POST["obs_pg"]);

              $banco->query("SELECT * FROM vendas, clientes, servicos WHERE vendas.cliente = clientes.id AND pago = 0 AND vendas.servico = servicos.id_servico AND clientes.id = $idCli AND vendas.data_venda BETWEEN '$dataInicio' AND '$dataFim'");

              // var_dump($banco);

              $total = $banco->linhas();


              if ($total != 0) {
                foreach ($banco->result() as $dados) {
                }
                $id_cliente = $dados['id'];
                $id_venda = $dados['id_venda'];
            ?>
                <td><?php echo $dados['nome']; ?></td>
                <td><?php echo $dados['cnpjcpf']; ?></td>
                <td>
                  <a href="index.php?pg=17&cliente=1&data_inicio=<?php echo $dataInicio; ?>&data_fim=<?php echo $dataFim; ?>&forma=<?php echo $formaPG; ?>&obs=<?php echo $obsPG; ?>"><button class="btn btn-info">Vizualizar</button></a>
                </td>

          </tr>
        <?php
              }
        ?>
      <?php
            } else {
              echo "Nada encontrado";
            }
      ?>
    </div>
  </div>