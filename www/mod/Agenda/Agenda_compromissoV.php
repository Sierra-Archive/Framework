<?php

class Agenda_compromissoVisual extends Agenda_Visual
{

    public function __construct(){
      parent::__construct();
    } 
    public function show_compromisso(&$array){
        $html = '<a class="lajax-mesup active" href="'.URL_PATH.'Agenda/compromisso/compromisso/'.$array['id'].'/" acao="">'.$array['nome'].'-'.$array['id'].'<br>bairro: '.$array['bairro'].'</a><br><br>';
        return $html;
    }
    static function show_compromissosanteriores(&$array){
        $html = '';
        $tamanho = sizeof($array);
        $tabela = new \Framework\Classes\Tabela();
        $tabela->addcabecario(array('Nome / Local','Data','Descrição','Ações'));
        for($i=0;$i<$tamanho;++$i){
            $tabela->addcorpo(array(
                array("nome" => '<a class="lajax-mesup active" href="'.URL_PATH.'Agenda/compromisso/compromisso/'.$array[$i]['id'].'/" acao="">'.$array[$i]['nome'].'</a><br><br>'.$array[$i]['local']),
                array("nome" => $array[$i]['dt_inicio'].'<br>ás<br>'.$array[$i]['dt_fim']),
                array("nome" => $array[$i]['descricao']),
                array("nome" => '<img width="24" height="24" border="0" src="'.WEB_URL.'img/icons/editar.png"> <img width="24" height="24" border="0" src="'.WEB_URL.'img/icons/del.png">')
            ));
        }
        return $tabela->retornatabela();
    }
    static function show_compromissos(&$array){
        $html = '';
        $tamanho = sizeof($array);
        $tabela = new \Framework\Classes\Tabela();
        $tabela->addcabecario(array('Nome / Local','Data','Descrição','Ações'));
        for($i=0;$i<$tamanho;++$i){
            $tabela->addcorpo(array(
                array("nome" => '<a class="lajax-mesup active" href="'.URL_PATH.'Agenda/compromisso/compromisso/'.$array[$i]['id'].'/" acao="">'.$array[$i]['nome'].'</a><br><br>'.$array[$i]['local']),
                array("nome" => $array[$i]['dt_inicio'].'<br>ás<br>'.$array[$i]['dt_fim']),
                array("nome" => $array[$i]['descricao']),
                array("nome" => '<img width="24" height="24" border="0" src="'.WEB_URL.'img/icons/editar.png"> <img width="24" height="24" border="0" src="'.WEB_URL.'img/icons/del.png">')
            ));
        }
        return $tabela->retornatabela();
    }
    public function show_eventos(&$array){
        $html = '';
        $tamanho = sizeof($array);
        for($i=0;$i<$tamanho;++$i){
            $html .= '<a class="lajax-mesup active" href="'.URL_PATH.'Agenda/compromisso/compromisso/'.$array[$i]['id'].'/" acao="">'.$array[$i]['nome'].'</a><br><br>';
        }
        return $html;
    }
}
?>