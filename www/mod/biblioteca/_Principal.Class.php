<?php
class biblioteca_Principal implements PrincipalInterface
{
    /**
     * Função Home para o modulo mensagem aparecer na pagina HOME
     * 
     * @name Home
     * @access public
     * @static
     * 
     * @param Class &$controle Classe Controle Atual passada por Ponteiro
     * @param Class &$modelo Modelo Passado por Ponteiro
     * @param Class &$Visual Visual Passado por Ponteiro
     *
     * @uses biblioteca_Controle::$num_Indicados
     * 
     * @return void 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    static function Home(&$controle, &$modelo, &$Visual){
        self::Widgets();
        return true;
    }
    /**
     * 
     * @return boolean
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    static function Config(){
        return false;
    }
    
    static function Relatorio($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    static function Estatistica($data_inicio,$data_final,$filtro=false){
        return false;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public static function Widgets(){
        $Registro = &\Framework\App\Registro::getInstacia();
        $modelo = $Registro->_Modelo;
        $Visual = $Registro->_Visual;
        // Bibliotecas
        $biblioteca_qnt = $modelo->db->Sql_Contar('Biblioteca');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Arquivos/Pastas', 
            'biblioteca/Biblioteca/Bibliotecas', 
            'folder-open',
            $biblioteca_qnt, 
            'light-green', 
            false, 
            300
        );
    }
    
    
    /***********************
     * BUSCAS
     */
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        $i = 0;
        // Busca Bibliotecas
        $result = self::Busca_Bibliotecas($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        if(is_int($i) && $i>0){
            return $i;
        }else{
            return false;
        }
    }
    static function Busca_Bibliotecas($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
          'arquivo'                 => '%'.$busca.'%'
        ));
        $i = 0;
        $bibliotecas = $modelo->db->Sql_Select('Biblioteca',$where);
        if($bibliotecas===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Pasta a Biblíoteca" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas_Add">Adicionar nova Biblíoteca</a><div class="space15"></div>');
        if(is_object($bibliotecas)) $bibliotecas = Array(0=>$bibliotecas);
        if($bibliotecas!==false && !empty($bibliotecas)){
            list($tabela,$i) = biblioteca_BibliotecaControle::Bibliotecas_Tabela($bibliotecas);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{        
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Arquivo/Pasta na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Pasta/Arquivo na Biblíoteca: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
}
?>