<?php
class comercio_EstoqueControle extends comercio_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_rede_PerfilModelo::Carrega Rede Modelo
    * @uses comercio_rede_PerfilVisual::Carrega Rede Visual
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
    * @uses comercio_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio/Estoque/Estoques');
        return FALSE;
    }
    static function Endereco_Estoque($true= TRUE, $produto = FALSE) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($produto === FALSE) {
            $titulo = __('Histórico de Estoque');
            $link = 'comercio/Estoque/Estoques';
        } else {
            $titulo = 'Histórico de Estoque de '.$produto->nome;
            $link = 'comercio/Estoque/Estoques/'.$produto->id;
            comercio_ProdutoControle::Endereco_Produto();
        }
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Entrada_Material($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Entrada de Material');
        $link = 'comercio/Estoque/Material_Entrada';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Estoques($produto = FALSE) {
        $i = 0;
        if ($produto === FALSE) {
            $where = Array();
            self::Endereco_Estoque(FALSE);
        } else {
            $produto_id = (int) $produto; 
            $produtos = $this->_Modelo->db->Sql_Select('Comercio_Produto',Array('id'=>$produto_id),1);
            if ($produtos === FALSE) return _Sistema_erroControle::Erro_Fluxo('Produto não existe:'.$produto_id,404);
            $where = Array('produto'=>$produto_id);
            self::Endereco_Estoque(FALSE, $produtos);
        }
        $estoques = $this->_Modelo->db->Sql_Select('Comercio_Produto_Estoque', $where);
        if ($estoques !== FALSE && !empty($estoques)) {
            if (is_object($estoques)) $estoques = Array(0=>$estoques);
            reset($estoques);
            foreach ($estoques as &$valor) {
                if ($produto === FALSE) $produto_id = (int) $valor->produto;
                $valor->qnt     = (int) $valor->qnt;
                if ($valor->produto>0 && $valor->qnt>0) {
                    $chamar = $valor->motivo.'_Modelo';
                    if (!class_exists($chamar)) {
                        $chamar = $valor->motivo.'Modelo';
                    }
                    if (class_exists($chamar)) {
                        if ($valor->positivo==0) {
                            $antes = '<p class="text-error">';
                            $depois = '</a>';
                            $table['Tipo'][$i]      = $antes.'Retirada'.$depois;
                        } else {
                            $antes = '';
                            $depois = '';
                            $table['Tipo'][$i]      = $antes.'Entrada'.$depois;
                        }
                        if ($valor->data!==NULL && $valor->data!=='' && $valor->data!=='0000-00-00' && $valor->data!=='00/00/0000') {
                            $data = $valor->data;
                        } else {
                            $data = $valor->log_date_add;
                        }
                        $table['Data'][$i]      = $data; //$antes.$data.$depois;
                        //$table['#Id'][$i]       = '#'.$valor->id;
                        

                        list(
                                $motivo,
                                $responsavel
                        )                                       = $chamar::Estoque_Exibir($produto_id, $valor->motivoid);
                        $table['Motivo'][$i]                   = $antes.$motivo.$depois;
                        $table['Responsavel'][$i]              = $responsavel; //$antes.$responsavel.$depois;
                    
                        $table['Quantidade'][$i]      = $antes.$valor->qnt.$depois;
                        ++$i;
                    }
                }
            }
            $this->_Visual->Show_Tabela_DataTable(
                $table, '', TRUE, FALSE,
                Array(Array(1,'desc'))
            );
            unset($table);
        }
        // Se tiver Vazio
        if ($i==0) {       
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.('Nenhuma Movimentação de Estoque').'</font></b></center>');
        }
        $titulo = __('Histórico de Movimentação de Estoque').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Estoques'));
    }
    /**
     * 
     * @param type $produto
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Estoque_Retorna($produto = FALSE) {
        $produto = (int) $produto;
        $quantidade = 0;
        $estoques = \Framework\App\Registro::getInstacia()->_Modelo->db->Sql_Select(
            'Comercio_Produto_Estoque',
            '{sigla}produto=\''.$produto.'\''
        );
        if ($estoques !== FALSE && !empty($estoques)) {
            if (is_object($estoques)) $estoques = Array(0=>$estoques);
            reset($estoques);
            foreach ($estoques as &$valor) {
                $valor->qnt = (int) $valor->qnt;
                if ($valor->positivo==0) {
                    $quantidade = $quantidade-(int) $valor->qnt;
                } else {
                    $quantidade = $quantidade+$valor->qnt;
                }
            }
        }
        return $quantidade;
    }
    /**
     * 
     * @param type $motivo
     * @param type $motivoid
     * @param type $produto
     * @param type $qnt
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Estoque_Inserir($motivo, $motivoid, $produto, $qnt, $data = FALSE) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        if ($data === FALSE) {
            $data = APP_DATA;
        }
        $estoque = new \Comercio_Produto_Estoque_DAO();
        $estoque->positivo  = 1;
        $estoque->motivo    = $motivo;
        $estoque->motivoid  = $motivoid;
        $estoque->produto   = $produto;
        $estoque->qnt       = $qnt;
        $estoque->data      = $data;
        $_Modelo->db->Sql_Insert($estoque);
        return TRUE;
    }
    /**
     * 
     * @param type $motivo
     * @param type $motivoid
     * @param type $produto
     * @param type $qnt
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Estoque_Remover($motivo, $motivoid, $produto, $qnt, $data = FALSE) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        if ($data === FALSE) {
            $data = APP_DATA;
        }
        $estoque = new \Comercio_Produto_Estoque_DAO();
        $estoque->positivo = 0;
        $estoque->motivo    = $motivo;
        $estoque->motivoid  = $motivoid;
        $estoque->produto   = $produto;
        $estoque->qnt       = $qnt;
        $estoque->data      = $data;
        $_Modelo->db->Sql_Insert($estoque);
        return TRUE;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    protected static function Campos_Deletar_Material(&$campos) {
        if (!(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto') && \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque'))) {
            self::DAO_Campos_Retira($campos, 'Produtos Comprados');
        }
        
        
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque_EntradaCategoria')) {
            self::DAO_Campos_Retira($campos, 'categoria');
        }
        
        
    }
    public function Material_Entrada($export = FALSE) {
        self::Endereco_Entrada_Material(FALSE);
        $i = 0;
        // BOTAO IMPRIMIR / ADD
        /*$this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Entrada de NFE',
                'comercio/Estoque/Material_Entrada_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'comercio/Estoque/Material_Entrada',
            )
        )));
        
        if ($export !== FALSE) {
            $materiais = $this->_Modelo->db->Sql_Select('Comercio_Fornecedor_Material', FALSE,0, '');

            if ($materiais !== FALSE && !empty($materiais)) {
                $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Material_Entrada_Edit');
                $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Material_Entrada_Del');

                if (is_object($materiais)) $materiais = Array(0=>$materiais);
                reset($materiais);
                foreach ($materiais as &$valor) {
                    if ($valor->documento==0) {
                        $documento = __('Nfe');
                    } else if ($valor->documento==1) {
                        $documento = __('Boleto');
                    } else {
                        $documento = __('Recibo');
                    }
                    $table['Número'][$i]           = $valor->numero;
                    $table['Documento'][$i]        = $documento;
                    $table['Fornecedor'][$i]       = $valor->fornecedor2;
                    $table['Data'][$i]             = $valor->data;
                    $table['Valor'][$i]            = $valor->valor;
                    $table['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Entrada de NFE'        ,'comercio/Estoque/Material_Entrada_Edit/'.$valor->id.'/'    , ''), $permissionEdit).
                                               $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Entrada de NFE'       ,'comercio/Estoque/Material_Entrada_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Entrada de NFE ?'), $permissionDelete);
                    ++$i;
                }
                unset($table);
            }  
            self::Export_Todos($export, $table, 'Comercio - Produtos (Estoque)');
        } else {*/
            $table = Array(
                'Número', 'Documento', 'Fornecedor', 'Data', 'Valor', 'Funções'
            );
        //}
        $this->_Visual->Show_Tabela_DataTable_Massiva($table,'comercio/Estoque/Material_Entrada');
        /*
        } else {             
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Entrada de NFE</font></b></center>');
        }*/
        $titulo = __('Listagem de Entrada de NFE').' (<span id="DataTable_Contador">0</span>)';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',0,Array("link"=>"comercio/Estoque/Material_Entrada_Add",'icon'=>'add', 'nome'=>'Adicionar Entrada de NFE'));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Entrada de NFE'));
    }
    public function Material_Entrada_Add() {
        self::Endereco_Entrada_Material(TRUE);
         // Carrega Config
        $titulo1    = __('Adicionar Entrada de NFE');
        $titulo2    = __('Salvar Entrada de NFE');
        $formid     = 'form_comercio_Estoque_Entrada';
        $formbt     = __('Salvar');
        $formlink   = 'comercio/Estoque/Material_Entrada_Add2/';
        $campos = Comercio_Fornecedor_Material_DAO::Get_Colunas();
        self::Campos_Deletar_Material($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Material_Entrada_Add2() {
        if (!isset($_POST['fornecedor'])) return FALSE;
        $titulo     = __('Entrada de NFE Adicionada com Sucesso');
        $dao        = 'Comercio_Fornecedor_Material';
        $function     = FALSE;
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Entrada de NFE cadastrada com sucesso.');
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
        if ($sucesso === TRUE) {
            $motivo = 'comercio_Estoque';
            $identificador  = $this->_Modelo->db->Sql_Select('Comercio_Fornecedor_Material', Array(),1,'id DESC');
            $identificador  = $identificador->id;
            $idfornecedor  = (int) $_POST['fornecedor'];
            /*
             * TRABALHA COM ESTOQUE se tiver produtos
             */
            
            if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto') && \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque')) {

               // Pega A Entrada
                $produto  = $this->_Modelo->db->Sql_Select(
                    'Comercio_Fornecedor_Material_Produtos', 
                    Array(
                        'entrada'     =>  $identificador
                    )
                );
                // Pega os Valores do Serviço de Instalaçao
                if ($produto !== FALSE) {
                    if (is_object($produto)) $produto = Array($produto);
                    foreach($produto as &$valor) {
                        self::Estoque_Inserir($motivo, $identificador, $valor->produto, $valor->prod_qnt);
                    }
                }
            }
            /*
             * TRABALHA PARCELAS DO FINANCEIRO
             */
            // Passa tudo pra Contas a Receber
            Financeiro_PagamentoControle::Condicao_GerarPagamento(
                \Framework\App\Conexao::anti_injection($_POST["condicao_pagar"]),    // Condição de Pagamento
                $motivo,                                      // Motivo
                $identificador,                               // MotivoID
                'Servidor',                                   // Entrada_Motivo
                SRV_NAME_SQL,                                 // Entrada_MotivoID
                'Servidor',                                   // Saida_Motivo
                $idfornecedor,                                // Saida_MotivoID
                \Framework\App\Conexao::anti_injection($_POST["valor"]),             // Valor
                \Framework\App\Conexao::anti_injection($_POST["primeiro_pagamento"]),// Data Inicial
                (int) $_POST["categoria"]                     // Categoria
            );
        }
        $this->Material_Entrada();
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Material_Entrada_Edit($id) {
        self::Endereco_Entrada_Material(TRUE);
        // Carrega Config
        $titulo1    = 'Editar Entrada de NFE (#'.$id.')';
        $titulo2    = __('Alteração de Entrada de NFE');
        $formid     = 'form_Sistema_AdminC_Entrada_MaterialEdit';
        $formbt     = __('Alterar Entrada de NFE');
        $formlink   = 'comercio/Estoque/Material_Entrada_Edit2/'.$id;
        $editar     = Array('Comercio_Fornecedor_Material', $id);
        $campos = Comercio_Fornecedor_Material_DAO::Get_Colunas();
        self::Campos_Deletar_Material($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Material_Entrada_Edit2($id) {
        $id = (int) $id;
        $titulo     = __('Entrada de NFE Editada com Sucesso');
        $dao        = Array('Comercio_Fornecedor_Material', $id);
        $function     = FALSE;
        $sucesso1   = __('Entrada de NFE Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["documento"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);  
        if ($sucesso === TRUE) {
            
            $motivo = 'comercio_Estoque';

            $identificador  = $id;
            $idfornecedor  = (int) $_POST['fornecedor'];
            /*
             * TRABALHA COM ESTOQUE se tiver produtos
             */
            
            if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto') && \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque')) {
                // Deleta Antigo
                $material = $this->_Modelo->db->Sql_Select('Comercio_Produto_Estoque', Array('motivo'=>$motivo,'motivoid'=>$id));
                $sucesso2 =  $this->_Modelo->db->Sql_Delete($material,TRUE);
                // Pega A Entrada
                $produto  = $this->_Modelo->db->Sql_Select(
                    'Comercio_Fornecedor_Material_Produtos', 
                    Array(
                        'entrada'     =>  $identificador
                    )
                );
                // Pega os Valores do Serviço de Instalaçao
                if ($produto !== FALSE) {
                    if (is_object($produto)) $produto = Array($produto);
                    foreach($produto as &$valor) {
                        self::Estoque_Inserir($motivo, $identificador, $valor->produto, $valor->prod_qnt);
                    }
                }
            }
            /*
             * TRABALHA PARCELAS DO FINANCEIRO
             */
            // Passa tudo pra Contas a Receber
            $financeiro = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', Array('motivo'=>$motivo,'motivoid'=>$id));
            $sucesso3 =  $this->_Modelo->db->Sql_Delete($financeiro,TRUE);
            Financeiro_PagamentoControle::Condicao_GerarPagamento(
                \Framework\App\Conexao::anti_injection($_POST["condicao_pagar"]),    // Condição de Pagamento
                $motivo,                                      // Motivo
                $identificador,                               // MotivoID
                'Servidor',                                   // Entrada_Motivo
                SRV_NAME_SQL,                                 // Entrada_MotivoID
                'Servidor',                                   // Saida_Motivo
                $idfornecedor,                                // Saida_MotivoID
                \Framework\App\Conexao::anti_injection($_POST["valor"]),             // Valor
                \Framework\App\Conexao::anti_injection($_POST["primeiro_pagamento"]),// Data Inicial
                (int) $_POST["categoria"]                     // Categoria
            );
        }    
        $this->Material_Entrada();
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Material_Entrada_Del($id) {
        
        
    	$id = (int) $id;
        $motivo = 'comercio_Estoque';
        // Puxa material e deleta
        $entrada = $this->_Modelo->db->Sql_Select('Comercio_Fornecedor_Material', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($entrada);
        
        $material = $this->_Modelo->db->Sql_Select('Comercio_Produto_Estoque', Array('motivo'=>$motivo,'motivoid'=>$id));
        $sucesso2 =  $this->_Modelo->db->Sql_Delete($material,TRUE);
        
        $financeiro = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', Array('motivo'=>$motivo,'motivoid'=>$id));
        $sucesso3 =  $this->_Modelo->db->Sql_Delete($financeiro,TRUE);
        
        $produtos = $this->_Modelo->db->Sql_Select('Comercio_Fornecedor_Material_Produtos', Array('Entrada'=>$id));
        $sucesso4 =  $this->_Modelo->db->Sql_Delete($produtos,TRUE);
        
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Entrada de NFE Deletada com sucesso')
            );
            $this->_Visual->Json_Info_Update('Titulo', __('Entrada de NFE deletada com Sucesso'));  
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
            $this->_Visual->Json_Info_Update('Titulo', __('Erro'));
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Material_Entrada();
        
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
