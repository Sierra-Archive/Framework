<?php
class comercio_venda_CarrinhoControle extends comercio_venda_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_venda_rede_CarrinhoModelo::Carrega Rede Modelo
    * @uses comercio_venda_rede_CarrinhoView::Carrega Rede View
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
     * FUNCAO PRINCIPAL, EXECUTA O PRIMEIRO PASSO 
     * 
     * @name Main
     * @access public
     * 
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Main(){
        return false;
    }
    static function Endereco_Carrinho($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = __('Caixas');
        $link = 'comercio_venda/Carrinho/Carrinhos';
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
    public function Carrinhos($export=false){
        self::Endereco_Carrinho(false);
        $i = 0;
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Caixa',
                'comercio_venda/Carrinho/Carrinhos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio_venda/Carrinho/Carrinhos',
            )
        )));
        // CONEXAO
        $carrinhos = $this->_Modelo->db->Sql_Select('Comercio_Venda_Carrinho');
        if($carrinhos!==false && !empty($carrinhos)){
            if(is_object($carrinhos)) $carrinhos = Array(0=>$carrinhos);
            reset($carrinhos);
            foreach ($carrinhos as $indice=>&$valor) {
                if($valor->mesa2==NULL){
                    $mesa2 = __('Balcao');
                }else{
                    $mesa2 = $valor->mesa2;
                }
                
                
                $tabela['#Caixa'][$i]       =   '#'.$valor->id;
                $tabela['Mesa'][$i]         =   $mesa2;
                $tabela['Data Aberta'][$i]  =   $valor->data_aberta;
                $tabela['Valor'][$i]        =   $valor->valor;
                $tabela['pago'][$i]         = '<span class="pago'.$valor->id.'">'.self::label($valor).'</span>';
                $tabela['Funções'][$i]      =   $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Caixa'        ,'comercio_venda/Carrinho/Carrinhos_Edit/'.$valor->id.'/'    ,'')).
                                                $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Caixa'       ,'comercio_venda/Carrinho/Carrinhos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Caixa ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Comercio Caixas');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Caixa</font></b></center>');
        }
        $titulo = __('Listagem de Caixas').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Caixas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Carrinhos_Add(){
        self::Endereco_Carrinho(true);
        // Carrega Config
        $titulo1    = __('Adicionar Caixa');
        $titulo2    = __('Salvar Caixa');
        $formid     = 'form_Sistema_Admin_Carrinhos';
        $formbt     = __('Salvar');
        $formlink   = 'comercio_venda/Carrinho/Carrinhos_Add2/';
        $campos = Comercio_Venda_Carrinho_DAO::Get_Colunas();
        // Chama Janela de Calculo de Valor
        $this->Carrinho_Atualizar_Valor_Dinamico_Janela($formid);
        $posicao = __('left');
        //Chama Funcao de Geracao
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,false,$posicao);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Carrinhos_Add2(){
        $titulo     = __('Caixa Adicionado com Sucesso');
        $dao        = 'Comercio_Venda_Carrinho';
        $funcao     = false;
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Caixa cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        
        // Atualiza Valor
        $identificador  = $this->_Modelo->db->Sql_Select('Comercio_Venda_Carrinho', Array(),1,'id DESC');
        $this->Carrinho_Atualizar_Valor($identificador);
        
        // Atualiza Tela
        $this->Carrinhos();
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Carrinhos_Edit($id){
        self::Endereco_Carrinho(true);
        // Carrega Config
        $titulo1    = 'Editar Caixa (#'.$id.')';
        $titulo2    = __('Alteração de Caixa');
        $formid     = 'form_Sistema_AdminC_CarrinhoEdit';
        $formbt     = __('Alterar Caixa');
        $formlink   = 'comercio_venda/Carrinho/Carrinhos_Edit2/'.$id;
        $editar     = Array('Comercio_Venda_Carrinho',$id);
        $campos = Comercio_Venda_Carrinho_DAO::Get_Colunas();
        
        // Calculo de Valores
        $this->Carrinho_Atualizar_Valor_Dinamico_Janela($formid,true);
        $posicao = 'left';
        
        // Gera Formulario
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar,$posicao);
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Carrinhos_Edit2($id){
        $titulo     = __('Caixa Editado com Sucesso');
        $dao        = Array('Comercio_Venda_Carrinho',$id);
        $funcao     = false;
        $sucesso1   = __('Caixa Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["mesa"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        
        // Atualiza valor
        $identificador  = $this->_Modelo->db->Sql_Select('Comercio_Venda_Carrinho', Array('id'=>$id),1);
        $this->Carrinho_Atualizar_Valor($identificador);

        // Recarrega
        $this->Carrinhos();
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Carrinhos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $carrinho = $this->_Modelo->db->Sql_Select('Comercio_Venda_Carrinho', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($carrinho);
        
        // Puxa fornecedor e deleta
        $del1 = $this->_Modelo->db->Sql_Select('Comercio_Venda_Carrinho_Composicoes', Array('carrinho'=>$id));
        $del2      = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', Array('motivo' => 'comercio_venda_Carrinho', 'motivoid'=>$id));
        $material = $this->_Modelo->db->Sql_Select('Comercio_Produto_Estoque', Array('motivo'=>'comercio_venda_Carrinho','motivoid'=>$id));
        $sucesso1 =  $this->_Modelo->db->Sql_Delete($del1,true);
        $sucesso2 =  $this->_Modelo->db->Sql_Delete($del2,true);
        $sucesso3 =  $this->_Modelo->db->Sql_Delete($material,true);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Caixa Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Carrinhos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Caixa deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }   
    /**
     * Pega uma Carrinho/Os e Calcula o seu valor
     * @param type $identificador
     * @return boolean
     */
    private function Carrinho_Atualizar_Valor(&$identificador){
        if(!is_object($identificador)){
            return false;
        }
        
        // Zera Valor
        $valortotal = 0.0;
        
        // Faz Calculo de Composicaos
        $composicao  = $this->_Modelo->db->Sql_Select(
            'Comercio_Venda_Carrinho_Composicoes', 
            Array(
                'carrinho'     =>  $identificador->id
            )
        );
        // Pega os Valores do Serviço de Instalaçao
        if($composicao!==false){
            if(is_object($composicao)) $composicao = Array($composicao);
            foreach($composicao as &$valor){
                // Captura Preço do SUPORTE
                $composicao_registro  = $this->_Modelo->db->Sql_Select(
                    'Comercio_Venda_Composicao' ,
                    Array(
                        'id'            =>  $valor->composicao
                    ),
                    1
                );
                if(is_object($composicao_registro) && $composicao_registro->preco!=NULL){
                    
                    // Procura Produtos Usados
                    $composicao_registro_produtos  = $this->_Modelo->db->Sql_Select(
                        'Comercio_Venda_Composicao_Produtos' ,
                        Array(
                            'composicao'            =>  $valor->composicao
                        )
                    );
                    if(is_object($composicao_registro_produtos)) $composicao_registro_produtos = array($composicao_registro_produtos);
                    foreach($composicao_registro_produtos as &$valor2){
                        // Remove do Estoque
                        comercio_EstoqueControle::Estoque_Remover('comercio_venda_Carrinho',$identificador->id,$valor2->produto,$valor2->qnt);
                    }
                    
                    // Add valor do Composicao
                    $valortotal =   $valortotal
                                    + (Framework\App\Sistema_Funcoes::Tranf_Real_Float($composicao_registro->preco)*$valor->qnt);
                }
            }
        }

        // Deleta Financeiro Anterior
        $financeiro = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', Array('motivo'=>'comercio_venda_Carrinho','motivoid'=>$identificador->id));
        $sucesso3 =  $this->_Modelo->db->Sql_Delete($financeiro,true);
        // Se for Pago Gera Contas Pagas, se nao, gera contas a Receber
        if($identificador->pago==1){
            Financeiro_PagamentoControle::Condicao_GerarPagamento(
                \anti_injection($_POST["condicao_pagar"]),  // Condição de Pagamento
                'comercio_venda_Carrinho',                  // Motivo
                $identificador->id,                         // MotivoID
                'Usuario',                                  // Entrada_Motivo
                $identificador->cliente,                    // Entrada_MotivoID
                'Servidor',                                 // Saida_Motivo
                SRV_NAME_SQL,                               // Saida_MotivoID
                $valortotal,                                // Valor
                false,                                      // Data Inicial,
                0,                                          // Categoria
                1                                           // Pago 1, Nao pago 0
            );
        }else{
            $identificador->pago=0;
            Financeiro_PagamentoControle::Condicao_GerarPagamento(
                \anti_injection($_POST["condicao_pagar"]),  // Condição de Pagamento
                'comercio_venda_Carrinho',                  // Motivo
                $identificador->id,                         // MotivoID
                'Usuario',                                  // Entrada_Motivo
                $identificador->cliente,                    // Entrada_MotivoID
                'Servidor',                                 // Saida_Motivo
                SRV_NAME_SQL,                               // Saida_MotivoID
                $valortotal,                                // Valor
                false,                                      // Data Inicial
                0,                                          // Categoria
                1                                           // Pago 1, Nao pago 0
            );
        }

        
        // Atualiza Valor Total do Carrinho
        $identificador->valor = \Framework\App\Sistema_Funcoes::Tranf_Float_Real($valortotal);
        $this->_Modelo->db->Sql_Update($identificador);
    }
    /**
     * 
     * @param type $time
     * @return boolean
     */
    public function Carrinho_Atualizar_Valor_Dinamico($time){        
        $html = '';
        
        // Zera Valor
        $valortotal = 0.0;

        // Composicaos
        $composicao = \anti_injection($_POST['composicao']);
        // Pega os Valores do Serviço de Instalaçao
        if(!empty($composicao)){
            foreach($composicao as &$valor){
                $valor = (int) $valor;
                if($valor===0 || $valor===NULL) continue;
                // Captura Preço do SUPORTE
                $composicao_registro  = $this->_Modelo->db->Sql_Select(
                    'Comercio_Venda_Composicao', 
                    Array(
                        'id'            =>  $valor
                    ),
                    1
                );
                if(is_object($composicao_registro) && $composicao_registro->preco!=NULL){
                    $prod_qnt    = (int) $_POST['qnt_'.$valor];
                    //$prod_preco  = \anti_injection($_POST['prod_preco_'.$valor]);
                    // Add valor do Composicao
                    $parcial = (Framework\App\Sistema_Funcoes::Tranf_Real_Float($composicao_registro->preco)*$prod_qnt);
                    $valortotal =   $valortotal
                                    + $parcial;// Calcula Valor de Custo da Carrinho
                    $html .= '<b>'.$composicao_registro->nome.':</b> '.Framework\App\Sistema_Funcoes::Tranf_Float_Real($parcial).'<br>';
        
                }
            }
        }
        
        // Calcula Valor de Custo da Carrinho
        $html .= '<br><b>Valor Total:</b> '.Framework\App\Sistema_Funcoes::Tranf_Float_Real($valortotal).'<br>';
        
        // Json
        $conteudo = array(
            'location'  =>  '#carrinho_valortemporario'.$time,
            'js'        =>  '',
            'html'      =>  $html
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        $this->_Visual->Json_Info_Update('Historico', false);  
        return true;
    }
    /**
     * 
     * @param type $form_id
     * @param type $valor
     */
    public function Carrinho_Atualizar_Valor_Dinamico_Janela($form_id,$recalcular=false){
        $time = round(TEMPO_COMECO);
        if($recalcular===false){
            $valor ='R$ 0,00';
        }else{
            $valor =__('Calculando');
            $this->_Visual->Javascript_Executar('params'.$time.'=$(\'#'.$form_id.'\').serialize();'
                            . 'Sierra.Modelo_Ajax_Chamar(\'comercio_venda/Carrinho/Carrinho_Atualizar_Valor_Dinamico/'.$time.'\',params'.$time.',\'POST\',true,false,false);');
        }
        // Janela De Valor Temporario
        $this->_Visual->Javascript_Executar('function Carrinho_Valor_Dinamico_Rodar() {var params'.$time.' = $(\'#'.$form_id.'\').serialize();'
            . 'var intervalo'.$time.' = window.setInterval(function () {console.log(\'SierraTecnologia\',params'.$time.');'
                . 'if($(\'#'.$form_id.'\').length){'
                    . 'if(params'.$time.'!==$(\'#'.$form_id.'\').serialize()){'
                        . 'params'.$time.'=$(\'#'.$form_id.'\').serialize();'
                        . 'Sierra.Modelo_Ajax_Chamar(\'comercio_venda/Carrinho/Carrinho_Atualizar_Valor_Dinamico/'.$time.'\',params'.$time.',\'POST\',true,false,false);'
                    . '}'
                . '}else{'
                    . 'clearInterval(intervalo'.$time.');'
                . '}'
            . '}, 1000);} Carrinho_Valor_Dinamico_Rodar();');
        $this->_Visual->Blocar(/*'<script LANGUAGE="JavaScript" TYPE="text/javascript">'
            . 
            . '</script>'
            . */'<span id="carrinho_valortemporario'.$time.'"><b>Valor Total:</b> '.$valor.'</span>'
            . '<br>');
        $this->_Visual->Bloco_Menor_CriaJanela(__('Informações Temporárias'));
    }
    /**
     * 
     * @param type $id
     * @throws Exception
     */
    public function PagoCarrinhos($id=false){
        
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $id = (int) $id;
        $resultado = $this->_Modelo->db->Sql_Select('Comercio_Venda_Carrinho', Array('id'=>$id),1);
        
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        
        if($resultado->pago=='1'){
            $resultado->pago='0'; // De Pago para NãoPago
            // Joga pra Contas nao Pagas
            Financeiro_PagamentoControle::Financeiro_Pagamento(
                'comercio_venda_Carrinho',
                $id,
                '1'
            );
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Sucesso'),
                "mgs_secundaria"    => __('Desfeito Pagamento com Sucesso.')
            );
        }else{
            $resultado->pago='1';// De Não Pago para Pago
            // Joga pra Contas Pagas
            Financeiro_PagamentoControle::Financeiro_Pagamento(
                'comercio_venda_Carrinho',
                $id,
                '1'
            );
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Sucesso'),
                "mgs_secundaria"    => __('Pago com Sucesso.')
            );
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $conteudo = array(
                'location' => '.pago'.$resultado->id,
                'js' => '',
                'html' =>  self::label($resultado)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $objeto
     * @param type $link
     * @return string
     */
    public static function label($objeto,$link=true){
        $pago = $objeto->pago;
        $id = $objeto->id;
        if($pago=='0'){
            $tipo = 'important';
            $nometipo = __('Não Pago');
        }
        else{
            $tipo = 'success';
            $nometipo = __('Pago');
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true && \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('comercio_venda/Carrinho/PagoCarrinhos')!==false){
            $html = '<a href="'.URL_PATH.'comercio_venda/Carrinho/PagoCarrinhos/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Status do Pagamento?">'.$html.'</a>';
        }
        return $html;
    }
    
    
    
    
    
    
    
    
    
    static function Endereco_Mesa($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = __('Mesas');
        $link = 'comercio_venda/Carrinho/Mesas';
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
    public function Mesas($export=false){
        self::Endereco_Mesa(false);
        $i = 0;
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Mesa',
                'comercio_venda/Carrinho/Mesas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio_venda/Carrinho/Mesas',
            )
        )));
        // CONEXAO
        $mesas = $this->_Modelo->db->Sql_Select('Comercio_Venda_Mesa');
        if($mesas!==false && !empty($mesas)){
            if(is_object($mesas)) $mesas = Array(0=>$mesas);
            reset($mesas);
            foreach ($mesas as $indice=>&$valor) {
                $tabela['#Id'][$i]       = '#'.$valor->id;
                $tabela['Nome'][$i]      = $valor->nome;
                $tabela['Lugares'][$i]   = $valor->lugares;
                $tabela['Status'][$i]    = ($valor->status==1)?'Funcionando':'Parada';
                $tabela['Ocupado'][$i]   = ($valor->ocupado==1)?'Ocupado':'Livre';
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Mesa'        ,'comercio_venda/Carrinho/Mesas_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Mesa'       ,'comercio_venda/Carrinho/Mesas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Mesa ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Comercio Vendas - Mesas');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Mesa</font></b></center>');
        }
        $titulo = __('Listagem de Mesas').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Mesas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Mesas_Add(){
        self::Endereco_Mesa(true);
        // Carrega Config
        $titulo1    = __('Adicionar Mesa');
        $titulo2    = __('Salvar Mesa');
        $formid     = 'form_Sistema_Admin_Mesas';
        $formbt     = __('Salvar');
        $formlink   = 'comercio_venda/Carrinho/Mesas_Add2/';
        $campos = Comercio_Venda_Mesa_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Mesas_Add2(){
        $titulo     = __('Mesa Adicionada com Sucesso');
        $dao        = 'Comercio_Venda_Mesa';
        $funcao     = '$this->Mesas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Mesa cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Mesas_Edit($id){
        self::Endereco_Mesa(true);
        // Carrega Config
        $titulo1    = 'Editar Mesa (#'.$id.')';
        $titulo2    = __('Alteração de Mesa');
        $formid     = 'form_Sistema_AdminC_MesaEdit';
        $formbt     = __('Alterar Mesa');
        $formlink   = 'comercio_venda/Carrinho/Mesas_Edit2/'.$id;
        $editar     = Array('Comercio_Venda_Mesa',$id);
        $campos = Comercio_Venda_Mesa_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Mesas_Edit2($id){
        $titulo     = __('Mesa Editada com Sucesso');
        $dao        = Array('Comercio_Venda_Mesa',$id);
        $funcao     = '$this->Mesas();';
        $sucesso1   = __('Mesa Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Mesas_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $carrinho = $this->_Modelo->db->Sql_Select('Comercio_Venda_Mesa', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($carrinho);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Mesa Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Mesas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Mesa deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>