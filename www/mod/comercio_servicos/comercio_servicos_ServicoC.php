<?php
class comercio_servicos_ServicoControle extends comercio_servicos_Controle
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
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio_servicos/Servico/Servico');
        return false;
    }
    static function Endereco_Servico($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo'),'comercio_servicos/Servico/Servico');
        }else{
            $_Controle->Tema_Endereco(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo'));
        }
    }
    static function Servicos_Tabela(&$servicos){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        // Titulos
        $titulo             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2            = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        if(Framework\Classes\Texto::Captura_Palavra_Masculina($titulo2)===true){
            $titulo_com_sexo    = 'o '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        }else{
            $titulo_com_sexo    = 'a '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        }
        // COmeça Array
        $tabela = Array();
        $i = 0;
        if(is_object($servicos)) $servicos = Array(0=>$servicos);
        reset($servicos);
        foreach ($servicos as $indice=>&$valor) {
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_ServicoTipo')){
                $tabela['Tipo d'.$titulo_com_sexo][$i]  = $valor->tipo2;
            }
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_nome')){
                $tabela['Nome'][$i]  = $valor->nome;
            }
            $tabela['Descriçao'][$i]        = $valor->descricao;
            $tabela['Preço'][$i]            = $valor->preco;
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar '.$titulo2        ,'comercio_servicos/Servico/Servicos_Edit/'.$valor->id.'/'    ,'')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar '.$titulo2       ,'comercio_servicos/Servico/Servicos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar ess'.$titulo_com_sexo.' ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servico($export=false){
        self::Endereco_Servico(false);
        $i = 0;
        $i = 0;
        $titulo = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2 = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        if(Framework\Classes\Texto::Captura_Palavra_Masculina($titulo2)===true){
            $titulo_com_sexo        = 'o '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
            $titulo_com_sexo_mudo   = ' '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        }else{
            $titulo_com_sexo        = 'a '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
            $titulo_com_sexo_mudo   = 'a '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        }
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar nov'.$titulo_com_sexo,
                'comercio_servicos/Servico/Servicos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio_servicos/Servico/Servico',
            )
        )));
        $servicos = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Servico');
        if($servicos!==false && !empty($servicos)){
            list($tabela,$i) = self::Servicos_Tabela($servicos);
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Empreendimentos');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum'.$titulo_com_sexo_mudo.'</font></b></center>');
        }
        $titulo = 'Listagem de '.$titulo.' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar '.$titulo);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servicos_Add(){
        self::Endereco_Servico();
        // Titulos
        $titulo             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2            = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        // Carrega Config
        $titulo1    = 'Adicionar '.$titulo2;
        $titulo2    = 'Salvar '.$titulo2;
        $formid     = 'form_Sistema_Servico_Servicos';
        $formbt     = 'Salvar';
        $formlink   = 'comercio_servicos/Servico/Servicos_Add2/';
        $campos = Comercio_Servicos_Servico_DAO::Get_Colunas();
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servicos_Add2(){
        $titulo     = 'Adicionado com Sucesso';
        $dao        = 'Comercio_Servicos_Servico';
        $funcao     = '$this->Servico();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servicos_Edit($id){
        self::Endereco_Servico();
        // Titulos
        $titulo             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2            = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        // Carrega Config
        $titulo1    = 'Editar Serviço (#'.$id.')';
        $titulo2    = 'Alteração de '.$titulo2;
        $formid     = 'form_Sistema_ServicoC_ServiçoEdit';
        $formbt     = 'Alterar '.$titulo2;
        $formlink   = 'comercio_servicos/Servico/Servicos_Edit2/'.$id;
        $editar     = Array('Comercio_Servicos_Servico',$id);
        $campos = Comercio_Servicos_Servico_DAO::Get_Colunas();
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servicos_Edit2($id){
        $titulo     = 'Editado com Sucesso';
        $dao        = Array('Comercio_Servicos_Servico',$id);
        $funcao     = '$this->Servico();';
        $sucesso1   = 'Alterado com Sucesso.';
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
    public function Servicos_Del($id){
        global $language;
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Servico', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Servico();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $tipo
     * @param type $campos
     * @param type $form
     */
    public static function Campos_Deletar(&$campos){
        // SE nao tiver Foto tira foto
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_ServicoTipo')){
            self::DAO_Campos_Retira($campos, 'tipo');
        }
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_nome')){
            self::DAO_Campos_Retira($campos, 'nome');
        }
    }
}
?>
