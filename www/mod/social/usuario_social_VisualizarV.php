<?php
class social_VisualizarVisual extends social_Visual
{

    public function __construct(){
        parent::__construct();
    } 
    public function exibetipos(&$tipo,&$tipos,&$tipon){
        unset($tabela);
        $tabela = array();
        $i = 0;
        foreach ($tipon as $indice=>&$valor) {
            $tabela['Nome'][$i] = $valor;
            ++$i;
        }
        $i=0;
        foreach ($tipo as $indice=>&$valor) {
            $tabela['Quantidade'][$i] = $valor;
            ++$i;
        }
        $i = 0;
        foreach ($tipos as $indice=>&$valor) {
            $tabela['Pontos'][$i] = $valor;
            ++$i;
        }
        $this->novatabela("relatorio",$tabela);
    }
    public function exibe_persona(&$persona){
        $this->blocos .= '<a href="javascript:popup()"><a href="http://www.facebook.com/profile.php?id='.$persona['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$persona['id_face'].'/picture"></a>';
        $this->blocos .= $persona['nome'];
        if($persona['fis_sexo']==0) $this->blocos .= 'Feminino';
        else $this->blocos .= 'Masculino';
        $this->blocos .= date_time($persona['nasc'], "d/m/Y");
        $this->blocos .= $persona['pontos'];
        $this->blocos .= '<p class="botao"><a onclick="return popup(\'Nova Ação do Usuário\',\social/acoes/newacaouser/'.$persona['id'].'\')" href="#">Adicionar A��o</a></p>';
        $this->blocos .= '<p class="botao"><a onclick="return popup(\'Nova Ação do Usuário\',\social/acoes/newacaouser/'.$persona['id'].'\')" href="#">Subir Fotos</a></p><br>
        Chance de Estar Falando a Verdade: '.$persona['por_confiar'].'%<br>
        Chance de Ficar: '.$persona['por_ficar'].'%<br>
        Vontade de Passar tempo Junto: '.$persona['por_chata'].'%';
    } 
}
?>