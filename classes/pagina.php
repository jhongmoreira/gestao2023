<?php
class Pagina
{
  private $pagina;

  public function __construct()
  {
    if (!isset($_GET["pg"])) {
      $_GET["pg"] = 0;
    }

    $this->pagina = $_GET["pg"];


    if (!isset($this->pagina)) {
      $this->pagina = 0;
    }

    switch ($this->pagina) {
      case 0:
        include "./paginas/principal.php";
        break;


      case 1:
        include "./paginas/consultar_acessos.php";
        break;

      case 2:
        include "./paginas/cad_cliente.php";
        break;

      case 3:
        include "./paginas/consultar_clientes.php";
        break;

      case 4:
        include "./paginas/detalhes_cliente.php";
        break;

      case 5:
        include "./paginas/apagar_cliente.php";
        break;

      case 6:
        include "./paginas/editar_cliente.php";
        break;

      case 7:
        include "./paginas/cad_venda.php";
        break;

      case 8:
        include "./paginas/consultar_vendas.php";
        break;

      case 9:
        include "./paginas/detalhes_venda.php";
        break;

      case 10:
        include "./paginas/consultar_logins.php";
        break;

      case 11:
        include "./paginas/cad_usuario.php";
        break;

      case 12:
        include "./paginas/cad_orcamento.php";
        break;

      case 13:
        include "./paginas/cad_itens_orcamento.php";
        break;

      case 14:
        include "./paginas/imprimir_orcamento.php";
        break;

      case 15:
        include "./paginas/cad_servico.php";
        break;

      case 16:
        include "./paginas/faturar.php";
        break;

      case 17:
        include "./paginas/imprimir_fatura.php";
        break;

      case 18:
        include "./paginas/editar_venda.php";
        break;
    }
  }
}
