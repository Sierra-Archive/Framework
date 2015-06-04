<?php
class predial_BlocoControle extends predial_Controle
{
    public function __construct(){
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses predial_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        $this->Blocos();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Blocos'));
    }
    static function Endereco_Bloco($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = __('Blocos');
        $link = 'predial/Bloco/Blocos';
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Blocos_Tabela(&$blocos){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($blocos)) $blocos = Array(0=>$blocos);
        reset($blocos);
        foreach ($blocos as &$valor) {
            $tabela['Nome'][$i]             = $valor->nome;
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Bloco'        ,'predial/Bloco/Blocos_Edit/'.$valor->id.'/'    ,'')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Bloco'       ,'predial/Bloco/Blocos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Bloco ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Blocos($export=false){
        self::Endereco_Bloco(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Bloco',
                'predial/Bloco/Blocos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'predial/Bloco/Blocos',
            )
        )));
        $blocos = $this->_Modelo->db->Sql_Select('Predial_Bloco');
        if($blocos!==false && !empty($blocos)){
            list($tabela,$i) = self::Blocos_Tabela($blocos);
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Blocos');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{         
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Bloco</font></b></center>');
        }
        $titulo = __('Listagem de Blocos').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Blocos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Blocos_Add(){
        self::Endereco_Bloco();
        // Carrega Config
        $titulo1    = __('Adicionar Bloco');
        $titulo2    = __('Salvar Bloco');
        $formid     = 'form_Sistema_Admin_Blocos';
        $formbt     = __('Salvar');
        $formlink   = 'predial/Bloco/Blocos_Add2/';
        $campos = Predial_Bloco_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Blocos_Add2(){
        $titulo     = __('Bloco Adicionado com Sucesso');
        $dao        = 'Predial_Bloco';
        $funcao     = '$this->Main();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Bloco cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Blocos_Edit($id){
        self::Endereco_Bloco();
        // Carrega Config
        $titulo1    = 'Editar Bloco (#'.$id.')';
        $titulo2    = __('Alteração de Bloco');
        $formid     = 'form_Sistema_AdminC_BlocoEdit';
        $formbt     = __('Alterar Bloco');
        $formlink   = 'predial/Bloco/Blocos_Edit2/'.$id;
        $editar     = Array('Predial_Bloco',$id);
        $campos = Predial_Bloco_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Blocos_Edit2($id){
        $titulo     = __('Bloco Editado com Sucesso');
        $dao        = Array('Predial_Bloco',$id);
        $funcao     = '$this->Main();';
        $sucesso1   = __('Bloco Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Blocos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa bloco e deleta
        $bloco = $this->_Modelo->db->Sql_Select('Predial_Bloco', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($bloco);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Bloco deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Main();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Bloco deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
