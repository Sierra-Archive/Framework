<?php
class Financeiro_FinancaControle extends Financeiro_Controle
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
    * @uses Financeiro_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Financeiro/Financa/Financas');
        return false;
    }
    static function Endereco_Financa($true=true){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(__('Finanças'),'Financeiro/Financa/Financas');
        }else{
            $_Controle->Tema_Endereco(__('Finanças'));
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Financas(){
        self::Endereco_Financa(false);
        $i = 0;
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Finança',
                'Financeiro/Financa/Financas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'     => 'Financeiro/Financa/Financas',
            )
        )));
        // CONEXAO
        $setores = $this->_Modelo->db->Sql_Select('Financeiro_Financa');
        if($setores!==false && !empty($setores)){
            if(is_object($setores)) $setores = Array(0=>$setores);
            reset($setores);
            foreach ($setores as $indice=>&$valor) {
                $tabela['Id'][$i]               = $valor->id;
                $tabela['Tipo de Conta'][$i]        = $valor->categoria2;
                $tabela['Valor'][$i]            = $valor->valor;
                $tabela['Data Pago'][$i]        = $valor->data;
                /*$tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Finança'        ,'Financeiro/Financa/Financas_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Finança'       ,'Financeiro/Financa/Financas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Finança ?'));*/
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela,'', true, true, Array(Array(0,'asc')));
            unset($tabela);
        }else{     
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Finança</font></b></center>');
        }
        $titulo = __('Listagem de Finanças').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Finanças'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Financas_Add(){
        self::Endereco_Financa();
        // Carrega Config
        $titulo1    = __('Adicionar Finança');
        $titulo2    = __('Salvar Finança');
        $formid     = 'form_Financeiro_Financas';
        $formbt     = __('Salvar');
        $formlink   = 'Financeiro/Financa/Financas_Add2/';
        $campos = Financeiro_Financa_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Financas_Add2(){
        $titulo     = __('Finança Adicionada com Sucesso');
        $dao        = 'Financeiro_Financa';
        $funcao     = '$this->Main();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Finança cadastrada com sucesso.');
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        // Cadastra no Financeiro
        if($sucesso){
            $motivo = __('Financeiro_Financa');
            $identificador  = $this->_Modelo->db->Sql_Select('Financeiro_Financa', Array(),1,'id DESC');
            $parcela_data   = $identificador->data;
            $parcela_valor = $identificador->valor;
            $parcela_num = '0';
            $identificador  = $identificador->id;
            
            Financeiro_Controle::FinanceiroInt(
                $motivo,
                $identificador,
                'Servidor',                   // Entrada_Motivo
                SRV_NAME_SQL,                 // Entrada_MotivoID
                'Categoria',                  // Saida_Motivo
                $identificador->categoria,    // Saida_MotivoID
                $parcela_valor,$parcela_data,$parcela_num,$identificador->categoria
            );
        }
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Financas_Edit($id){
        self::Endereco_Financa();
        // Carrega Config
        $titulo1    = 'Editar Finança (#'.$id.')';
        $titulo2    = __('Alteração de Finança');
        $formid     = 'form_Sistema_FinancaC_FinancaEdit';
        $formbt     = __('Alterar Finança');
        $formlink   = 'Financeiro/Financa/Financas_Edit2/'.$id;
        $editar     = Array('Financeiro_Financa',$id);
        $campos = Financeiro_Financa_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Financas_Edit2($id){
        $titulo     = __('Finança Editada com Sucesso');
        $dao        = Array('Financeiro_Financa',$id);
        $funcao     = '$this->Main();';
        $sucesso1   = __('Finança Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Financas_Del($id){
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Financeiro_Financa', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Finança deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Main();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Finança deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
