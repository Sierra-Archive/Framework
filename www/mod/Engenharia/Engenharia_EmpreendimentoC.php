<?php
class Engenharia_EmpreendimentoControle extends Engenharia_Controle
{
    public function __construct(){
        parent::__construct();
    }
    static function Endereco_Empreendimento($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Empreendimentos','Engenharia/Empreendimento/Main');
        }else{
            $_Controle->Tema_Endereco('Empreendimentos');
        }
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses empreendimento_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Engenharia/Empreendimento/Empreendimentos');
        return false;
    }
    static function Empreendimentos_Tabela(&$empreendimentos){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($empreendimentos)) $empreendimentos = Array(0=>$empreendimentos);
        reset($empreendimentos);
        foreach ($empreendimentos as &$valor) {
            $tabela['Nome do Empreendimento'][$i]   =   $valor->nome;
            $tabela['Especificações'][$i]           =   $valor->obs;
            $tabela['Data Inicio'][$i]              =   $valor->data_inicio;
            $tabela['Data Fim'][$i]                 =   $valor->data_fim;
            $tabela['Data Entrega'][$i]             =   $valor->data_entrega;
            $tabela['Qnt de Unidades'][$i]          =   $valor->unidades;
            $tabela['Funções'][$i]                  =   $Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar Empreendimento'    ,'Engenharia/Unidade/Main/'.$valor->id.'/'    ,'')).
                                                        $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Empreendimento'        ,'Engenharia/Empreendimento/Empreendimentos_Edit/'.$valor->id.'/'    ,'')).
                                                        $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Empreendimento'       ,'Engenharia/Empreendimento/Empreendimentos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Empreendimento ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Empreendimentos($export=false){
        self::Endereco_Empreendimento(false);
        $i = 0;
        
        // Botao 1
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar novo Empreendimento',
                'Engenharia/Empreendimento/Empreendimentos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Engenharia/Empreendimento/Empreendimentos',
            )
        )));
        $empreendimentos = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento');
        if($empreendimentos!==false && !empty($empreendimentos)){
            list($tabela,$i) = self::Empreendimentos_Tabela($empreendimentos);
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Empreendimentos');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Empreendimento</font></b></center>');
        }
        $titulo = 'Listagem de Empreendimentos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Empreendimentos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Empreendimentos_Add(){
        self::Endereco_Empreendimento();
        // Carrega Config
        $titulo1    = 'Adicionar Empreendimento';
        $titulo2    = 'Salvar Empreendimento';
        $formid     = 'form_Sistema_Admin_Empreendimentos';
        $formbt     = 'Salvar';
        $formlink   = 'Engenharia/Empreendimento/Empreendimentos_Add2/';
        $campos = Engenharia_Empreendimento_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Empreendimentos_Add2(){
        $titulo     = 'Empreendimento Adicionado com Sucesso';
        $dao        = 'Engenharia_Empreendimento';
        $funcao     = '$this->Main();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Empreendimento cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Empreendimentos_Edit($id){
        self::Endereco_Empreendimento();
        // Carrega Config
        $titulo1    = 'Editar Empreendimento (#'.$id.')';
        $titulo2    = 'Alteração de Empreendimento';
        $formid     = 'form_Sistema_AdminC_EmpreendimentoEdit';
        $formbt     = 'Alterar Empreendimento';
        $formlink   = 'Engenharia/Empreendimento/Empreendimentos_Edit2/'.$id;
        $editar     = Array('Engenharia_Empreendimento',$id);
        $campos = Engenharia_Empreendimento_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Empreendimentos_Edit2($id){
        $titulo     = 'Empreendimento Editado com Sucesso';
        $dao        = Array('Engenharia_Empreendimento',$id);
        $funcao     = '$this->Main();';
        $sucesso1   = 'Empreendimento Alterado com Sucesso.';
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
    public function Empreendimentos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa empreendimento e deleta
        $empreendimento = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($empreendimento);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Empreendimento deletado com sucesso')
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
        
        $this->_Visual->Json_Info_Update('Titulo', __('Empreendimento deletado com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    
    
    
    
    
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Estoque_Retirar(){
        
        // Carrega Config
        $titulo1    = 'Retirar Produto do Estoque';
        $titulo2    = 'Retirar Produto do Estoque';
        $formid     = 'Form_Eng_Estoque_Retirar';
        $formbt     = 'Retirar Estoque';
        $formlink   = 'Engenharia/Empreendimento/Estoque_Retirar2/';
        $campos = Engenharia_Estoque_Retirada_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Estoque_Retirar2(){
        GLOBAL $language;
        $idproduto  = (int) $_POST['idproduto'];
        $qnt        = (int) $_POST['qnt'];
        if(comercio_EstoqueControle::Estoque_Retorna($idproduto)<$qnt){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => __('Quantidade não disponivel em Estoque')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->layoult_zerar = false;
            $this->_Visual->Javascript_Executar('$("#qnt").css(\'border\', \'2px solid #FFAEB0\').focus();');
        }else{
            $titulo     = 'Produto retirado do estoque com Sucesso';
            $dao        = 'Engenharia_Estoque_Retirada';
            $funcao     = '$this->Estoque_Retirar();';
            $sucesso1   = 'Retirada bem sucedida';
            $sucesso2   = 'Produto retirado do estoque com sucesso.';
            $alterar    = Array();
            $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
            if($sucesso){
                $motivo = 'Engenharia';
                $identificador  = $this->_Modelo->db->Sql_Select('Engenharia_Estoque_Retirada', Array(),1,'id DESC');
                $idproduto  = $identificador->idproduto;
                $data   = $identificador->data;
                $qnt = $identificador->qnt;
                $identificador  = $identificador->id;
                comercio_EstoqueControle::Estoque_Remover($motivo,$identificador,$idproduto,$qnt,$data);
            }
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Empreendimento_Receber(){
        
        // Carrega Config
        $titulo1    = 'Adicionar Conta a Receber';
        $titulo2    = 'Salvar Conta a Receber';
        $formid     = 'form_Eng_Conta_Receber';
        $formbt     = 'Adicionar à Contas a Receber';
        $formlink   = 'Engenharia/Empreendimento/Empreendimento_Receber2/';
        $campos = Engenharia_Empreendimento_Custo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Empreendimento_Receber2(){
        
        $titulo     = 'Conta a Receber Adicionada com Sucesso';
        $dao        = 'Engenharia_Empreendimento_Custo';
        $funcao     = '$this->Empreendimento_Receber();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Conta a Receber cadastrada com sucesso.';
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        if($sucesso){
            $motivo = 'Engenharia';
            $identificador  = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento_Custo', Array(),1,'id DESC');
            $idempreendimento  = $identificador->empreendimento;
            $parcela_data   = $identificador->data_pag_prevista;
            $parcela_valor = $identificador->valor;
            $parcela_num = '0';
            $identificador  = $identificador->id;
            
            Financeiro_Controle::FinanceiroInt(
                $motivo,
                $motivoid,
                'Engenharia_Empreendimento',
                $idempreendimento,
                'Servidor',
                SRV_NAME_SQL,
                $parcela_valor,$parcela_data,$parcela_num
            );
        }
    }
}
?>
