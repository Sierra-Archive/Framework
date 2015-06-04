<?php
class usuario_veiculo_ListarControle extends usuario_veiculo_Controle
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
    * @version 2.0
    */
    public function __construct(){
        // construct
        parent::__construct();
    }
    /**
    * Função Main, Principal
    * 
    * @name Main
    * @access public
    * 
    * @uses usuario_veiculo_ListarModelo::$retorna_veiculos
    * @uses \Framework\App\Visual::$Bloco_Maior_CriaTitulo
    * @uses \Framework\App\Visual::$Bloco_Maior_CriaConteudo
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        //mostra veiculos
        $veiculos = Array();
        $i = $this->_Modelo->retorna_veiculos($veiculos,true);
        foreach($veiculos as $indice=>&$valor){
            $this->_Visual->Blocar($this->_Visual->Show_Veiculos($valor));
            $this->_Visual->Bloco_Unico_CriaTitulo($indice.' ('.$i[$indice].')',2);
            $this->_Visual->Bloco_Unico_CriaConteudo(1);
        }
                
        /*// carrega calendario de datas disponiveis
        $datas = Array();
        $i = $this->_Modelo->retorna_Agendadatas($datas);
        $this->_Visual->Js_Calendar_Gerar('calendariodedatasdisponiveis',$datas);
        $this->_Visual->Bloco_Maior_CriaJanela(__('Datas Disponiveis'));
        // ORGANIZA E MANDA CONTEUDO*/
        
        $this->_Visual->Json_Info_Update('Titulo', __('Veiculos'));        
    }
    public function Popup_Agendar_veiculo($idveiculo,$datainicial,$datafinal,$nomeveiculo){
        if($this->_Acl->Usuario_GetLogado()){
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
            }else if($this->_Acl->logado_usuario->foto_cnh_apv==0){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Aguarde a aprovação de sua CNH')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else if($this->_Acl->logado_usuario->foto_res_apv==0){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Aguarde a aprovação de sua residência')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else if($this->_Acl->logado_usuario->foto_cnh_apv==1){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('CNH Negada'),
                    "mgs_secundaria" => __('Suba uma CNH válida')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else if($this->_Acl->logado_usuario->foto_res_apv==1){
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
                $nomeveiculo = \anti_injection($nomeveiculo);
                $idveiculo = (int) $idveiculo;

                // faz busca por veiculo
                $veiculo = $this->_Modelo->retorna_veiculo($idveiculo);

                // Chama funcao js
                $this->_Visual->Javascript_Executar('Sierra.Control_Layoult_Calendario_Intervalo(\'data_inicial\',\'data_final\',\''.$datainicial.'\',\''.$datafinal.'\',\'Sierra.Control_Agenda_Calpreco('.$veiculo['valor1'].','.$veiculo['valor2'].','.$veiculo['valor3'].',\');'.
                'var diaspercorridos = Sierra.Control_Data_ContaDias(\''.$datainicial.'\', \''.$datafinal.'\');'.
                'Sierra.Control_Agenda_Calpreco('.$veiculo['valor1'].','.$veiculo['valor2'].','.$veiculo['valor3'].', diaspercorridos);');

                // formulario
                $form = new \Framework\Classes\Form('adminformveiculosagenda','usuario_veiculo/Listar/agendamento_inserir/','formajax');
                usuario_veiculo_ListarControle::agendamento_form($this, $this->_Visual, $form, $idveiculo,$nomeveiculo,$datainicial,$datafinal,$veiculo['franquia'],0);
                $formulario = $form->retorna_form();
                $conteudo = array(
                    'id' => 'popup',
                    'title' => 'Agendar Veiculo',
                    'botoes' => array(
                        array(
                            'text' => 'Agendar',
                            'clique' => '$( "#data_final" ).datepicker( "option", "dateFormat", "dd/mm/yy" );'.
                                        '$( "#data_inicial" ).datepicker( "option", "dateFormat", "dd/mm/yy" );'.
                                        '$(\'#adminformveiculosagenda\').submit();'
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
    static function agendamento_form(&$controle, &$Visual, &$form, &$idveiculo,$nomeveiculo,$datainicial = '',$datafinal = '',$franquia=0, $valor=0){
        global $language;
       
       // select de pessoas
        $form->Select_Novo('Veiculo','selectveiculos','selectveiculos');
        $form->Select_Opcao($nomeveiculo,$idveiculo,1);
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
        $veiculoid = (int) \anti_injection($_POST["selectveiculos"]);
        $valor = \anti_injection($_POST["valor"]);
        $data_inicial = \anti_injection($_POST["data_inicial"]);
        $data_final = \anti_injection($_POST["data_final"]);
        
        // faz busca por veiculo
        $veiculo = $this->_Modelo->retorna_veiculo($veiculoid);

        // Captura Valor
        $diaspercorridos = Data_CalculaDiferenca($data_inicial,$data_final)*24;
        $valor = $this->recalcula_valor_aluguel($veiculo['valor1'],$veiculo['valor2'],$veiculo['valor3'], $diaspercorridos);
        // Atualiza datas para formato americano
        $data_inicial = data_brasil_eua($data_inicial);
        $data_final   = data_brasil_eua($data_final);
        
        // inseri e mostra mensagem
        $sucesso =  $this->_Modelo->agendamento_inserir($veiculoid,$data_inicial,$data_final,$valor);
        if($sucesso==1){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Inserção bem sucedida'),
                "mgs_secundaria" => __('Moto Agendada com sucesso.')
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        
        // fecha popup e atualiza dados
        $this->_Visual->Javascript_Executar('$(\'#popup\').dialog( "close" );');
        $this->Main();  
    }
    public function recalcula_valor_aluguel($valor1,$valor2,$valor3,$diasdecorridos){
        $valorfinal = 0;
        if($diasdecorridos<=3){
            $valorfinal = $valorfinal+($diasdecorridos*$valor1);
        }else if($diasdecorridos<10){
            $valorfinal = $valorfinal+($diasdecorridos*$valor2);
        }else{
            $valorfinal = $valorfinal+($diasdecorridos*$valor3);
        }
        return $valorfinal;
    }
}
?>
