<?php
class Agenda_AtividadesControle extends Agenda_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Agenda_AtividadesModelo Carrega Atividades Modelo
    * @uses Agenda_AtividadesVisual Carrega Atividades Visual
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
    * Função Main, Principal, é a tela inicial quando clica em Atividades.
    * 
    * @name Main
    * @access public
    * 
    * @uses Agenda_AtividadesModelo::$Atividades_retorna Carrega Todas as Atividades Referentes
    * @uses Agenda_AtividadesVisual::$Show_Atividades Exibe Todas as Atividades Referentes
    * @uses \Framework\App\Visual::$blocar
    * @uses \Framework\App\Visual::$novajanela
    * @uses Agenda_AtividadesControle::$Atividades_formcadastro Carrega Formulario de Cadastro de Atividade
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){    
        return false;
    }
    
    
    static function Atividades_Abertas($tipo='Unico'){     
        $i = 0;
        // Botao Add
        $atividades = $Modelo->db->Sql_Select('Agenda_Atividade_Hora','AAH.dt_fim=\'0000-00-00 00:00:00\'');
        if($atividades!==false && !empty($atividades)){
            
            if(is_object($atividades)) $atividades = Array(0=>$atividades);
            reset($atividades);
            foreach ($atividades as $indice=>&$valor) {
                //$tabela['#Id'][$i]       = '#'.$valor->id;
                $tabela['Tipo de Compromisso'][$i]        =   $valor->atividade2;
                $tabela['Inicio'][$i]                  =   $valor->dt_inicio;
                $tabela['Funções'][$i]              =   $Visual->Tema_Elementos_Btn('Personalizar'     ,Array('Editar Atividade'        ,'Agenda/Compromisso/Compromissos_Edit/'.$valor->id.'/'    ,''));
                ++$i;
            }
        
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Atividades Abertas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    true,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{           
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Atividade Aberta</font></b></center>');
        }
        $titulo = 'Arquivo de Pastas ('.$i.')';
        if($tipo==='Unico'){
            $Visual->Bloco_Unico_CriaJanela($titulo);
        }else{
            $Visual->Bloco_Maior_CriaJanela($titulo);
        }
    }
    
    
    
    
    
    public function Atividades_Tempo($atividade){     
        // Procura em Atividades Tempo, com tempo inicial mas sem tempo final
        $atv_tempo = $this->_Modelo->db->Sql_Select('Agenda_Atividade_Hora');
        
        // Se nao Achar adicionar um com tempo
        if($atv_tempo===false){
            $atv_tempo = new Agenda_Atividade_Hora_DAO();
            
            $atv_tempo->atividade = 0;
            $atv_tempo->dt_inicio = APP_HORA;
            $atv_tempo->dt_fim = '0000-00-00 00-00-00';
            $atv_tempo->total = 0;
            
            $this->_Modelo->db->Sql_Insert($atv_tempo);
        }else{
            $atv_tempo->dt_fim = APP_HORA;
            $atv_tempo->total = Data_CalculaDiferenca_Em_Segundos($atv_tempo->dt_inicio,$atv_tempo->dt_fim);
            $this->_Modelo->db->Sql_Update($atv_tempo);
        }
    }
}
?>
