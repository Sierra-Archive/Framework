<?php
class Comercio_Certificado_PropostaControle extends comercio_certificado_Controle
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
    * @version 3.1.1
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
    * @version 3.1.1
    */
    public function Main(){
        ///$this->Propostas();
        $this->_Visual->Blocar(__('Localizar'),                 usuario_Controle::Static_usuariolistar(Array(CFG_TEC_CAT_ID_CLIENTES,'Clientes'),false,false));
        $this->_Visual->Blocar(__('Cliente'),                   comercio_certificado_Controle::Usuarios_Add('cliente'));
        $this->_Visual->Blocar(__('Produto'),                   $this->_Visual->ErroShow());
        $this->_Visual->Blocar(__('Auditoria Periódica'),       $this->_Visual->ErroShow());
        $this->_Visual->Blocar(__('Observações'),               $this->_Visual->ErroShow());
        $this->_Visual->Bloco_Unico_CriaJanela(__('Clientes'));
        
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas'));
    }
    public function Propostas_DashBoard_Show($cliente=0){
        // Produtos
        \Framework\App\Visual::Layoult_Abas_Carregar('3',$this->Propostas_DashBoard($cliente));
        // Joga pro Json se nao for o caso de popup
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta Adicionada'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    public function Propostas_DashBoard($cliente=0){
        return $this->_Visual->Bloco_Customizavel(Array(
            Array(
                'span'      =>      4,
                'conteudo'  =>  Array(Array(
                    'div_ext'   =>      false,
                    'title_id'  =>      false,
                    'title'     =>      'Propostas / Contratos',
                    'html'      =>      $this->Propostas($cliente),
                ),),
            ),
            Array(
                'span'      =>      8,
                'conteudo'  =>  Array(Array(
                    'div_ext'   =>      false,
                    'title_id'  =>      'propostasmodificar_titulo',
                    'title'     =>      'Produtos (Adicionar)',
                    'html'      =>      '<span id="propostasmodificar">'.$this->Propostas_Add($cliente,true).'</span>',
                ),),
            )
        ),false);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Propostas($cliente){
        $i = 0;
        $html = '<span id="propostasaddmostrar" style="display: none;"><a title="Adicionar Proposta" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'comercio_certificado/Proposta/Propostas_Add/'.$cliente.'/">Adicionar nova Proposta</a><div class="space15"></div></span>';
        $proposta = $this->_Modelo->db->Sql_Select('Comercio_Certificado_Proposta',Array(
            'idcliente'     =>      $cliente
        ));
        if($proposta!==false && !empty($proposta)){
            if(is_object($proposta)){
                $proposta = Array(0=>$proposta);
            }
            reset($proposta);
            $tabela = new \Framework\Classes\Tabela();
            $tabela->addcabecario(Array('#Cod','Funções'));
            foreach ($proposta as &$valor) {
                //$tabela['#Cod'][$i]      = '#'.$valor->num_proposta;
                //$tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Proposta'        ,'comercio_certificado/Proposta/Propostas_Edit/'.$valor->id.'/'.$cliente.'/'    ,'')).
                //                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Proposta'       ,'comercio_certificado/Proposta/Propostas_Del/'.$valor->id.'/'.$cliente.'/'     ,'Deseja realmente deletar essa Proposta ?'));
                // Classifica de Acordo se foi aceito ou nao
                $class = 'left';
                if($valor->data_comissao!=='0000-00-00 00:00:00' && $valor->data_comissao!=='0000-00-00' && $valor->data_comissao!=='//'){
                    $class = 'right';
                }
                
                $funcoes =  '<span id="status'.$valor->id.'">'.self::Propostas_Label($valor).'</span>'.
                            $this->_Visual->Tema_Elementos_Btn('Visualizar'     ,Array('Visualizar Proposta'        ,'comercio_certificado/Proposta/Show/'.$valor->id    ,''));
            
                
                $corpo =  ($class=='right')?Array(
                    Array('nome'=>'#'.$valor->num_proposta,'class'=>$class),
                    Array('nome'=>  $funcoes
                                    ,'class'=>''),
                ):Array(
                    Array('nome'=>'#'.$valor->num_proposta,'class'=>$class),
                    Array('nome'=>  $funcoes.
                                    $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Proposta'        ,'comercio_certificado/Proposta/Propostas_Edit/'.$valor->id.'/'.$cliente.'/'    ,''))/*.
                    $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Proposta'       ,'comercio_certificado/Proposta/Propostas_Del/'.$valor->id.'/'.$cliente.'/'     ,'Deseja realmente deletar essa Proposta ?'))*/,'class'=>''),
                );
                $tabela->addcorpo($corpo);
                ++$i;
            }
            //$html .= $this->_Visual->Show_Tabela_DataTable($tabela,'',false);
            $html .= $tabela->retornatabela();
            unset($tabela);
        }else{
            $html .= '<center><b><font color="#FF0000" size="5">Nenhuma Proposta</font></b></center>';
        }
        return $html;
    }
    public function Propostas_Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $id, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Comercio_Certificado_Proposta', Array('id'=>$id),1);
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Essa registro não existe:'. $id, 404);
        }
        if($resultado->status===1 || $resultado->status==='1'){
            $resultado->status='2';
        }else if($resultado->status===2 || $resultado->status==='2'){
            $resultado->status='0';
        }else{
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  self::Propostas_Label($resultado)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public static function Propostas_Label($objeto,$link=true){
        $status     = $objeto->status;
        $id         = $objeto->id;
        if($status==='0' || $status===0){
            $tipo = 'warning';
            $nometipo = __('Pendente');
        }
        else if($status==='1' || $status===1){
            $tipo = 'success';
            $nometipo = __('Aprovada');
        }
        else{
            $tipo = 'important';
            $nometipo = __('Reprovada');
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true){
            $html = '<a href="'.URL_PATH.'comercio_certificado/Proposta/Propostas_Status/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Status?">'.$html.'</a>';
        }
        return $html;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Propostas_Add($cliente=0,$direto=false){
        // Carrega campos e retira os que nao precisam
        $campos = Comercio_Certificado_Proposta_DAO::Get_Colunas();
        if($cliente!=0){
            self::DAO_Campos_Retira($campos, 'idcliente');
        }
        $proposta_num = $this->_Modelo->db->Sql_Select('Comercio_Certificado_Proposta',false,1,'ID DESC');
        if($proposta_num===false){
            $proposta_num = '1/'.date('y').' - 1';
        }else{
            $proposta_num = $proposta_num->id.'/'.date('y').' - 1';
        }
        
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Sistema_Admin_Propostas','comercio_certificado/Proposta/Propostas_Add2/'.$cliente.'/','formajax');
        self::mysql_AtualizaValor($campos, 'num_proposta', $proposta_num);
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Cadastrar');
        if($direto===true){
            return $formulario;
        }else{
            // Json
            $conteudo = array(
                'location'  =>  '#propostasmodificar_titulo',
                'js'        =>  '$("#propostas_auditorias").hide();',
                'html'      =>  'Produto (Adicionar)'
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $conteudo = array(
                'location'  =>  '#propostasmodificar',
                'js'        =>  '$("propostasaddmostrar").hide();',
                'html'      =>  $formulario
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Cadastrar Proposta'));
            $this->_Visual->Json_Info_Update('Historico', false);
        }
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Propostas_Edit($id,$cliente){
        $id = (int) $id;
        // Carrega campos e retira os que nao precisam
        $campos = Comercio_Certificado_Proposta_DAO::Get_Colunas();
        if($cliente!=0) self::DAO_Campos_Retira($campos, 'idcliente');
        // recupera proposta
        $proposta = $this->_Modelo->db->Sql_Select('Comercio_Certificado_Proposta', Array('id'=>$id));
        self::mysql_AtualizaValores($campos, $proposta);

        // edicao de propostas
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_PropostaEdit','comercio_certificado/Proposta/Propostas_Edit2/'.$id.'/'.$cliente.'/','formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Alterar Proposta');
        // Json
        $conteudo = array(
            'location'  =>  '#propostasmodificar_titulo',
            'js'        =>  '$("#auditorias_periodicas_editar").show();',
            'html'      =>  'Produto (Editar: #'.$id.')'
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        $conteudo = array(
            'location'  =>  '#propostasmodificar',
            'js'        =>  '$("#propostasaddmostrar").show();',
            'html'      =>  $formulario
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Editar Proposta'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public static function RecarregaLocalizar(){
        $registro = \Framework\App\Registro::getInstacia();
        $Visual = $registro->_Visual;
        // Localizar
        $abas_id    = &$Visual->config_template['plugins']['abas_id'];
        $conteudo = array(
            'location'  =>  '#'.$abas_id.'1',
            'js'        =>  '',
            'html'      =>  usuario_Controle::Static_usuariolistar(Array(CFG_TEC_CAT_ID_CLIENTES,'Clientes'),false,false)
        );
        $Visual->Json_IncluiTipo('Conteudo',$conteudo);
    }
            
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Propostas_Add2($cliente=0){
        
        $data_aceita = $_POST['data_comissao'];
        // Cria nova Proposta
        $proposta = new \Comercio_Certificado_Proposta_DAO();
        self::mysql_AtualizaValores($proposta);
        $proposta->idcliente = $cliente;
        // Atualiza Proposta de Numero denovo só por segurança
        $proposta_num = $this->_Modelo->db->Sql_Select('Comercio_Certificado_Proposta',false,1,'ID DESC');
        if($proposta_num===false){
            $proposta_num = '1/'.date('y');
        }else{
            $proposta_num = $proposta_num->id.'/'.date('y');
        }
        if($data_aceita==='0000-00-00 00:00:00' || $data_aceita==='0000-00-00' || $data_aceita===''){
            $proposta_num = $proposta_num.' - 1';
        }
        self::mysql_AtualizaValor($proposta, 'num_proposta', $proposta_num);
        
        $sucesso =  $this->_Modelo->db->Sql_Inserir($proposta);
        
        
        // Mostra Mensagem de Sucesso
        if($sucesso===true){
            // Periodicas
            $identificador  = $this->_Modelo->db->Sql_Select('Comercio_Certificado_Proposta', Array(),1,'id DESC');
            $this->Periodicas_Add($proposta->idcliente,$proposta->idproduto,$identificador->id, \anti_injection($data_aceita));
            // Recarrega Main
            $this->Propostas_DashBoard_Show($cliente);  
            Comercio_Certificado_PropostaControle::RecarregaLocalizar();
            // Mensagem
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Inserção bem sucedida'),
                "mgs_secundaria" => __('Proposta cadastrada com sucesso.')
            ); 
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        // Json
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta Adicionada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Propostas_Edit2($id,$cliente=0){
        
        $id = (int) $id;
        $data_aceita = $_POST['data_comissao'];
        $novoregistro = 0;
        // Puxa o proposta
        $proposta = $this->_Modelo->db->Sql_Select('Comercio_Certificado_Proposta', Array('id'=>$id));
        // Atualiza Proposta de Numero denovo só por segurança
        $proposta_num = explode(' - ',$proposta->num_proposta);
        if($data_aceita==='0000-00-00 00:00:00' || $data_aceita==='0000-00-00' || $data_aceita===''){
            $proposta_num[1] = $proposta_num[1]+1;
            $proposta_num = $proposta_num[0].' - '.$proposta_num[1];
            $novoregistro = 1;
            $fechar = false;
        }else{
            $proposta_num = $proposta_num[0];
            $fechar = true;
        }
        //altera seus valores
        self::mysql_AtualizaValores($proposta);
        // Reatualiza os dados de segurança
        self::mysql_AtualizaValor($proposta, 'num_proposta', $proposta_num);
        // Grava no banco de dados
        if($novoregistro==0){
            $sucesso =  $this->_Modelo->db->Sql_Update($proposta);
        }else{
            $sucesso =  $this->_Modelo->db->Sql_Inserir($proposta);
        }
        // Periodicas
        $this->Periodicas_Add($proposta->idcliente,$proposta->idproduto,$proposta->id, \anti_injection($data_aceita));
        // Recarrega Main
        $this->Propostas_DashBoard_Show($cliente); 
        Comercio_Certificado_PropostaControle::RecarregaLocalizar();
        // Mensagem
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Proposta Alterada com Sucesso'),
                "mgs_secundaria" => ''.$_POST["nome"].' teve a alteração bem sucedida'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);  
        //Json
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta Editada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);    
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Propostas_Del($id,$cliente){
        
        
    	$id = (int) $id;
        // Puxa proposta e deleta
        $proposta = $this->_Modelo->db->Sql_Select('Comercio_Certificado_Proposta', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($proposta);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Proposta Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Propostas_DashBoard_Show($cliente);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Show($propostaid){
        $propostaid = (int) $propostaid;
        // Verifica Permissao e Puxa Proposta
        $proposta = $this->_Modelo->db->Sql_Select('Comercio_Certificado_Proposta',Array('id'=>$propostaid),1); // Banco DAO, Condicao e LIMITE
        // Resgata DAdos e Manda pra View
        if($proposta===false)            throw new \Exception(404,'Proposta não Existe');
        $this->_Visual->Show_Perfil($proposta);
    }
    public function Usuarios_Del($id,$tipo=false){
        
    	$id = (int) $id;
        // Regula Tipo
        if($tipo==='falso'){
            $tipo  = false;
        }
        // Puxa usuario e deleta
        $usuario    = $this->_Modelo->db->Sql_Select(  'Usuario',            Array('id'=>$id));
        if($tipo===false){
            if($usuario->grupo==CFG_TEC_IDCLIENTE){
                $tipo = 'cliente';
                $tipo2 = __('Cliente');
            }else if($usuario->grupo==CFG_TEC_IDFUNCIONARIO){
                $tipo = 'funcionario';
                $tipo2 = __('Funcionário');
            }
        }
        
        $sucesso    =  $this->_Modelo->db->Sql_Delete($usuario);
        $mensagens  = $this->_Modelo->db->Sql_Select('Usuario_Mensagem',    Array('cliente'=>$id));
        $this->_Modelo->db->Sql_Delete($mensagens);
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => $tipo2.' Deletado',
                "mgs_secundaria" => $tipo2.' Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        Comercio_Certificado_PropostaControle::RecarregaLocalizar();
    }
    protected function Periodicas_Add($cliente,$produto,$proposta,$data){
        $produto    = (int) $produto;
        $cliente    = (int) $cliente;
        $proposta   = (int) $proposta;
        $periodicas    = $this->_Modelo->db->Sql_Select(  'Comercio_Certificado_Auditoria',  Array('idproduto'=>$produto),0,'ordem ASC');
        if(is_object($periodicas)){
            $periodicas = Array($periodicas);
        }
        $data = explode('/',$data);
        if(is_array($periodicas) && !empty($periodicas)){
            foreach($periodicas as &$valor){
                
                $objeto = new \Comercio_Certificado_AuditoriaPeriodica_DAO();
                $objeto->idcliente  = $cliente;
                $objeto->idproduto  = $produto;
                $objeto->idproposta = $proposta;
                if(isset($data[2])){
                    $data[1] = $data[1]+$valor->meses;
                    if($data[1]>12){
                        $data[1] = $data[1]-12;
                        $data[2] = $data[2]+1;
                    }
                    $objeto->data = $data[0].'/'.$data[1].'/'.$data[2];
                }else{
                    $objeto->data = '00/00/0000';
                }
                $this->_Modelo->db->Sql_Inserir($objeto);
            }
        }
        \Framework\App\Visual::Layoult_Abas_Carregar('4',$this->Periodicas($cliente)   ,false);
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    static function Periodicas_Tabela(&$periodicas){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($periodicas)) $periodicas = Array(0=>$periodicas);
        reset($periodicas);
        foreach ($periodicas as &$valor) {
            $tabela['Proposta'][$i]         = $valor->idproposta2;
            $tabela['Auditor'][$i]          = $valor->autor;
            $tabela['Data Auditoria'][$i]   = $valor->data;
            $tabela['Data Realização'][$i]  = $valor->data_realizacao;
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Periodica'        ,'comercio_certificado/Proposta/Periodicas_Edit/'.$valor->id.'/'    ,''));
            ++$i;
        }
        return Array($tabela,$i);
    }
    public function Periodicas($cliente){
        return $this->_Visual->Bloco_Customizavel(Array(
            Array(
                'span'      =>      6,
                'conteudo'  =>  Array(Array(
                    'div_ext'   =>      ' style="display:none;"  id="auditorias_periodicas_editar"',
                    'title_id'  =>      false,
                    'title'     =>      'Editar Periódica',
                    'html'      =>      '<span id="Periodicas_editar">Selecione uma para Editar</span>',
                ),),
            ),Array(
                'span'      =>      6,
                'conteudo'  =>  Array(Array(
                    'div_ext'   =>      false,
                    'title_id'  =>      'produtosmodificar_titulo',
                    'title'     =>      'Listagem de Periódicas',
                    'html'      =>      '<span id="Periodicas_listar">'.$this->Periodicas_Ver($cliente).'</span>',
                )),
            )
        ),false);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Periodicas_Ver($cliente){
        $cliente = (int) $cliente;
        $i = 0;
        $periodicas = $this->_Modelo->db->Sql_Select('Comercio_Certificado_AuditoriaPeriodica',Array('idcliente'=>$cliente));
        if($periodicas!==false && !empty($periodicas)){
            list($tabela,$i) = self::Periodicas_Tabela($periodicas);
            $html = $this->_Visual->Show_Tabela_DataTable($tabela,'',false);
            unset($tabela);
        }else{
            $html = '<center><b><font color="#FF0000" size="5">Nenhuma Periódica Marcada</font></b></center>';            
        }
        return $html;
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Periodicas_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar Periodica (#'.$id.')';
        $titulo2    = __('Alteração de Periodica');
        $formid     = 'form_Sistema_AdminC_PeriodicaEdit';
        $formbt     = __('Alterar Periodica');
        $formlink   = 'comercio_certificado/Proposta/Periodicas_Edit2/'.$id;
        $editar     = Array('Comercio_Certificado_AuditoriaPeriodica',$id);
        $campos = Comercio_Certificado_AuditoriaPeriodica_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'idcliente');
        self::DAO_Campos_Retira($campos, 'idproduto');
        $html = \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar, 'html');
        
        // Conteudo
        /*// Json
        $conteudo = array(
            'location'  =>  '#Periodicas_listar',
            'js'        =>  '$("#Periodicas_listar").hide();',
            'html'      =>  'Listar Produto'
        );*/
        $conteudo = array(
            'location'  =>  '#Periodicas_editar',
            'js'        =>  '$("#auditorias_periodicas_editar").show();',
            'html'      =>  $html
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Periodicas_Edit2($id){
        $id = (int) $id;
        $titulo     = __('Periodica Editada com Sucesso');
        $dao        = Array('Comercio_Certificado_AuditoriaPeriodica',$id);
        $funcao     = false;
        $sucesso1   = __('Periodica Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["autor"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar); 
        if($sucesso){
            
            $periodicas    = $this->_Modelo->db->Sql_Select('Comercio_Certificado_AuditoriaPeriodica',  Array('id'=>$id),1);
            $conteudo = array(
                'location'  =>  '#Periodicas_listar',
                'js'        =>  '$("#auditorias_periodicas_editar").hide();',
                'html'      =>  $this->Periodicas_Ver($periodicas->idcliente)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo); 
        }
    }
}
?>