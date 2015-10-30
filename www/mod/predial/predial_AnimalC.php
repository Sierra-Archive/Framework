<?php
class predial_AnimalControle extends predial_Controle
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
    * @version 0.4.2
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'predial/Animal/Animais');
        return false;
    }
    static function Endereco_Animal($true=true){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Animais');
        $link = 'predial/Animal/Animais';
        if ($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Animais_Tabela(&$animais){
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if (is_object($animais)) $animais = Array(0=>$animais);
        reset($animais);
        foreach ($animais as &$valor) {
            $tabela['Bloco'][$i]            = $valor->bloco2;
            $tabela['Apartamento'][$i]      = $valor->apart2;
            $tabela['Nome'][$i]             = $valor->nome;
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Animal'        ,'predial/Animal/Animais_Edit/'.$valor->id.'/'    ,'')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Animal'       ,'predial/Animal/Animais_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Animal ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Animais(){
        self::Endereco_Animal(false);
        $i = 0;
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Animal',
                'predial/Animal/Animais_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'predial/Animal/Animais',
            )
        )));
        // Busca
        $animais = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Animal');
        if ($animais!==false && !empty($animais)){
            list($tabela,$i) = self::Animais_Tabela($animais);
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        } else {          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Animal</font></b></center>');
        }
        $titulo = __('Listagem de Animais').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Animais'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Animais_Add(){
        self::Endereco_Animal();
        // Carrega Config
        $titulo1    = __('Adicionar Animal');
        $titulo2    = __('Salvar Animal');
        $formid     = 'form_Sistema_Admin_Animais';
        $formbt     = __('Salvar');
        $formlink   = 'predial/Animal/Animais_Add2/';
        $campos = Predial_Bloco_Apart_Animal_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Animais_Add2(){
        $titulo     = __('Animal Adicionado com Sucesso');
        $dao        = 'Predial_Bloco_Apart_Animal';
        $funcao     = '$this->Animais();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Animal cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Animais_Edit($id){
        self::Endereco_Animal();
        // Carrega Config
        $titulo1    = 'Editar Animal (#'.$id.')';
        $titulo2    = __('Alteração de Animal');
        $formid     = 'form_Sistema_AdminC_AnimalEdit';
        $formbt     = __('Alterar Animal');
        $formlink   = 'predial/Animal/Animais_Edit2/'.$id;
        $editar     = Array('Predial_Bloco_Apart_Animal',$id);
        $campos = Predial_Bloco_Apart_Animal_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Animais_Edit2($id){
        $titulo     = __('Animal Editado com Sucesso');
        $dao        = Array('Predial_Bloco_Apart_Animal',$id);
        $funcao     = '$this->Animais();';
        $sucesso1   = __('Animal Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Animais_Del($id){
        
        
    	$id = (int) $id;
        // Puxa animal e deleta
        $animal = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Animal', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($animal);
        // Mensagem
    	if ($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Animal deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Animais();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Animal deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
