<?php
class predial_SalaoControle extends predial_Controle
{
    public function __construct(){
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses predial_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
    }
    static function Endereco_Salao($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Saloes';
        $link = 'predial/Salao/Saloes';
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Saloes_Tabela(&$saloes){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($saloes)) $saloes = Array(0=>$saloes);
        reset($saloes);
        foreach ($saloes as &$valor) {
            $tabela['Tipo'][$i]             = $valor->categoria2;
            $tabela['Nome'][$i]             = $valor->nome;
            $tabela['Preço'][$i]            = $valor->preco;
            $tabela['Observação'][$i]       = $valor->obs;
            $tabela['Data Registrado'][$i]  = $valor->log_date_add;
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Local de Reserva'        ,'predial/Salao/Saloes_Edit/'.$valor->id.'/'    ,'')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Local de Reserva'       ,'predial/Salao/Saloes_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Local de Reserva ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Saloes(){
        self::Endereco_Salao(false);
        $i = 0;
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Local de Reserva',
                'predial/Salao/Saloes_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'predial/Salao/Saloes',
            )
        )));
        // Busca
        $saloes = $this->_Modelo->db->Sql_Select('Predial_Salao');
        if($saloes!==false && !empty($saloes)){
            list($tabela,$i) = self::Saloes_Tabela($saloes);
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Local de Reserva</font></b></center>');
        }
        $titulo = 'Listagem de Locais de Reserva ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Locais de Reserva'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Saloes_Add(){
        self::Endereco_Salao();
        // Carrega Config
        $titulo1    = 'Adicionar Local de Reserva';
        $titulo2    = 'Salvar Local de Reserva';
        $formid     = 'form_Sistema_Admin_Saloes';
        $formbt     = 'Salvar';
        $formlink   = 'predial/Salao/Saloes_Add2/';
        $campos = Predial_Salao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Saloes_Add2(){
        $titulo     = 'Local de Reserva Adicionado com Sucesso';
        $dao        = 'Predial_Salao';
        $funcao     = '$this->Saloes();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Local de Reserva cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Saloes_Edit($id){
        self::Endereco_Salao();
        // Carrega Config
        $titulo1    = 'Editar Local de Reserva (#'.$id.')';
        $titulo2    = 'Alteração de Local de Reserva';
        $formid     = 'form_Sistema_AdminC_SalaoEdit';
        $formbt     = 'Alterar Local de Reserva';
        $formlink   = 'predial/Salao/Saloes_Edit2/'.$id;
        $editar     = Array('Predial_Salao',$id);
        $campos = Predial_Salao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Saloes_Edit2($id){
        $titulo     = 'Local de Reserva Editado com Sucesso';
        $dao        = Array('Predial_Salao',$id);
        $funcao     = '$this->Saloes();';
        $sucesso1   = 'Local de Reserva Alterada com Sucesso.';
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
    public function Saloes_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa salao e deleta
        $salao = $this->_Modelo->db->Sql_Select('Predial_Salao', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($salao);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Local de Reserva deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Saloes();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Local de Reserva deletado com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function Reserva(){
        //mostra reservas
        /*$reservas = Array();
        $i = $this->_Modelo->retorna_reservas($reservas,true);
        foreach($reservas as $indice=>&$valor){
            $this->_Visual->Blocar($this->_Visual->Show_Reservas($valor));
            $this->_Visual->Bloco_Unico_CriaTitulo($indice.' ('.$i[$indice].')',2);
            $this->_Visual->Bloco_Unico_CriaConteudo(1);
        }*/
                
        // carrega calendario de datas disponiveis
        $datas = Array();
        $i = $this->_Modelo->retorna_Agendadatas($datas);
        $this->_Visual->Js_Calendar_Gerar('calendariodedatasdisponiveis',$datas);
        $this->_Visual->Bloco_Maior_CriaJanela(__('Datas Disponiveis'));
        // ORGANIZA E MANDA CONTEUDO
        
        $this->_Visual->Json_Info_Update('Titulo', __('Reservas'));        
    }
    public function Popup_Agendar_reserva($idreserva,$datainicial,$datafinal,$nomereserva){
        if($this->get_logado()){
            if($this->_Acl->logado_usuario->foto_cnh==''){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('É necessário fazer upload da CNH')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else if($this->_Acl->logado_usuario->foto_res==''){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Falta upload do comprovante de residente')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else if($controle->usuario->foto_cnh_apv==0){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Aguarde a aprovação de sua CNH')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else if($controle->usuario->foto_res_apv==0){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Aguarde a aprovação de sua residência')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else if($controle->usuario->foto_cnh_apv==1){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('CNH Negada'),
                    "mgs_secundaria" => __('Suba uma CNH válida')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else if($controle->usuario->foto_res_apv==1){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Residência Negada'),
                    "mgs_secundaria" => __('Suba uma residência válida')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else{
                // variaveis
                $datainicial = data_eua_brasil(\anti_injection($datainicial));
                $datafinal = data_eua_brasil(\anti_injection($datafinal));
                $nomereserva = \anti_injection($nomereserva);
                $idreserva = (int) $idreserva;

                // faz busca por reserva
                $reserva = $this->_Modelo->retorna_reserva($idreserva);

                // Chama funcao js
                $this->_Visual->Javascript_Executar('Sierra.Control_Layoult_Calendario_Intervalo(\'data_inicial\',\'data_final\',\''.$datainicial.'\',\''.$datafinal.'\');');

                // formulario
                $form = new \Framework\Classes\Form('adminformreservasagenda','usuario_reserva/Listar/agendamento_inserir/','formajax');
                usuario_reserva_ListarControle::agendamento_form($this, $this->_Visual, $form, $idreserva,$nomereserva,$datainicial,$datafinal,$reserva['franquia'],0);
                $formulario = $form->retorna_form();
                $conteudo = array(
                    'id' => 'popup',
                    'title' => 'Agendar Reserva',
                    'botoes' => array(
                        array(
                            'text' => 'Agendar',
                            'clique' => '$( "#data_final" ).datepicker( "option", "dateFormat", "dd/mm/yy" );'.
                                        '$( "#data_inicial" ).datepicker( "option", "dateFormat", "dd/mm/yy" );'.
                                        '$(\'#adminformreservasagenda\').submit();'
                        ),
                        array(
                            'text' => 'Cancelar',
                            'clique' => '$( this ).dialog( "close" );'
                        )
                    ),
                    'html' => $formulario
                );
                $this->_Visual->Json_IncluiTipo('Popup',$conteudo);
                //$this->_Visual->Json_IncluiTipo('JavascriptInterno',$this->_Visual->Javascript_Executar());
                //$this->_Visual->Javascript_Executar(false);
            }
        }else{
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('É necessário se logar para continuar')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }
    }
    static function agendamento_form(&$controle, &$Visual, &$form, &$idreserva,$nomereserva,$datainicial = '',$datafinal = '',$franquia=0, $valor=0){
        global $language;
       
       // select de pessoas
        $form->Select_Novo('Reserva','selectreservas','selectreservas');
        $form->Select_Opcao($nomereserva,$idreserva,1);
        $form->Select_Fim();
        $form->Input_Novo('Data Inicial','data_inicial',$datainicial,'text', 10, 'obrigatorio','',true); 
        $form->Input_Novo('Data Final','data_final',$datafinal,'text', 10, 'obrigatorio','',true); 
        $form->Input_Novo('Franquia','franquia','R$'.number_format($franquia, 2, ',', '.'),'text', 30, 'inactive','',true);  
        $form->Input_Novo('Valor','valor','R$'.number_format($valor, 2, ',', '.'),'text', 30, 'inactive','',true); 
    }
     /**
     * Inserir
     * 
     * @name agendamento_inserir
     * @access public
     * 
     * @global Array $language
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function agendamento_inserir(){
        global $language;
        $reservaid = (int) \anti_injection($_POST["selectreservas"]);
        $valor = \anti_injection($_POST["valor"]);
        $data_inicial = \anti_injection($_POST["data_inicial"]);
        $data_final = \anti_injection($_POST["data_final"]);
        
        // faz busca por reserva
        $reserva = $this->_Modelo->retorna_reserva($reservaid);

        // Captura Valor
        $diaspercorridos = Data_CalculaDiferenca($data_inicial,$data_final)*24;
        $valor = $this->recalcula_valor_aluguel($reserva['valor1'],$reserva['valor2'],$reserva['valor3'], $diaspercorridos);
        // Atualiza datas para formato americano
        $data_inicial = data_brasil_eua($data_inicial);
        $data_final   = data_brasil_eua($data_final);
        
        // inseri e mostra mensagem
        $sucesso =  $this->_Modelo->agendamento_inserir($reservaid,$data_inicial,$data_final,$valor);
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Inserção bem sucedida'),
                "mgs_secundaria" => __('Agendado com sucesso.')
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        
        // fecha popup e atualiza dados
        $this->_Visual->Javascript_Executar('$(\'#popup\').dialog( "close" );');
        $this->Reserva();  
    }
}
?>
