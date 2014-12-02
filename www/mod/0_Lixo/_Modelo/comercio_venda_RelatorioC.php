<?php
class comercio_venda_RelatorioControle extends comercio_venda_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_venda_rede_RelatorioModelo::Carrega Rede Modelo
    * @uses comercio_venda_rede_RelatorioView::Carrega Rede View
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        parent::__construct();
    }
    /**
     * Main
     * 
     * FUNCAO PRINCIPAL, EXECUTA O PRIMEIRO PASSO 
     * 
     * @name Main
     * @access public
     * 
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Main(){
        return false;
    }
}
?>