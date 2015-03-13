<?php
class comercio_ProdutoControle extends comercio_Controle
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
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio/Produto/Produtos');
        return false;
    }
    static function Endereco_Produto($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Produtos','comercio/Produto/Produtos');
        }else{
            $_Controle->Tema_Endereco('Produtos');
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos($export=false){
        self::Endereco_Produto(false);
        $i = 0;
        $ordem = 0;
        $comercio_Produto_Cod       = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Cod');
        $comercio_Produto_Familia   = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Familia');
        $comercio_Estoque           = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque');
        $comercio_Unidade           = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Unidade');
        if($comercio_Produto_Cod)   $ordem = 1;
        if($comercio_Produto_Cod)   $ordem = $ordem+1;
        else                        $ordem = $ordem+2;
        // Add
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Produto',
                'comercio/Produto/Produtos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio/Produto/Produtos',
            )
        )));
        $produto = $this->_Modelo->db->Sql_Select('Comercio_Produto');
        if($produto!==false && !empty($produto)){
            if(is_object($produto)) $produto = Array(0=>$produto);
            reset($produto);
            $perm_view = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Estoques');
            $perm_reduzir = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Estoque_Reduzir');
            $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Edit');
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Del');
            
            foreach ($produto as &$valor) {
                if($comercio_Produto_Cod){
                    $tabela['#Cod'][$i]      = '#'.$valor->cod;
                }
                if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Marca')===true){
                    if($comercio_Produto_Familia=='Familia'){
                        $tabela['Familia'][$i]   = $valor->familia2;
                    }else{
                        $tabela['Marca'][$i]     = $valor->marca2;
                        $tabela['Linha'][$i]     = $valor->linha2;
                    }
                }
                $tabela['Nome'][$i]      = $valor->nome;
        
                // Coloca Preco
                if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Vendas')){
                    $tabela['Preço'][$i]   = $valor->preco;
                }
                
                if($comercio_Estoque){
                    $tabela['Estoque'][$i]   = '<a class="lajax" acao="" href="'.URL_PATH.'comercio/Estoque/Estoques/'.$valor->id.'">'.comercio_EstoqueControle::Estoque_Retorna($valor->id);
                    if($comercio_Unidade){
                        $tabela['Estoque'][$i]   .= ' '.$valor->unidade2;
                    }
                    $tabela['Estoque'][$i] .= '</a>';
                    $tabela['Funções'][$i]  = $this->_Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar Estoque'    ,'comercio/Estoque/Estoques/'.$valor->id.'/'    ,''),$perm_view).
                                            $this->_Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Reduzir Estoque'  ,'comercio/Produto/Estoque_Reduzir/'.$valor->id.'/'    ,'','long-arrow-down','inverse'),$perm_reduzir);
                }else{
                    if($comercio_Unidade){
                        $tabela['Unidade'][$i]   = $valor->unidade2;
                    }
                    $tabela['Funções'][$i]   = '';
                }
                $tabela['Funções'][$i]   .= $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Produto'        ,'comercio/Produto/Produtos_Edit/'.$valor->id.'/'    ,''),$perm_editar).
                                            $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Produto'       ,'comercio/Produto/Produtos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Produto ?'),$perm_del);
                ++$i;
            }
            $ordem = Array($ordem,'asc');
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Comercio - Produtos');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela,'',true,false,Array($ordem));
            }
            unset($tabela);
        }else{            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Produto</font></b></center>');
        }
        $titulo = 'Listagem de Produtos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Produtos');
    }
    public static function Retirar_Nao_necessarios(&$campos){
        // Os dois do Comercio_Certificado
        self::DAO_Campos_Retira($campos,'sigla',0);
        self::DAO_Campos_Retira($campos,'referencia',0);
        
        // Outros
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Obs')){
            self::DAO_Campos_Retira($campos,'obs',0);
        }
        
        // Retira Preco
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Vendas')){
            self::DAO_Campos_Retira($campos,'preco',0);
        }
        
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Marca')===true){
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Familia')==='Familia'){
                self::DAO_Campos_Retira($campos, 'marca');
                self::DAO_Campos_Retira($campos, 'linha');
            }else{
                self::DAO_Campos_Retira($campos, 'familia');
            }
        }else{
            self::DAO_Campos_Retira($campos, 'marca');
            self::DAO_Campos_Retira($campos, 'linha');
            self::DAO_Campos_Retira($campos, 'familia');
        }
        
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Unidade')){
            self::DAO_Campos_Retira($campos, 'unidade');
        }
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Cod')){
            self::DAO_Campos_Retira($campos, 'cod');
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos_Add(){
        self::Endereco_Produto();
        // Carrega Config
        $titulo1    = 'Adicionar Produto';
        $titulo2    = 'Salvar Produto';
        $formid     = 'form_Sistema_Admin_Produtos';
        $formbt     = 'Salvar';
        $formlink   = 'comercio/Produto/Produtos_Add2/';
        $campos = Comercio_Produto_DAO::Get_Colunas();
        self::Retirar_Nao_necessarios($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos_Add2(){
        $titulo     = 'Produto Adicionado com Sucesso';
        $dao        = 'Comercio_Produto';
        $funcao     = '$this->Produtos();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Produto cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
     
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos_Edit($id){
        self::Endereco_Produto();
        // Carrega Config
        $titulo1    = 'Editar Produto (#'.$id.')';
        $titulo2    = 'Alteração de Produto';
        $formid     = 'form_Sistema_AdminC_ProdutoEdit';
        $formbt     = 'Alterar Produto';
        $formlink   = 'comercio/Produto/Produtos_Edit2/'.$id;
        $editar     = Array('Comercio_Produto',$id);
        $campos = comercio_Produto_DAO::Get_Colunas();
        self::Retirar_Nao_necessarios($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);  
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos_Edit2($id){
        $titulo     = 'Produto Editado com Sucesso';
        $dao        = Array('Comercio_Produto',$id);
        $funcao     = '$this->Produtos();';
        $sucesso1   = 'Produto Alterado com Sucesso.';
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
    public function Produtos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa produto e deleta
        $produto = $this->_Modelo->db->Sql_Select('Comercio_Produto', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($produto);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Produto Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Produtos();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Produto deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Estoque_Reduzir($produto=false){
        
        $campos = Comercio_Produto_Estoque_Reduzir_DAO::Get_Colunas();
        if($produto===false || $produto==0){
            $produto = '';
        }else{
            $produto = (int) $produto;
            self::DAO_Campos_Retira($campos, 'produto');
        }
        
        self::Endereco_Produto(true);
         // Carrega Config
        $titulo1    = 'Reduzir Estoque de Produto';
        $titulo2    = 'Salvar Redução de Estoque';
        $formid     = 'form_comercio_Estoque_Entrada';
        $formbt     = 'Salvar';
        $formlink   = 'comercio/Produto/Estoque_Reduzir2/'.$produto;
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Estoque_Reduzir2($produto=false){        
        $titulo     = 'Estoque Reduzido com Sucesso';
        $dao        = 'Comercio_Produto_Estoque_Reduzir';
        $sucesso1   = 'Sucesso';
        $sucesso2   = 'Redução Finalizada com Sucesso';
        if($produto===false || $produto==0){
            //$funcao     = '$this->Produtos(0);';
            $alterar    = Array();
        }else{
            $produto    = (int) $produto;
            $alterar    = Array('produto'=>$produto);
            //$funcao     = '$this->Produtos('.$produto.');';
        }
        $funcao     = '$this->Produtos();';
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        if($sucesso===true){
            $motivo = 'comercio_Produto';
            $identificador  = $this->_Modelo->db->Sql_Select('Comercio_Produto_Estoque_Reduzir', Array(),1,'id DESC');
            $prod  = (int) $identificador->produto;
            $qnt   = (int) $identificador->qnt;
            $identificador_id  = $identificador->id;
            comercio_EstoqueControle::Estoque_Remover($motivo,$identificador_id,$prod,$qnt);
        }
    }
}
?>
