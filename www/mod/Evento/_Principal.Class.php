<?php
class Evento_Principal implements PrincipalInterface
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
     * @uses Evento_Controle::$num_Indicados
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
    static function Widget(&$_Controle){
        $_Controle->Widget_Add('Superior',
        '<li class="dropdown mtop5">'.
            '<a class="dropdown-toggle element lajax" acao="" data-placement="bottom" data-toggle="tooltip" href="'.URL_PATH.'Evento/Evento/Eventos_Add" data-original-title="Novo Evento">'.
                '<i class="icon-building"></i>'.
            '</a>'.
        '</li>');
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
    
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        $i = 0;
        // Busca Eventos
        $result = self::Busca_Eventos($controle, $modelo, $Visual, $busca);
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
    
    /***********************
     * BUSCAS
     */
    static function Busca_Eventos($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'data_inicio'             => '%'.$busca.'%',
          'data_fim'                => '%'.$busca.'%',
        ));
        $i = 0;
        $eventos = $modelo->db->Sql_Select('Evento',$where);
        if($eventos===false) return false;
        // add botao
        $Visual->Blocar($Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Evento',
                'Evento/Evento/Eventos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Evento/Evento/Eventos',
            )
        )));
        if(is_object($eventos)) $eventos = Array(0=>$eventos);
        if($eventos!==false && !empty($eventos)){
            list($tabela,$i) = Evento_EventoControle::Eventos_Tabela($eventos);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{    
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Evento na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Eventos: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
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
        // Eventos
        $where = Array();
        $evento = $modelo->db->Sql_Select('Evento',$where);
        if(is_object($evento)) $evento = Array(0=>$evento);
        if($evento!==false && !empty($evento)){
            reset($evento);
            $evento_qnt = count($evento);
        }else{
            $evento_qnt = 0;
        }
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Eventos', 
            'Evento/Evento/Main', 
            'building', 
            $evento_qnt, 
            'block-red', 
            false, 
            400
        );
    }
    
}
?>