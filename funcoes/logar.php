<?php

function loginERP($cod_user, $data_acesso, $hora_acesso){
  $banco = new BancoDeDados;
  $banco->query("INSERT INTO login_erp VALUES('', '$cod_user', '$data_acesso', '$hora_acesso')");
  unset($banco);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST')

{

    //recupera o nome de usuário do formulário
    //addslashes é pra remover aspas para não causar problemas com o banco de dados
    $usuario = isset($_POST["usuarioNome"]) ? addslashes(trim($_POST["usuarioNome"])) : FALSE;

    //recupera a senha
    $senha = isset($_POST["usuarioSenha"]) ? addslashes(trim($_POST["usuarioSenha"])) : FALSE;

    if(!$senha || !$usuario){
        echo "Digite corretamente usuário e senha.";
        exit;
    }

    /* Executa a consulta no banco de dados,
     * caso o resultado seja um é porque o usuário existe.
    */

    $pwd_md5 = md5($senha);

    $banco = new BancoDeDados;
    // WHERE usuario = '$usuario' and senha_md5 = '$pwd_md5' and ativo = 1 LIMIT 1
    $banco->query("SELECT * FROM usuarios WHERE usuario = '$usuario' and senha = '$pwd_md5'");

    foreach ($banco->result() as $dados) {}

    $total = $banco->linhas();

    date_default_timezone_set('America/Sao_Paulo');
    $data_agora = date('Y-m-d');
    $hora_agora = date('H:i:s');

    if ($total != 0)
    {
      $_SESSION["idUsrS"] = $dados["id"];
      $_SESSION["nomeUsrS"] = $dados["usuario"];
      $_SESSION["nomeCompletoUsrS"] = $dados["nome"];
      loginERP($dados['id'], $data_agora, $hora_agora);
      header("Location: index.php");
      die();
    }
}
?>
