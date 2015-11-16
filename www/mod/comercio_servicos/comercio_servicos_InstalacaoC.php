<?php
class comercio_servicos_InstalacaoControle extends comercio_servicos_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_servicos_rede_PerfilModelo::Carrega Rede Modelo
    * @uses comercio_servicos_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses comercio_servicos_Controle::$servicosPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio_servicos/Instalacao/Btu/');
        return FALSE;
    }/*
    static function Endereco_Ar($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true === TRUE) {
            $_Controle->Tema_Endereco(__('Adicional de Ar'),'comercio_servicos/Instalacao/Ar');
        } else {
            $_Controle->Tema_Endereco(__('Adicional de Ar'));
        }
    }
    static function Endereco_Gas($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true === TRUE) {
            $_Controle->Tema_Endereco(__('Adicional de Gás'),'comercio_servicos/Instalacao/Gas');
        } else {
            $_Controle->Tema_Endereco(__('Adicional de Gás'));
        }
    }
    static function Endereco_Linha($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true === TRUE) {
            $_Controle->Tema_Endereco(__('Adicional de Linha'),'comercio_servicos/Instalacao/Linha');
        } else {
            $_Controle->Tema_Endereco(__('Adicional de Linha'));
        }
    }*/
    static function Endereco_Btu($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true === TRUE) {
            $_Controle->Tema_Endereco(__('Btu'),'comercio_servicos/Instalacao/Btu');
        } else {
            $_Controle->Tema_Endereco(__('Btu'));
        }
    }
    static function Endereco_Suporte($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true === TRUE) {
            $_Controle->Tema_Endereco(__('Suporte'),'comercio_servicos/Instalacao/Suporte');
        } else {
            $_Controle->Tema_Endereco(__('Suporte'));
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Btu() {
        self::Endereco_Btu(FALSE);
        
        $table_colunas = Array();
        
        $table_colunas[] = __('Nome');
        $table_colunas[] = __('Valor Equipamento');
        $table_colunas[] = __('Valor Add de Gás');
        $table_colunas[] = __('Valor Add de Linha');
        $table_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($table_colunas,'comercio_servicos/Instalacao/Btu');
        $titulo = 'Listagem de Btu / Equipamento';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo.' (<span id="DataTable_Contador">0</span>)', '',10,Array("link"=>"comercio_servicos/Instalacao/Btu_Add",'icon'=>'add', 'nome'=>'Adicionar Btu / Equipamento'));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', 'Administrar Btu / Equipamento');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Btu_Add() {
        self::Endereco_Btu();
        // Carrega Config
        $titulo1    = __('Adicionar Btu');
        $titulo2    = __('Salvar Btu');
        $formid     = 'form_Sistema_Instalacao_Btu';
        $formbt     = __('Salvar');
        $formlink   = 'comercio_servicos/Instalacao/Btu_Add2/';
        $campos = Comercio_Servicos_Btu_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Btu_Add2() {
        $titulo     = __('Btu adicionado com Sucesso');
        $dao        = 'Comercio_Servicos_Btu';
        $function     = '$this->Btu();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Btu cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Btu_Edit($id) {
        self::Endereco_Btu();
        // Carrega Config
        $titulo1    = 'Editar Btu (#'.$id.')';
        $titulo2    = __('Alteração de Btu');
        $formid     = 'form_Sistema_AdminC_BtuEdit';
        $formbt     = __('Alterar Btu');
        $formlink   = 'comercio_servicos/Instalacao/Btu_Edit2/'.$id;
        $editar     = Array('Comercio_Servicos_Btu', $id);
        $campos = Comercio_Servicos_Btu_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Btu_Edit2($id) {
        $titulo     = __('Btu editado com Sucesso');
        $dao        = Array('Comercio_Servicos_Btu', $id);
        $function     = '$this->Btu();';
        $sucesso1   = __('Btu Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Btu_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Btu', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Btu deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Btu();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Btu deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Suporte() {
        self::Endereco_Suporte(FALSE);
        
        $table_colunas = Array();
        $table_colunas[] = __('Tipo');
        $table_colunas[] = __('Valor');
        $table_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($table_colunas,'comercio_servicos/Instalacao/Suporte');
        $titulo = __('Listagem de Suportes');
        $this->_Visual->Bloco_Unico_CriaJanela($titulo.' (<span id="DataTable_Contador">0</span>)', '',10,Array("link"=>"comercio_servicos/Instalacao/Suporte_Add",'icon'=>'add', 'nome'=>'Adicionar Suporte'));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Suportes'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Suporte_Add() {
        self::Endereco_Suporte();
        // Carrega Config
        $titulo1    = __('Adicionar Suporte');
        $titulo2    = __('Salvar Suporte');
        $formid     = 'form_Sistema_Instalacao_Suporte';
        $formbt     = __('Salvar');
        $formlink   = 'comercio_servicos/Instalacao/Suporte_Add2/';
        $campos = Comercio_Servicos_Suporte_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Suporte_Add2() {
        $titulo     = __('Suporte adicionado com Sucesso');
        $dao        = 'Comercio_Servicos_Suporte';
        $function     = '$this->Suporte();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Suporte cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Suporte_Edit($id) {
        self::Endereco_Suporte();
        // Carrega Config
        $titulo1    = 'Editar Suporte (#'.$id.')';
        $titulo2    = __('Alteração de Suporte');
        $formid     = 'form_Sistema_AdminC_SuporteEdit';
        $formbt     = __('Alterar Suporte');
        $formlink   = 'comercio_servicos/Instalacao/Suporte_Edit2/'.$id;
        $editar     = Array('Comercio_Servicos_Suporte', $id);
        $campos = Comercio_Servicos_Suporte_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Suporte_Edit2($id) {
        $titulo     = __('Suporte editado com Sucesso');
        $dao        = Array('Comercio_Servicos_Suporte', $id);
        $function     = '$this->Suporte();';
        $sucesso1   = __('Suporte alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Suporte_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Suporte', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Deletado'),
                "mgs_secundaria"    => __('Suporte deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Suporte();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Suporte deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
