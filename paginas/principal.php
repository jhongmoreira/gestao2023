<?php
    $timezone = new DateTimeZone('America/Sao_Paulo');
    $agora = new DateTime('now', $timezone);
    $banco = new BancoDeDados;
    include_once('funcoes/funcoes.php');
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body"><b>Acessos ao site</b>
                    <div>
                        <?php
                            $banco->query("SELECT * FROM acessos_site WHERE data = '".$agora->format('Y-m-d')."'");
                            $total = $banco->linhas();
                            echo $total." acessos em ".$agora->format('d/m/Y'); 
                        ?>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="index.php?pg=1">Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary text-white mb-4">
                <div class="card-body"><b>Contas a Receber</b>
                    <div>
                        <?php
                            $banco->query("SELECT SUM(valor_unitario*qnt) as soma FROM vendas WHERE pago = 0");
                            $valor = $banco->linhas();
                            foreach ($banco->result() as $dados);          
                            echo moedaBR($dados["soma"]); 
                        ?> 
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="index.php?pg=8&action=aberto">Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body"><b>Caixa</b>
                    <div>
                        <?php
                            $banco->query("SELECT SUM(valor_unitario*qnt) as soma FROM vendas WHERE pago = 1");
                            $valor = $banco->linhas();
                            foreach ($banco->result() as $dados);          
                            echo moedaBR($dados["soma"]); 
                        ?> 
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="index.php?pg=8&action=pago">Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4 muted">
                <div class="card-body"><b>Vencimentos</b>
                    <div>
                        <?php
                            // $banco->query("SELECT SUM(valor_unitario*qnt) as soma FROM vendas WHERE pago = 1");
                            // $valor = $banco->linhas();
                            // foreach ($banco->result() as $dados);          
                            // echo moedaBR($dados["soma"]); 
                                echo ("Não implementado"); 
                        ?> 
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Últimos Logins
                </div>
                <div class="card-body">
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
                        
                            $banco->query("SELECT usuarios.id, usuarios.nome, login_erp.cod_user, DATE_FORMAT(login_erp.data_acesso,'%d/%m/%Y') as data_acesso_user, login_erp.hora_acesso FROM usuarios INNER JOIN login_erp ON usuarios.id = login_erp.cod_user ORDER BY data_acesso_user DESC LIMIT 10");

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
                        <div class="card-footer text-center">
                            <a class="small text-black" href="index.php?pg=10">Mais Registros</a>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Acessos ao site
                </div>
                <div class="card-body">
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
                                
                                $banco->query("SELECT id, ipcli, pagina, DATE_FORMAT(data,'%d/%m/%Y') as data_acesso, hora FROM acessos_site  ORDER BY data_acesso DESC LIMIT 10");

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
                            <tr>
                        </tbody>
                        </table>
                        <div class="card-footer text-center">
                            <a class="small text-black" href="index.php?pg=1">Mais Registros</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
