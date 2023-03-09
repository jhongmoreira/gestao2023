<?php
  $banco = new BancoDeDados;
  include_once("funcoes/funcoes.php");
  $lista = (isset($_GET['lista']))? $_GET['lista'] : 1;
  $banco->query("select * from clientes");
  $total = $banco->linhas();
  $registros = 10;
  $numPaginas = ceil($total/$registros);
  $inicio = ($registros*$lista)-$registros;

?>

<div class="container-fluid">
<!-- Título -->
<div class="row p-2">
  <div class="col-md-12 cor-txt-padrao">
    <h5><li class="fa fa-search"></li> Consultar Clientes</h5>
    <hr/>
  </div>
</div>

<!-- DIV opções -->
<form action="index.php?pg=3&action=listar-todos" method="post">
  <div class="row">
    <div class="col-md-2 mb-4">
      <button name="btnrelatorio" class="btn btn-warning form-control"><li class="fa fa-book"></li> Gerar Relatório</button>
    </div>
  </div>
</form>


<!-- DIV buscar alunos por nome -->
<form action="index.php?pg=3&action=busca-nome" method="post">
  <div class="row mb-3">

    <div class="col-md-10">
      <div class="form-group">
        <input type="text" class="form-control" name="nome" placeholder="Nome do aluno ou termo de busca"/>
      </div>
    </div>

      <div class="col-md-2">
        <button class="btn btn-primary form-control"><li class="fa fa-search"></li> Buscar</button>
      </div>
  </div>
</form>


  <!-- Tabela -->
  <table id="exemple" class="table">
    <thead class="cor-txt-padrao">
      <!--<th scope="col">#</th>-->
      <th scope="col">Nome</th>
      <th scope="col">Telefone</th>
      <th scope="col">Celular</th>
      <th scope="col">Ações</th>
    </thead>
      <tbody>
        <tr>

          <?php

          if (!isset($_GET['action']))
          {
            $_GET['action'] = '';
          }

          $acao = $_GET["action"];

          if ($acao == 'listar-todos')
          {
            $banco->query("SELECT id, nome, telefone, celular FROM clientes ORDER BY id limit $inicio, $registros");
          }

          if ($acao == 'busca-nome')
            {
              @$nome_cliente = $_POST["nome"];
              $banco->query("SELECT id, nome, telefone, celular FROM clientes WHERE nome LIKE '%".$nome_cliente."%'");
              $msg = '';
            }

          if ($acao == '')
          {
            $banco->query("SELECT id, nome, telefone, celular FROM clientes ORDER BY id LIMIT 10");
          }

              $total = $banco->linhas();

              if ($total != 0)
              {
                foreach ($banco->result() as $dados)
                {
            ?>
                  <!--<th scope="row"><?php /*echo $dados['id']; */?></th>-->
                  <td><?php echo $dados['nome']; ?></td>
                  <td><?php echo @formatar('(%s%s) %s%s%s%s-%s%s%s%s', @$dados['telefone']); ?></td>
                  <td><?php echo @formatar('(%s%s) %s%s%s%s%s-%s%s%s%s', $dados['celular']); ?>  <a alt="Abrir em Whatsapp Web" target="_blank" href="https://api.whatsapp.com/send?phone=55<?php echo $dados['celular']; ?>"><li class="fa fa-external-link"></li></a></td>
                  <td>
                    <a class="cor-warning p-1" href="index.php?pg=6&cliente=<?php echo $dados['id']; ?>"><li class="fa fa-edit"></li></a></button>
                    <a class="cor-danger p-1" href="index.php?pg=5&cliente=<?php echo $dados['id']; ?>"><li class="fa fa-trash"></li></button></a>
                    <a class="cor-info p-1" href="index.php?pg=4&cliente=<?php echo $dados['id']; ?>"><li class="fa fa-eye"></li></button></a>
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
            echo "<a class='btn btn-info mb-1' href='index.php?pg=3&action=listar-todos&lista=$i'>".$i."</a> ";
          }
        ?>
      </div>
    </div>
  </div>