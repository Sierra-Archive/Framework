<?php
class Agenda_CompromissoControle extends Agenda_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Agenda_ListarModelo Carrega Agenda Modelo
    * @uses Agenda_ListarVisual Carrega Agenda Visual
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
    * @name Main
    * @access public
    * 
    * @uses Agenda_Controle::$AgendaPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        $this->Compromissos();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Compromissos')); 
    }
    protected function Endereco_Compromisso($true=true){
        if($true===true){
            $this->Tema_Endereco('Compromissos','Agenda/Compromisso/Compromissos');
        }else{
            $this->Tema_Endereco('Compromissos');
        }
    }
    static function Compromissos_Tabela($compromissos){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($compromissos)) $compromissos = Array(0=>$compromissos);
        reset($compromissos);
        foreach ($compromissos as $indice=>&$valor) {
            //$tabela['#Id'][$i]       = '#'.$valor->id;
            $tabela['Tipo de Compromisso'][$i]        =   $valor->categoria2;
            $tabela['Cor'][$i]                  =   $valor->cor2;
            $tabela['Número'][$i]               =   $valor->num;
            $tabela['Nome'][$i]                 =   $valor->nome;
            $tabela['Observação'][$i]           =   $valor->obs;
            $tabela['Funções'][$i]              =   $Visual->Tema_Elementos_Btn('Personalizado'     ,Array('Editar Compromisso'        ,'Agenda/Compromisso/Compromissos_Edit/'.$valor->id.'/'    ,''));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Compromissos($export=false){
        $i = 0;
        $this->Endereco_Compromisso(false);
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Compromisso',
                'Agenda/Compromisso/Compromissos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Agenda/Compromisso/Compromissos',
            )
        )));
        $compromissos = $this->_Modelo->db->Sql_Select('Agenda_Compromisso');
        if($compromissos!==false && !empty($compromissos)){
            list($tabela,$i) = self::Compromissos_Tabela($compromissos);
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Compromissos');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Compromisso no Compromissos</font></b></center>');
        }
        $titulo = 'Compromissos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Compromissos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Compromissos_Add(){ 
        $this->Endereco_Compromisso();  
        // Carrega Config
        $titulo1    = 'Adicionar Compromisso';
        $titulo2    = 'Salvar Compromisso';
        $formid     = 'form_Sistema_Admin_Compromissos';
        $formbt     = 'Salvar';
        $formlink   = 'Agenda/Compromisso/Compromissos_Add2/';
        $campos = Agenda_Compromisso_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Compromissos_Add2(){
        $titulo     = 'Compromisso Adicionada com Sucesso';
        $dao        = 'Agenda_Compromisso';
        $funcao     = '$this->Compromissos();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Compromisso cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Compromissos_Edit($id){
        $this->Endereco_Compromisso();
        // Carrega Config
        $titulo1    = 'Editar Compromisso (#'.$id.')';
        $titulo2    = 'Alteração de Compromisso';
        $formid     = 'form_Sistema_AdminC_CompromissoEdit';
        $formbt     = 'Alterar Compromisso';
        $formlink   = 'Agenda/Compromisso/Compromissos_Edit2/'.$id;
        $editar     = Array('Agenda_Compromisso',$id);
        $campos = Agenda_Compromisso_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Compromissos_Edit2($id){
        $titulo     = 'Compromisso Editada com Sucesso';
        $dao        = Array('Agenda_Compromisso',$id);
        $funcao     = '$this->Compromissos();';
        $sucesso1   = 'Compromisso Alterada com Sucesso.';
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Compromissos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa compromisso e deleta
        $compromisso = $this->_Modelo->db->Sql_Select('Agenda_Compromisso', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($compromisso);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Compromisso Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Compromissos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Compromisso deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
