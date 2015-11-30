<?php
class usuario_veiculo_EquipamentoControle extends usuario_veiculo_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_veiculo_ListarModelo Carrega usuario_veiculo Modelo
    * @uses usuario_veiculo_ListarVisual Carrega usuario_veiculo Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
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
    * @uses usuario_veiculo_Controle::$usuario_veiculoPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_veiculo/Equipamento/Equipamentos');
        return false;
    }
    static function Endereco_Equipamento($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $link   = 'usuario_veiculo/Equipamento/Equipamentos';
        if ($true === true) {
            $_Controle->Tema_Endereco(__('Equipamentos'), $link);
        } else {
            $_Controle->Tema_Endereco(__('Equipamentos'));
        }
    }
    static function Endereco_Equipamento_Marca($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Marcas');
        $link   = 'usuario_veiculo/Equipamento/Marcas';
        // Chama Equipamento
        self::Endereco_Equipamento(true);
        if ($true === true) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Equipamento_Modelo($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Modelos');
        $link   = 'usuario_veiculo/Equipamento/Modelos';
        // Chama Equipamento
        self::Endereco_Equipamento_Marca(true);
        if ($true === true) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Equipamentos($export = false) {
        $i = 0;
        self::Endereco_Equipamento(false);
        $titulo = __('Equipamentos');
        $titulo2 = \Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar '.$titulo2,
                'usuario_veiculo/Equipamento/Equipamentos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario_veiculo/Equipamento/Equipamentos',
            )
        )));
        $equipamentos = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Equipamento');
        if ($equipamentos !== false && !empty($equipamentos)) {
            if (is_object($equipamentos)) $equipamentos = Array(0=>$equipamentos);
            reset($equipamentos);
            foreach ($equipamentos as $indice=>&$valor) {
                //$table[__('#Id')][$i]       = '#'.$valor->id;
                $table[__('Tipo de Equipamento')][$i]      =   $valor->categoria2;
                $table[CFG_TXT_EQUIPAMENTOS_NOME][$i]  =   $valor->nome;
                $table[__('Validade')][$i]                 =   $valor->validade;
                $table[__('Observações')][$i]              =   $valor->obs;
                if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_Status')) {
                    $table[__('Status')][$i]     =  '<span class="statusEquipamentos'.$valor->id.'">'.self::labelEquipamentos($valor).'</span>';
                }
                $table[__('Funções')][$i]                  =   $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Equipamento')        ,'usuario_veiculo/Equipamento/Equipamentos_Edit/'.$valor->id.'/'    , '')).
                                                        $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Equipamento')       ,'usuario_veiculo/Equipamento/Equipamentos_Del/'.$valor->id.'/'     , __('Deseja realmente deletar esse Equipamento ?')));
                ++$i;
            }
            if ($export !== false) {
                self::Export_Todos($export, $table, 'Equipamentos');
            } else {
                $this->_Visual->Show_Tabela_DataTable($table);
            }
            unset($table);
        } else { 
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum '.$titulo2.'</font></b></center>');
        }
        $titulo_janela = 'Listagem de '.$titulo.' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo_janela);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', $titulo_janela);
    }
    /**
     * Deleta Campos de Propostas 
     * @param type $campos
     * @param type $tema
     */
    static function Campos_Deletar(&$campos) {
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_Status')) {
            self::DAO_Campos_Retira($campos, 'status');
        }
        
        
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Fornecedor') === false) {
            self::DAO_Campos_Retira($campos,'fornecedor');
        }
        
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_Equipamento_Marca') === false) {
            self::DAO_Campos_Retira($campos,'marca');
            self::DAO_Campos_Retira($campos,'modelo');
        }
    }
    public function StatusEquipamentos($id = false) {
        
        if ($id === false) {
            return false;
        }
        $id = (int) $id;
        $resultado = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Equipamento', 'id = '.$id,1);
        
        if ($resultado === false || !is_object($resultado)) {
            return false;
        }
        
        if ($resultado->status=='0') { // de aprovada para Aprovada em Execução
            $resultado->status='1';
        } else if ($resultado->status=='1') { // de Aprovada em Execução para Finalizada
            $resultado->status='2';

        } else if ($resultado->status=='2') { // de Finalizada em Execução para Aprovada em Execução
            $resultado->status='0';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if ($sucesso) {
            if ($resultado->status=='0') {
                $texto = __('Ocupada');
            } else if ($resultado->status=='1') {
                $texto = __('Livre');
            } else {
                $texto = __('Em uso');
            }
            $conteudo = array(
                'location' => '.statusEquipamentos'.$resultado->id,
                'js' => '',
                'html' =>  self::labelEquipamentos($resultado)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public static function labelEquipamentos($objeto, $link= true ) {
        $status = $objeto->status;
        $id = $objeto->id;
        if ($status=='0') {
            $tipo = 'warning';
            $nometipo = __('Ocupada');
        }
        else if ($status=='1') {
            $tipo = 'success';
            $nometipo = __('Livre');
        }
        else {
            $tipo = 'info';
            $nometipo = __('Em uso');
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if ($link === true) {
            $html = '<a href="'.URL_PATH.'usuario_veiculo/Equipamento/StatusEquipamentos/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" data-acao="" data-confirma="Deseja Realmente alterar o Status?">'.$html.'</a>';
        }
        return $html;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Equipamentos_Add() {   
        self::Endereco_Equipamento(true);   
        $titulo = __('Equipamentos');
        $titulo_singular = \Framework\Classes\Texto::Transformar_Plural_Singular($titulo);  
        // Carrega Config
        $titulo1    = 'Adicionar '.$titulo_singular;
        $titulo2    = 'Salvar '.$titulo_singular;
        $formid     = 'form_Sistema_Admin_Equipamentos';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_veiculo/Equipamento/Equipamentos_Add2/';
        $campos = Usuario_Veiculo_Equipamento_DAO::Get_Colunas();
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Equipamentos_Add2() {
        $titulo_plural = __('Equipamentos');
        $titulo_singular = \Framework\Classes\Texto::Transformar_Plural_Singular($titulo_plural);  
        $titulo     = $titulo_singular.' Adicionado com Sucesso';
        $dao        = 'Usuario_Veiculo_Equipamento';
        $function     = '$this->Equipamentos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = $titulo_singular.' cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Equipamentos_Edit($id) {
        $titulo_plural = __('Equipamentos');
        $titulo_singular = \Framework\Classes\Texto::Transformar_Plural_Singular($titulo_plural);  
        self::Endereco_Equipamento(true);     
        // Carrega Config
        $titulo1    = 'Editar '.$titulo_singular.' (#'.$id.')';
        $titulo2    = 'Alteração de '.$titulo_singular;
        $formid     = 'form_Sistema_AdminC_EquipamentoEdit';
        $formbt     = 'Alterar '.$titulo_singular;
        $formlink   = 'usuario_veiculo/Equipamento/Equipamentos_Edit2/'.$id;
        $editar     = Array('Usuario_Veiculo_Equipamento', $id);
        $campos = Usuario_Veiculo_Equipamento_DAO::Get_Colunas();
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Equipamentos_Edit2($id) {
        $titulo_plural = __('Equipamentos');
        $titulo_singular = \Framework\Classes\Texto::Transformar_Plural_Singular($titulo_plural); 
        $titulo     = $titulo_singular.' Editado com Sucesso';
        $dao        = Array('Usuario_Veiculo_Equipamento', $id);
        $function     = '$this->Equipamentos();';
        $sucesso1   = __('Equipamento Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Equipamentos_Del($id) {
        
        $titulo_plural = __('Equipamentos');
        $titulo_singular = \Framework\Classes\Texto::Transformar_Plural_Singular($titulo_plural); 
        
    	$id = (int) $id;
        // Puxa equipamento e deleta
        $equipamento = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Equipamento', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($equipamento);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => $titulo_singular.' Deletado com sucesso'
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Equipamentos();
        
        $this->_Visual->Json_Info_Update('Titulo', $titulo_singular.' deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Marcas($export = false) {
        self::Endereco_Equipamento_Marca(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Marca',
                'usuario_veiculo/Equipamento/Marcas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario_veiculo/Equipamento/Marcas',
            )
        )));
        $marcas = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Equipamento_Marca');
        if ($marcas !== false && !empty($marcas)) {
            if (is_object($marcas)) $marcas = Array(0=>$marcas);
            reset($marcas);
            foreach ($marcas as $indice=>&$valor) {
                //$table[__('#Id')][$i]       = '#'.$valor->id;
                $table[__('Nome')][$i]      = $valor->nome;
                $table[__('Funções')][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Marca')        ,'usuario_veiculo/Equipamento/Marcas_Edit/'.$valor->id.'/'    , '')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Marca')       ,'usuario_veiculo/Equipamento/Marcas_Del/'.$valor->id.'/'     , __('Deseja realmente deletar essa Marca ?')));
                ++$i;
            }
            if ($export !== false) {
                self::Export_Todos($export, $table, 'Equipamentos - Marcas');
            } else {
                $this->_Visual->Show_Tabela_DataTable($table);
            }
            unset($table);
        } else {        
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Marca</font></b></center>');
        }
        $titulo = __('Listagem de Marcas').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Marcas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Marcas_Add() {
        self::Endereco_Equipamento_Marca(true);
        // Carrega Config
        $titulo1    = __('Adicionar Marca');
        $titulo2    = __('Salvar Marca');
        $formid     = 'form_Sistema_Admin_Marcas';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_veiculo/Equipamento/Marcas_Add2/';
        $campos = Usuario_Veiculo_Equipamento_Marca_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Marcas_Add2() {
        $titulo     = __('Marca Adicionada com Sucesso');
        $dao        = 'Usuario_Veiculo_Equipamento_Marca';
        $function     = '$this->Marcas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Marca cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Marcas_Edit($id) {
        self::Endereco_Equipamento_Marca(true);
        // Carrega Config
        $titulo1    = 'Editar Marca (#'.$id.')';
        $titulo2    = __('Alteração de Marca');
        $formid     = 'form_Sistema_AdminC_MarcaEdit';
        $formbt     = __('Alterar Marca');
        $formlink   = 'usuario_veiculo/Equipamento/Marcas_Edit2/'.$id;
        $editar     = Array('Usuario_Veiculo_Equipamento_Marca', $id);
        $campos = Usuario_Veiculo_Equipamento_Marca_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Marcas_Edit2($id) {
        $titulo     = __('Marca Editada com Sucesso');
        $dao        = Array('Usuario_Veiculo_Equipamento_Marca', $id);
        $function     = '$this->Marcas();';
        $sucesso1   = __('Marca Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Marcas_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa marca e deleta
        $marca = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Equipamento_Marca', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($marca);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Marca Deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Marcas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Marca deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Modelos($export = false) {
        $i = 0;
        self::Endereco_Equipamento_Modelo(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Modelo',
                'usuario_veiculo/Equipamento/Modelos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario_veiculo/Equipamento/Modelos',
            )
        )));
        $modelos = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Equipamento_Modelo');
        if ($modelos !== false && !empty($modelos)) {
            if (is_object($modelos)) $modelos = Array(0=>$modelos);
            reset($modelos);
            foreach ($modelos as $indice=>&$valor) {
                //$table[__('#Id')][$i]     = '#'.$valor->id;
                $table[__('Marca')][$i]     = $valor->marca2;
                $table[__('Nome')][$i]      = $valor->nome;
                $table[__('Funções')][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Modelo')        ,'usuario_veiculo/Equipamento/Modelos_Edit/'.$valor->id.'/'    , '')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Modelo')       ,'usuario_veiculo/Equipamento/Modelos_Del/'.$valor->id.'/'     , __('Deseja realmente deletar essa Modelo ?')));
                ++$i;
            }
            if ($export !== false) {
                self::Export_Todos($export, $table, 'Equipamentos - Modelos');
            } else {
                $this->_Visual->Show_Tabela_DataTable($table);
            }
            unset($table);
        } else {       
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Modelo</font></b></center>');
        }
        $titulo = __('Listagem de Modelos').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Modelos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Modelos_Add() {
        self::Endereco_Equipamento_Modelo(true);
        // Carrega Config
        $titulo1    = __('Adicionar Modelo');
        $titulo2    = __('Salvar Modelo');
        $formid     = 'form_Sistema_Admin_Modelos';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_veiculo/Equipamento/Modelos_Add2/';
        $campos = Usuario_Veiculo_Equipamento_Modelo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Modelos_Add2() {
        $titulo     = __('Modelo Adicionado com Sucesso');
        $dao        = 'Usuario_Veiculo_Equipamento_Modelo';
        $function     = '$this->Modelos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Modelo cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Modelos_Edit($id) {
        self::Endereco_Equipamento_Modelo(true);
        // Carrega Config
        $titulo1    = 'Editar Modelo (#'.$id.')';
        $titulo2    = __('Alteração de Modelo');
        $formid     = 'form_Sistema_AdminC_ModeloEdit';
        $formbt     = __('Alterar Modelo');
        $formlink   = 'usuario_veiculo/Equipamento/Modelos_Edit2/'.$id;
        $editar     = Array('Usuario_Veiculo_Equipamento_Modelo', $id);
        $campos = Usuario_Veiculo_Equipamento_Modelo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Modelos_Edit2($id) {
        $titulo     = __('Modelo Editada com Sucesso');
        $dao        = Array('Usuario_Veiculo_Equipamento_Modelo', $id);
        $function     = '$this->Modelos();';
        $sucesso1   = __('Modelo Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Modelos_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa modelo e deleta
        $Modelo = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Equipamento_Modelo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($Modelo);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Modelo Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Modelos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Modelo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
