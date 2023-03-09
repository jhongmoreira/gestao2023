 <?php

    function formatar($mask,$string){
        {
            $msg = "<i>Não informado</i>";

            if ($string == ''){
                return $msg;
            }else{
                return  vsprintf($mask, str_split($string));
            }
        }
    }

    function verificaAdm($permissao, $html, $limitado){
        if ($permissao == "A"){
            echo $html;
        }else{
            echo $limitado;
        }
    }

    function verSelecao($valor, $valorDB){
        if ($valor == $valorDB){
            echo "selected";
        }

        unset($valor, $valorDB);
    }

    function dataFormato($data_entrada){
        $data_Venc = new DateTime($data_entrada); // Pega o momento atual
        echo $data_Venc->format('d/m/Y'); // Exibe no formato desejado
    }

    function moedaBR($valor_dinheiro){
        $valor_final = number_format($valor_dinheiro,2, ',', '.');
        echo 'R$ '.$valor_final;
    }

?>
