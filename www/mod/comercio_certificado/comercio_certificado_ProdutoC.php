<?php
class comercio_certificado_ProdutoControle extends comercio_certificado_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_certificado_rede_PerfilModelo::Carrega Rede Modelo
    * @uses comercio_certificado_rede_PerfilVisual::Carrega Rede Visual
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
    * @uses comercio_certificado_Controle::$certificadoPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        ///$this->Propostas();
        $this->_Visual->Bloco_Customizavel(Array(
            Array(
                'span'      =>      5,
                'conteudo'  =>  Array(Array(
                    'div_ext'   =>      false,
                    'title_id'  =>      'produtosmodificar_titulo',
                    'title'     =>      'Cadastrar Produto',
                    'html'      =>      '<span id="produtosmodificar">'.$this->Produtos_Add(true).'</span>',
                ),Array(
                    'div_ext'   =>      ' style="display:none;"  id="produtos_auditorias"',
                    'title_id'  =>      false,
                    'title'     =>      'Auditoria',
                    'html'      =>      '<span id="produtos_auditoriascorpo">Produtos</span>',
                ),),
            ),
            Array(
                'span'      =>      7,
                'conteudo'  =>  Array(Array(
                    'div_ext'   =>      false,
                    'title_id'  =>      false,
                    'title'     =>      'Produtos Cadastrados',
                    'html'      =>      $this->Produtos(),
                ),),
            )
        ));
        
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Propostas');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos(){
        $i = 0;
        $html = '<span id="prodaddmostrar" style="display: none;"><a title="Adicionar Produto" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'comercio_certificado/Produto/Produtos_Add">Adicionar novo Produto</a><div class="space15"></div></span>';
        $produto = $this->_Modelo->db->Sql_Select('Comercio_Produto');
        if($produto!==false && !empty($produto)){
            if(is_object($produto)) $produto = Array(0=>$produto);
            reset($produto);
            foreach ($produto as $indice=>&$valor) {
                $tabela['Sigla'][$i]     = $valor->sigla;
                $tabela['Descrição'][$i] = $valor->obs;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Produto'        ,'comercio_certificado/Produto/Produtos_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Produto'       ,'comercio_certificado/Produto/Produtos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Produto ?'));
                ++$i;
            }
            return $html.$this->_Visual->Show_Tabela_DataTable($tabela,'',false);
        }else{
            $html .= '<center><b><font color="#FF0000" size="5">Nenhum Produto</font></b></center>';            
            return $html;
        }
    }
    public static function Retirar_Nao_necessarios(&$campos){
        //comercio_ProdutoControle::Retirar_Nao_necessarios($campos);
        self::DAO_Campos_Retira($campos,'cod',0);
        self::DAO_Campos_Retira($campos,'marca',0);
        self::DAO_Campos_Retira($campos,'linha',0);
        self::DAO_Campos_Retira($campos,'familia',0);
        self::DAO_Campos_Retira($campos,'nome',0);
        self::DAO_Campos_Retira($campos,'unidade',0);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos_Add($direto=false){
        // Carrega campos e retira os que nao precisam
        $campos = Comercio_Produto_DAO::Get_Colunas();
        self::Retirar_Nao_necessarios($campos);
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Sistema_Admin_Produtos','comercio_certificado/Produto/Produtos_Add2/','formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Cadastrar');
        if($direto===true){
            return $formulario;
        }else{
            // Json
            $conteudo = array(
                'location'  =>  '#produtosmodificar_titulo',
                'js'        =>  '$("#produtos_auditorias").hide();',
                'html'      =>  'Cadastrar Produto'
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $conteudo = array(
                'location'  =>  '#produtosmodificar',
                'js'        =>  '$("#prodaddmostrar").hide();',
                'html'      =>  $formulario
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', 'Cadastrar Produto');
            $this->_Visual->Json_Info_Update('Historico', false);
        }
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos_Edit($id){
        $id = (int) $id;
        // Carrega campos e retira os que nao precisam
        $campos = Comercio_Produto_DAO::Get_Colunas();
        self::Retirar_Nao_necessarios($campos);
        // recupera produto
        $produto = $this->_Modelo->db->Sql_Select('Comercio_Produto', Array('id'=>$id));
        self::mysql_AtualizaValores($campos, $produto);

        // edicao de produtos
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_ProdutoEdit','comercio_certificado/Produto/Produtos_Edit2/'.$id.'/','formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Alterar Produto');
        // Json
        $conteudo = array(
            'location'  =>  '#produtosmodificar_titulo',
            'js'        =>  '$("#produtos_auditorias").show();',
            'html'      =>  'Editar Produto (#'.$id.')'
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        $conteudo = array(
            'location'  =>  '#produtosmodificar',
            'js'        =>  '$("#prodaddmostrar").show();',
            'html'      =>  $formulario
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        // Auditorias
        $conteudo = array(
            'location'  =>  '#produtos_auditoriascorpo',
            'js'        =>  '$("#prodaddmostrar").show();',
            'html'      =>  $this->Auditorias($produto->id)
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        // Info Pagina
        $this->_Visual->Json_Info_Update('Titulo', 'Editar Produto (#'.$id.')');
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos_Add2(){
        global $language;
        
        // Cria novo Produto
        $produto = new Comercio_Produto_DAO;
        self::mysql_AtualizaValores($produto);
        $sucesso =  $this->_Modelo->db->Sql_Inserir($produto);
        
        // Recarrega Main
        $this->Main();  
        
        // Mostra Mensagem de Sucesso
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Inserção bem sucedida',
                "mgs_secundaria" => 'Produto cadastrado com sucesso.'
            ); 
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        // Json
        $this->_Visual->Json_Info_Update('Titulo', 'Produto Adicionado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Produtos_Edit2($id){
        global $language;
        $id = (int) $id;
        // Puxa o produto, e altera seus valores, depois salva novamente
        $produto = $this->_Modelo->db->Sql_Select('Comercio_Produto', Array('id'=>$id));
        self::mysql_AtualizaValores($produto);
        $sucesso =  $this->_Modelo->db->Sql_Update($produto);
        // Atualiza
        $this->Main();
        // Mensagem
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Produto Alterado com Sucesso',
                "mgs_secundaria" => ''.$_POST["nome"].' teve a alteração bem sucedida'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        
        
        //Json
        $this->_Visual->Json_Info_Update('Titulo', 'Produto Editado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);    
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
        
        $this->Main();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Produto deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Auditorias($produtos=0){
        $auditorias = $this->_Modelo->db->Sql_Select(
                'Comercio_Certificado_Auditoria', 
                Array('idproduto'=>$produtos),0,'id'
        );
        // Carrega Formulario
        $botao = $this->_Visual->Tema_Elementos_Btn('Superior',Array('Add','#','return inputadd();'));
        $formulario = new \Framework\Classes\Form('Formulario_de_Auditorias','comercio_certificado/Produto/Auditorias_Modificar/'.$produtos,'formajax');
        $formulario->addtexto('<span id="Formulario_de_Auditorias_Input">');
        if($auditorias===false){
            $input = \Framework\App\Sistema_Funcoes::HTML_min($formulario->Input_Novo('Auditoria 1', 'auditoria[]', 0, 'text', 11, '','(Meses)'));
        }else{
            $i      = 0 ;
            foreach($auditorias as $indice=>&$valor){
                if($valor->meses!='' && $valor->meses!=0 && $valor->meses!=NULL){
                    if($i==0){
                        $input = \Framework\App\Sistema_Funcoes::HTML_min($formulario->Input_Novo('Auditoria '.($i+1), 'auditoria[]', $valor->meses, 'text', 11, '','(Meses)'));
                        $input = str_replace(Array('value="4"'), Array('value="0"'), $input);
                    }else{
                        $formulario->Input_Novo('Auditoria '.($i+1), 'auditoria[]', $valor->meses, 'text', 11, '','(Meses)');
                    }
                    ++$i;
                }else{
                    $this->_Modelo->db->Sql_Delete($auditorias[$indice]);
                }
            }
        
        }
        $formulario->addtexto('</span>');
        $html = $formulario->retorna_form('Salvar');
        $html = str_replace(Array('col-12'), Array('col-8'), $html);
        // HTML EXTRA PARA ADD CAMPOS EXTRAS
        $input = str_replace(Array('1:','col-12'), Array('\'+quant+\':','col-8'), $input);
        $html =   $botao.$html.'<script> function inputadd(){'.
                            'var quant = 1+$("#Formulario_de_Auditorias_Input input").size();'.
                            'if(quant>=10) $("#produtos_auditorias > .widget-body > .clearfix").hide();'.
                            '$(\'#Formulario_de_Auditorias_Input\').append( \''.$input.'\' );'.
                            'return false;'.
                        ' }</script>';
        // Faz o Retorno
        return $html;
    }
    public function Auditorias_Modificar($produtos=0){
        GLOBAL $language;
        if($produtos==0) return false;
        #update
        $auditorias_post = \anti_injection($_POST['auditoria']);
        $auditorias_post2 = Array();
        $i = 0;
        $auditorias_sql  = $this->_Modelo->db->Sql_Select(
                'Comercio_Certificado_Auditoria', 
                Array('idproduto'=>$produtos)
        );
        // Organiza
        if(!is_array($auditorias_post)) $auditorias_post = Array($auditorias_post);
        if(is_object($auditorias_sql))  $auditorias_sql  = Array($auditorias_sql );
        // Foreach, tira os que tiverem mes 0
        foreach($auditorias_post as $valor){
            if($valor!=0 && $valor!=NULL && $valor!=''){
                $valor = (int) $valor;
                $auditorias_post2[$i] = $valor;
                ++$i;
            }
        }
        $auditorias_post = $auditorias_post2;
        $j = 0;
        if($auditorias_sql!==false && !empty($auditorias_sql)){
            foreach($auditorias_sql as $valor){
                if($i>=$j){
                    $auditorias_sql[$j]->meses = $auditorias_post[$j];
                    $auditorias_sql[$j]->ordem = $j+1;
                    $sucesso =  $this->_Modelo->db->Sql_Update($auditorias_sql[$j]);
                }else{
                    $sucesso =  $this->_Modelo->db->Sql_Delete($auditorias_sql[$j]);
                }
                ++$j;
            }
        }
        // Cadastra os que faltaram
        while($i>=$j){
            // Cria novo Origem
            $objeto                 = new Comercio_Certificado_Auditoria_DAO;
            $objeto->idproduto      = $produtos;
            $objeto->meses          = $auditorias_post[$j];
            $objeto->ordem          = $j+1;
            $sucesso                = $this->_Modelo->db->Sql_Inserir($objeto);
            ++$j;
        }
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Modificado',
                "mgs_secundaria" => 'Auditorias do Produto editados com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Auditorias
        $conteudo = array(
            'location'  =>  '#produtos_auditoriascorpo',
            'js'        =>  '$("#prodaddmostrar").show();',
            'html'      =>  $this->Auditorias($produtos)
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        // Titulo da Pagina
        $this->_Visual->Json_Info_Update('Titulo', 'Auditoria editada com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>