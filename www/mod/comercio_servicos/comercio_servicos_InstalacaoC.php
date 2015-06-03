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
    * @uses comercio_servicos_Controle::$servicosPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio_servicos/Instalacao/Btu/');
        return false;
    }/*
    static function Endereco_Ar($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Adicional de Ar','comercio_servicos/Instalacao/Ar');
        }else{
            $_Controle->Tema_Endereco('Adicional de Ar');
        }
    }
    static function Endereco_Gas($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Adicional de Gás','comercio_servicos/Instalacao/Gas');
        }else{
            $_Controle->Tema_Endereco('Adicional de Gás');
        }
    }
    static function Endereco_Linha($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Adicional de Linha','comercio_servicos/Instalacao/Linha');
        }else{
            $_Controle->Tema_Endereco('Adicional de Linha');
        }
    }*/
    static function Endereco_Btu($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Btu','comercio_servicos/Instalacao/Btu');
        }else{
            $_Controle->Tema_Endereco('Btu');
        }
    }
    static function Endereco_Suporte($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Suporte','comercio_servicos/Instalacao/Suporte');
        }else{
            $_Controle->Tema_Endereco('Suporte');
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Btu(){
        self::Endereco_Btu(false);
        
        $tabela_colunas = Array();
        
        $tabela_colunas[] = 'Nome';
        $tabela_colunas[] = 'Valor Equipamento';
        $tabela_colunas[] = 'Valor Add de Gás';
        $tabela_colunas[] = 'Valor Add de Linha';
        $tabela_colunas[] = 'Funções';

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'comercio_servicos/Instalacao/Btu');
        $titulo = 'Listagem de Btu / Equipamento';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo.' (<span id="DataTable_Contador">Carregando...</span>)','',10,Array("link"=>"comercio_servicos/Instalacao/Btu_Add",'icon'=>'add','nome'=>'Adicionar Btu / Equipamento'));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Btu / Equipamento');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Btu_Add(){
        self::Endereco_Btu();
        // Carrega Config
        $titulo1    = 'Adicionar Btu';
        $titulo2    = 'Salvar Btu';
        $formid     = 'form_Sistema_Instalacao_Btu';
        $formbt     = 'Salvar';
        $formlink   = 'comercio_servicos/Instalacao/Btu_Add2/';
        $campos = Comercio_Servicos_Btu_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Btu_Add2(){
        $titulo     = 'Btu adicionado com Sucesso';
        $dao        = 'Comercio_Servicos_Btu';
        $funcao     = '$this->Btu();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Btu cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Btu_Edit($id){
        self::Endereco_Btu();
        // Carrega Config
        $titulo1    = 'Editar Btu (#'.$id.')';
        $titulo2    = 'Alteração de Btu';
        $formid     = 'form_Sistema_AdminC_BtuEdit';
        $formbt     = 'Alterar Btu';
        $formlink   = 'comercio_servicos/Instalacao/Btu_Edit2/'.$id;
        $editar     = Array('Comercio_Servicos_Btu',$id);
        $campos = Comercio_Servicos_Btu_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Btu_Edit2($id){
        $titulo     = 'Btu editado com Sucesso';
        $dao        = Array('Comercio_Servicos_Btu',$id);
        $funcao     = '$this->Btu();';
        $sucesso1   = 'Btu Alterado com Sucesso.';
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
    public function Btu_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Btu', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Btu deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Btu();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Btu deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Suporte(){
        self::Endereco_Suporte(false);
        
        $tabela_colunas = Array();
        $tabela_colunas[] = 'Tipo';
        $tabela_colunas[] = 'Valor';
        $tabela_colunas[] = 'Funções';

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'comercio_servicos/Instalacao/Suporte');
        $titulo = 'Listagem de Suportes';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo.' (<span id="DataTable_Contador">Carregando...</span>)','',10,Array("link"=>"comercio_servicos/Instalacao/Suporte_Add",'icon'=>'add','nome'=>'Adicionar Suporte'));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Suportes'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Suporte_Add(){
        self::Endereco_Suporte();
        // Carrega Config
        $titulo1    = 'Adicionar Suporte';
        $titulo2    = 'Salvar Suporte';
        $formid     = 'form_Sistema_Instalacao_Suporte';
        $formbt     = 'Salvar';
        $formlink   = 'comercio_servicos/Instalacao/Suporte_Add2/';
        $campos = Comercio_Servicos_Suporte_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Suporte_Add2(){
        $titulo     = 'Suporte adicionado com Sucesso';
        $dao        = 'Comercio_Servicos_Suporte';
        $funcao     = '$this->Suporte();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Suporte cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Suporte_Edit($id){
        self::Endereco_Suporte();
        // Carrega Config
        $titulo1    = 'Editar Suporte (#'.$id.')';
        $titulo2    = 'Alteração de Suporte';
        $formid     = 'form_Sistema_AdminC_SuporteEdit';
        $formbt     = 'Alterar Suporte';
        $formlink   = 'comercio_servicos/Instalacao/Suporte_Edit2/'.$id;
        $editar     = Array('Comercio_Servicos_Suporte',$id);
        $campos = Comercio_Servicos_Suporte_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Suporte_Edit2($id){
        $titulo     = 'Suporte editado com Sucesso';
        $dao        = Array('Comercio_Servicos_Suporte',$id);
        $funcao     = '$this->Suporte();';
        $sucesso1   = 'Suporte alterado com Sucesso.';
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
    public function Suporte_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Suporte', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => 'Deletado',
                "mgs_secundaria"    => 'Suporte deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => $language['mens_erro']['erro'],
                "mgs_secundaria"    => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Suporte();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Suporte deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
