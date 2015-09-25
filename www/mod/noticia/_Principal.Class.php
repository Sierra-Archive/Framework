<?php
class noticia_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo noticia aparecer na pagina HOME
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$Modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses \Framework\App\Controle::$noticia
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$modelo, &$Visual){
        // Noticias
        $noticia_qnt = $Modelo->db->Sql_Contar('Noticia');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Noticias', 
            'noticia/Admin/Noticias', 
            'rss', 
            $noticia_qnt, 
            'block-green', 
            false, 
            360
        );
        return true;
    }
    static function Widget(&$_Controle){
        $_Controle->Widget_Add('Superior',
        '<li class="dropdown mtop5">'.
            '<a class="dropdown-toggle element lajax" acao="" data-placement="bottom" data-toggle="tooltip" href="'.URL_PATH.'noticia/Admin/Noticias_Add" data-original-title="Nova Noticia">'.
                '<i class="fa fa-rss"></i>'.
            '</a>'.
        '</li>');
        return true;
    } 
    
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        $i = 0;
        // Busca Noticias
        $result = self::Busca_Noticias($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Retorna
        if(is_int($i) && $i>0){
            return $i;
        }else{
            return false;
        }
    }
    static function Config(){
        return false;
    }
    
    static function Relatorio($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    static function Estatistica($data_inicio,$data_final,$filtro=false){
        return false;
    }
    /***********************
     * BUSCAS
     */
    static function Busca_Noticias($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'texto'                   => '%'.$busca.'%',
        ));
        $i = 0;
        $noticias = $Modelo->db->Sql_Select('Noticia',$where);
        if($noticias===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Noticia" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Noticia/Admin/Noticias_Add">Adicionar novo Noticia</a><div class="space15"></div>');
        if(is_object($noticias)) $noticias = Array(0=>$noticias);
        if($noticias!==false && !empty($noticias)){
            list($tabela,$i) = noticia_AdminControle::Noticias_Tabela($noticias);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{   
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Noticia na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Noticias: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
}
?>