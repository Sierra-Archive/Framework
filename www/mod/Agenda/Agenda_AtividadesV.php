<?php

class Agenda_AtividadesVisual extends Agenda_Visual
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
      parent::__construct();
    }
    /*
    /*
     * 
     * 
     *                 A FAZERRRRRRRRRRRRRRRR
     * 
     * 
     * 
     * 
    * Função para gravar Relações entre tabelas e social, é uma funcao static e é chamada por diversos oturos modulos
    * 
    * @name Show_Atividades
    * @access public
    * 
    * @param Array $array Carrega Array com Atividades
    * 
    * @return string tabela::$retornatabela Retorna Tabela Preenchida com os Dados
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version
    */
    static function Show_Atividades(&$array) {
        $html = '';
        $tamanho = sizeof($array);
        $tabela = new \Framework\Classes\Tabela();
        $tabela->addcabecario(array('Nome / Local','Data','Descrição','Ações'));
        for($i=0;$i<$tamanho;++$i) {
            $tabela->addcorpo(array(
                array("nome" => '<a class="lajax-mesup active" href="'.URL_PATH.'Agenda/compromisso/compromisso/'.$array[$i]['id'].'/" data-acao="">'.$array[$i]['nome'].'</a><br><br>'.$array[$i]['local']),
                array("nome" => $array[$i]['dt_inicio'].'<br>ás<br>'.$array[$i]['dt_fim']),
                array("nome" => $array[$i]['descricao']),
                array("nome" => '<img width="24" height="24" alt="Editar Compromisso" src="'.WEB_URL.'img/icons/editar.png"> <img alt="Deletar Compromisso" width="24" height="24" src="'.WEB_URL.'img/icons/del.png">')
            ));
        }
        return $tabela->retornatabela();
    }
}
?>