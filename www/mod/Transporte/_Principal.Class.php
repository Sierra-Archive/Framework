<?php
class Transporte_Principal implements PrincipalInterface
{
    /**
    * Função Home para o modulo Transporte aparecer na pagina HOME
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function Home(&$controle, &$modelo, &$Visual){
        $registro = Framework\App\Registro::getInstacia();
        // Se for Armazem Libera Painel de Armazem
        
        if($registro->_Acl->Get_Permissao_Url('Transporte/Armazem/Painel')){
                $Visual->Bloco_Customizavel(Array(
                    Array(
                        'span'      =>      12,
                        'conteudo'  =>  Array(Array(
                            'div_ext'   =>      false,
                            'title_id'  =>      false,
                            'title'     =>      'Painel sobre o Meu Armazem',
                            'html'      =>      '<span id="painel_armazem">'.Transporte_ArmazemControle::Painel_Armazem('painel_armazem').'</span>',
                        )/*,Array(
                            'div_ext'   =>      false,
                            'title_id'  =>      false,
                            'title'     =>      'Sub-'.$tema,
                            'html'      =>      ' Aqui tem !',
                        ),*/),
                    )
                ));;
        }
        
        return true;
    }
    static function Widget(&$_Controle){
        return true;
    } 
    
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        $i = 0;
        // Busca Armazens
        $result = self::Busca_Armazens($controle, $modelo, $Visual, $busca);
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
    static function Busca_Armazens($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          //'texto'                   => '%'.$busca.'%',
        ));
        $i = 0;
        $armazens = $modelo->db->Sql_Select('Transporte_Armazem',$where);
        if($armazens===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Armazem" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Transporte/Armazem/Armazens_Add">Adicionar novo Armazem</a><div class="space15"></div>');
        if(is_object($armazens)) $armazens = Array(0=>$armazens);
        if($armazens!==false && !empty($armazens)){
            list($tabela,$i) = Transporte_ArmazemControle::Armazens_Tabela($armazens);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{   
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Armazem na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Armazens: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
}
?>