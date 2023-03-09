<?php
  include_once('classes/database.php');
  $id_orcamento = $_GET['orcamento'];
  $banco = new BancoDeDados;
?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-user-plus"></li> Cadastrar Orçamento</h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form action="index.php?pg=13&orcamento=<?php echo $id_orcamento; ?>&action=salvar-registro" method="post" onsubmit="btnEnvia.disabled=true" autocomplete="off">

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
        <label for="idProduto">Produto: </label>
            <select class="form-control" required="" name="produto" id="idProduto">
                <option></option>
                <?php
                $banco->query("SELECT id_servico, servico FROM servicos");

                    foreach ($banco->result() as $dados)
                    {
                      echo "<option value=".$dados['id_servico'].">".$dados['servico']."</option>";
                    }
                ?>
            </select>
      </div>
    </div>   

    <div class="col-md-6">
      <div class="form-group">
        <label for="idQnt">Qnt.: </label>
         <input class="form-control" type="number" name="qnt" id="idQnt" required=""/>
      </div>
    </div> 
  </div>
</form>

<div class="row">
  <div class="col-md-12">
    <?php

      if ($_SERVER["REQUEST_METHOD"] == 'POST')
      {
        $id_orc = $id_orcamento;
        $produto = addslashes($_POST["produto"]);
        $quantidade = addslashes($_POST["qnt"]);

        $banco->query("INSERT INTO itens_orcamento VALUES('', '$id_orc', '$produto', '$quantidade')");
        
        $total = $banco->linhas();

        if ($total != 0)
        {
          // echo "<div class='alert alert-info'>Registro inserido com sucesso</div>";
          // echo "<meta http-equiv='refresh' content='1;URL=index.php?pg=13&orcamento=$id_orcamento'/>";
        }else
        {
          echo "<div class='alert alert-danger'>Impossível inserir dados.</div>";
        }
      }
    ?>
  </div>
</div>
<div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="idProduto"><b>Produto: </b></label>
            <?php
            $banco->query("SELECT * FROM orcamento, clientes WHERE orcamento.empresa_cod = clientes.id AND orcamento.id_orcamento = $id_orcamento LIMIT 1");

                foreach ($banco->result() as $dados)
                {
                    echo $dados['nome'];
                }
            ?>
        </div>
    </div>

    <div class="col-md-8">
      <div class="form-group">
        <label for="idProduto"><b>Data do orçamento: </b></label>
            <?php
            $banco->query("SELECT * FROM orcamento, clientes WHERE orcamento.empresa_cod = clientes.id AND orcamento.id_orcamento = $id_orcamento LIMIT 1");

                foreach ($banco->result() as $dados)
                {
                    $data_Venc = new DateTime($dados['data_orcamento']); // Pega o momento atual
                    echo $data_Venc->format('d/m/Y'); // Exibe no formato desejado
                }
            ?>
        </div>
    </div>
</div>


<div class="row mt-2">
  <div class="col-md-12">
    <h5 class="cor-txt-padrao"><li class="fa fa-clock"></li> Itens deste Orçamento</h5>
<!-- Tabela -->
<table id="exemple" class="table">
    <thead class="cor-txt-padrao">
      <th scope="col">Produto</th>
      <th scope="col">Qnt.</th>
      <th scope="col">Valor Unitario</th>
      <th scope="col">Valor Total</th>
    </thead>
      <tbody>
        <tr>

          <?php


            $banco->query("SELECT * FROM itens_orcamento, orcamento, servicos WHERE itens_orcamento.orcamento_cod = orcamento.id_orcamento AND itens_orcamento.produto_id = servicos.id_servico AND orcamento.id_orcamento = $id_orcamento");

            $total = $banco->linhas();

              if ($total != 0)
              {
                foreach ($banco->result() as $dados)
                {
            ?>
                  <td><?php echo $dados['servico']; ?></td>
                  <td><?php echo $dados['qnt_iten']; ?></td>
                  <td><?php echo 'R$ '.number_format($dados['valor_uni'],2, ',', '.');?></td>
                  <td><?php echo 'R$ '.number_format($dados['valor_uni']*$dados['qnt_iten'],2, ',', '.');?></td>
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
   $banco->query("SELECT SUM(valor_uni*qnt_iten) as total_soma FROM itens_orcamento, servicos, orcamento WHERE orcamento.id_orcamento = itens_orcamento.orcamento_cod AND servicos.id_servico = itens_orcamento.produto_id AND orcamento.id_orcamento = $id_orcamento");
   foreach ($banco->result() as $dados){}
?>

<div class="row">
    <div class="col-md-6">
        <label class="label-detalhes mb-0" for="idTotal">Total:</label>
        <div id="idTotal">
            <?php
                echo 'R$ '.number_format($dados['total_soma'],2, ',', '.');
            ?>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-1">
        <form>
            <a href="index.php?pg=14&orcamento=<?php echo $id_orcamento; ?>"><input id="idImprimir" type="button" value="Imprimir" class="form-control button btn-secondary"/></a>
        </form>
    </div>
</div>
</div>