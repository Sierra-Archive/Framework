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
    * @uses comercio_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio/Estoque/Estoques');
        return false;
    }
    static function Endereco_Estoque($true=true,$produto=false){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($produto===false){
            $titulo = 'Histórico de Estoque';
            $link = 'comercio/Estoque/Estoques';
        }else{
            $titulo = 'Histórico de Estoque de '.$produto->nome;
            $link = 'comercio/Estoque/Estoques/'.$produto->id;
            comercio_ProdutoControle::Endereco_Produto();
        }
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Entrada_Material($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Entrada de Material';
        $link = 'comercio/Estoque/Material_Entrada';
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Estoques($produto=false){
        $i = 0;
        if($produto===false){
            $where = Array();
            self::Endereco_Estoque(false);
        }else{
            $produto_id = (int) $produto; 
            $produtos = $this->_Modelo->db->Sql_Select('Comercio_Produto',Array('id'=>$produto_id),1);
            if($produtos===false) throw new \Exception('Produto não existe:'.$produto_id,404);
            $where = Array('produto'=>$produto_id);
            self::Endereco_Estoque(false,$produtos);
        }
        $estoques = $this->_Modelo->db->Sql_Select('Comercio_Produto_Estoque',$where);
        if($estoques!==false && !empty($estoques)){
            if(is_object($estoques)) $estoques = Array(0=>$estoques);
            reset($estoques);
            foreach ($estoques as &$valor) {
                if($produto===false) $produto_id = (int) $valor->produto;
                $valor->qnt     = (int) $valor->qnt;
                if($valor->produto>0 && $valor->qnt>0){
                    $chamar = $valor->motivo.'_Modelo';
                    if(!class_exists($chamar)){
                        $chamar = $valor->motivo.'Modelo';
                    }
                    if(class_exists($chamar)){
                        if($valor->positivo==0){
                            $antes = '<p class="text-error">';
                            $depois = '</a>';
                            $tabela['Tipo'][$i]      = $antes.'Retirada'.$depois;
                        }else{
                            $antes = '';
                            $depois = '';
                            $tabela['Tipo'][$i]      = $antes.'Entrada'.$depois;
                        }
                        if($valor->data!==NULL && $valor->data!=='' && $valor->data!=='0000-00-00' && $valor->data!=='00/00/0000'){
                            $data = $valor->data;
                        }else{
                            $data = $valor->log_date_add;
                        }
                        $tabela['Data'][$i]      = $data; //$antes.$data.$depois;
                        //$tabela['#Id'][$i]       = '#'.$valor->id;
                        

                        list(
                                $motivo,
                                $responsavel
                        )                                       = $chamar::Estoque_Exibir($produto_id,$valor->motivoid);
                        $tabela['Motivo'][$i]                   = $antes.$motivo.$depois;
                        $tabela['Responsavel'][$i]              = $responsavel; //$antes.$responsavel.$depois;
                    
                        $tabela['Quantidade'][$i]      = $antes.$valor->qnt.$depois;
                        ++$i;
                    }
                }
            }
            $this->_Visual->Show_Tabela_DataTable(
                $tabela,'',true,false,
                Array(Array(1,'desc'))
            );
            unset($tabela);
        }
        // Se tiver Vazio
        if($i==0){       
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Movimentação de Estoque</font></b></center>');
        }
        $titulo = 'Histórico de Movimentação de Estoque ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Estoques');
    }
    /**
     * 
     * @param type $produto
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    static function Estoque_Retorna($produto=false){
        $produto = (int) $produto;
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        $quantidade = 0;
        $estoques = $_Modelo->db->Sql_Select(
            'Comercio_Produto_Estoque',
            Array('produto'=>$produto)
        );
        if($estoques!==false && !empty($estoques)){
            if(is_object($estoques)) $estoques = Array(0=>$estoques);
            reset($estoques);
            foreach ($estoques as &$valor) {
                $valor->qnt = (int) $valor->qnt;
                if($valor->positivo==0){
                    $quantidade = $quantidade-(int) $valor->qnt;
                }else{
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
     * @version 2.0
     */
    static function Estoque_Inserir($motivo,$motivoid,$produto,$qnt,$data=false){
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        if($data===false){
            $data = APP_DATA;
        }
        $estoque = new \Comercio_Produto_Estoque_DAO();
        $estoque->positivo  = 1;
        $estoque->motivo    = $motivo;
        $estoque->motivoid  = $motivoid;
        $estoque->produto   = $produto;
        $estoque->qnt       = $qnt;
        $estoque->data      = $data;
        $_Modelo->db->Sql_Inserir($estoque);
        return true;
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
     * @version 2.0
     */
    static function Estoque_Remover($motivo,$motivoid,$produto,$qnt,$data=false){
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        if($data===false){
            $data = APP_DATA;
        }
        $estoque = new \Comercio_Produto_Estoque_DAO();
        $estoque->positivo = 0;
        $estoque->motivo    = $motivo;
        $estoque->motivoid  = $motivoid;
        $estoque->produto   = $produto;
        $estoque->qnt       = $qnt;
        $estoque->data      = $data;
        $_Modelo->db->Sql_Inserir($estoque);
        return true;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    protected static function Campos_Deletar_Material(&$campos){
        if(!(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto') && \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque'))){
            self::DAO_Campos_Retira($campos, 'Produtos Comprados');
        }
        
        
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque_EntradaCategoria')){
            self::DAO_Campos_Retira($campos, 'categoria');
        }
        
        
    }
    public function Material_Entrada($export=false){
        self::Endereco_Entrada_Material(false);
        $i = 0;
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Entrada de NFE',
                'comercio/Estoque/Material_Entrada_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio/Estoque/Material_Entrada',
            )
        )));
        // CONEXAO
        $materiais = $this->_Modelo->db->Sql_Select('Comercio_Fornecedor_Material');
        if($materiais!==false && !empty($materiais)){
            if(is_object($materiais)) $materiais = Array(0=>$materiais);
            reset($materiais);
            foreach ($materiais as &$valor) {
                if($valor->documento==0){
                    $documento = 'Nfe';
                }else if($valor->documento==1){
                    $documento = 'Boleto';
                }else{
                    $documento = 'Recibo';
                }
                $tabela['Número'][$i]           = $valor->numero;
                $tabela['Documento'][$i]        = $documento;
                $tabela['Fornecedor'][$i]       = $valor->fornecedor2;
                $tabela['Data'][$i]             = $valor->data;
                $tabela['Valor'][$i]            = $valor->valor;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Entrada de NFE'        ,'comercio/Estoque/Material_Entrada_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Entrada de NFE'       ,'comercio/Estoque/Material_Entrada_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Entrada de NFE ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Comercio - Produtos (Estoque)');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{             
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Entrada de NFE</font></b></center>');
        }
        $titulo = 'Listagem de Entrada de NFE ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Entrada de NFE');
    }
    public function Material_Entrada_Add(){
        self::Endereco_Entrada_Material(true);
         // Carrega Config
        $titulo1    = 'Adicionar Entrada de NFE';
        $titulo2    = 'Salvar Entrada de NFE';
        $formid     = 'form_comercio_Estoque_Entrada';
        $formbt     = 'Salvar';
        $formlink   = 'comercio/Estoque/Material_Entrada_Add2/';
        $campos = Comercio_Fornecedor_Material_DAO::Get_Colunas();
        self::Campos_Deletar_Material($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Material_Entrada_Add2(){
        $titulo     = 'Entrada de NFE Adicionada com Sucesso';
        $dao        = 'Comercio_Fornecedor_Material';
        $funcao     = false;
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Entrada de NFE cadastrada com sucesso.';
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        if($sucesso===true){
            $motivo = 'comercio_Estoque';
            $identificador  = $this->_Modelo->db->Sql_Select('Comercio_Fornecedor_Material', Array(),1,'id DESC');
            $identificador  = $identificador->id;
            $idfornecedor  = (int) $_POST['fornecedor'];
            /*
             * TRABALHA COM ESTOQUE se tiver produtos
             */
            
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto') && \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque')){

               // Pega A Entrada
                $produto  = $this->_Modelo->db->Sql_Select(
                    'Comercio_Fornecedor_Material_Produtos', 
                    Array(
                        'entrada'     =>  $identificador
                    )
                );
                // Pega os Valores do Serviço de Instalaçao
                if($produto!==false){
                    if(is_object($produto)) $produto = Array($produto);
                    foreach($produto as &$valor){
                        self::Estoque_Inserir($motivo,$identificador,$valor->produto,$valor->prod_qnt);
                    }
                }
            }
            /*
             * TRABALHA PARCELAS DO FINANCEIRO
             */
            // Passa tudo pra Contas a Receber
            Financeiro_PagamentoControle::Condicao_GerarPagamento(
                \anti_injection($_POST["condicao_pagar"]),    // Condição de Pagamento
                $motivo,                                      // Motivo
                $identificador,                               // MotivoID
                'Servidor',                                   // Entrada_Motivo
                SRV_NAME_SQL,                                 // Entrada_MotivoID
                'Servidor',                                   // Saida_Motivo
                $idfornecedor,                                // Saida_MotivoID
                \anti_injection($_POST["valor"]),             // Valor
                \anti_injection($_POST["primeiro_pagamento"]),// Data Inicial
                (int) $_POST["categoria"]                     // Categoria
            );
        }
        $this->Material_Entrada();
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Material_Entrada_Edit($id){
        self::Endereco_Entrada_Material(true);
        // Carrega Config
        $titulo1    = 'Editar Entrada de NFE (#'.$id.')';
        $titulo2    = 'Alteração de Entrada de NFE';
        $formid     = 'form_Sistema_AdminC_Entrada_MaterialEdit';
        $formbt     = 'Alterar Entrada de NFE';
        $formlink   = 'comercio/Estoque/Material_Entrada_Edit2/'.$id;
        $editar     = Array('Comercio_Fornecedor_Material',$id);
        $campos = Comercio_Fornecedor_Material_DAO::Get_Colunas();
        self::Campos_Deletar_Material($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Material_Entrada_Edit2($id){
        $id = (int) $id;
        $titulo     = 'Entrada de NFE Editada com Sucesso';
        $dao        = Array('Comercio_Fornecedor_Material',$id);
        $funcao     = false;
        $sucesso1   = 'Entrada de NFE Alterada com Sucesso.';
        $sucesso2   = ''.$_POST["documento"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);  
        if($sucesso===true){
            
            $motivo = 'comercio_Estoque';

            $identificador  = $id;
            $idfornecedor  = (int) $_POST['fornecedor'];
            /*
             * TRABALHA COM ESTOQUE se tiver produtos
             */
            
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto') && \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque')){
                // Deleta Antigo
                $material = $this->_Modelo->db->Sql_Select('Comercio_Produto_Estoque', Array('motivo'=>$motivo,'motivoid'=>$id));
                $sucesso2 =  $this->_Modelo->db->Sql_Delete($material,true);
                // Pega A Entrada
                $produto  = $this->_Modelo->db->Sql_Select(
                    'Comercio_Fornecedor_Material_Produtos', 
                    Array(
                        'entrada'     =>  $identificador
                    )
                );
                // Pega os Valores do Serviço de Instalaçao
                if($produto!==false){
                    if(is_object($produto)) $produto = Array($produto);
                    foreach($produto as &$valor){
                        self::Estoque_Inserir($motivo,$identificador,$valor->produto,$valor->prod_qnt);
                    }
                }
            }
            /*
             * TRABALHA PARCELAS DO FINANCEIRO
             */
            // Passa tudo pra Contas a Receber
            $financeiro = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', Array('motivo'=>$motivo,'motivoid'=>$id));
            $sucesso3 =  $this->_Modelo->db->Sql_Delete($financeiro,true);
            Financeiro_PagamentoControle::Condicao_GerarPagamento(
                \anti_injection($_POST["condicao_pagar"]),    // Condição de Pagamento
                $motivo,                                      // Motivo
                $identificador,                               // MotivoID
                'Servidor',                                   // Entrada_Motivo
                SRV_NAME_SQL,                                 // Entrada_MotivoID
                'Servidor',                                   // Saida_Motivo
                $idfornecedor,                                // Saida_MotivoID
                \anti_injection($_POST["valor"]),             // Valor
                \anti_injection($_POST["primeiro_pagamento"]),// Data Inicial
                (int) $_POST["categoria"]                     // Categoria
            );
        }    
        $this->Material_Entrada();
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Material_Entrada_Del($id){
        global $language;
        
    	$id = (int) $id;
        $motivo = 'comercio_Estoque';
        // Puxa material e deleta
        $entrada = $this->_Modelo->db->Sql_Select('Comercio_Fornecedor_Material', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($entrada);
        
        $material = $this->_Modelo->db->Sql_Select('Comercio_Produto_Estoque', Array('motivo'=>$motivo,'motivoid'=>$id));
        $sucesso2 =  $this->_Modelo->db->Sql_Delete($material,true);
        
        $financeiro = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', Array('motivo'=>$motivo,'motivoid'=>$id));
        $sucesso3 =  $this->_Modelo->db->Sql_Delete($financeiro,true);
        
        $produtos = $this->_Modelo->db->Sql_Select('Comercio_Fornecedor_Material_Produtos', Array('Entrada'=>$id));
        $sucesso4 =  $this->_Modelo->db->Sql_Delete($produtos,true);
        
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletada',
                "mgs_secundaria" => 'Entrada de NFE Deletada com sucesso'
            );
            $this->_Visual->Json_Info_Update('Titulo', 'Entrada de NFE deletada com Sucesso');  
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
            $this->_Visual->Json_Info_Update('Titulo', $language['mens_erro']['erro']);
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Material_Entrada();
        
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
