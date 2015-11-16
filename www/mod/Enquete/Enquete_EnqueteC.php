<?php
class Enquete_EnqueteControle extends Enquete_Controle
{
    public function __construct() {
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses enquete_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Enquete/Enquete/Enquetes');
        return FALSE;
    }
    static function Endereco_Enquete($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true === TRUE) {
            $_Controle->Tema_Endereco(__('Enquetes'),'Enquete/Enquete/Enquetes');
        } else {
            $_Controle->Tema_Endereco(__('Enquetes'));
        }
    }
    static function Enquetes_Tabela(&$enquetes) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if (is_object($enquetes)) $enquetes = Array(0=>$enquetes);
        reset($enquetes);
        $perm_view = $Registro->_Acl->Get_Permissao_Url('Enquete/Resposta/Respostas');
        $perm_editar = $Registro->_Acl->Get_Permissao_Url('Enquete/Enquete/Enquetes_Edit');
        $perm_del = $Registro->_Acl->Get_Permissao_Url('Enquete/Enquete/Enquetes_Del');

        foreach ($enquetes as &$valor) {
            $resp_votos = $Modelo->db->Sql_Select('Enquete_Voto',Array(
                'enquete'   =>  $valor->id
            ));
            if ($resp_votos === FALSE) {
                $resp_votos_res = 0;
            } else if (is_object($resp_votos)) {
                $resp_votos_res = 1;
            } else {
                $resp_votos_res = count($resp_votos);
            }
            $tabela['Tipo de Enquete'][$i]  = $valor->categoria2;
            $tabela['Pergunta'][$i]         = $valor->nome;
            $tabela['Nº de Votos'][$i]      = ($resp_votos_res==1)?$resp_votos_res.' Voto':$resp_votos_res.' Votos';
            $tabela['Observação'][$i]       = $valor->obs;
            $tabela['Data Registrado'][$i]  = $valor->log_date_add;
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar Enquete'    ,'Enquete/Resposta/Respostas/'.$valor->id.'/'    , ''), $perm_view).
                                              $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Enquete'        ,'Enquete/Enquete/Enquetes_Edit/'.$valor->id.'/'    , ''), $perm_editar).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Enquete'       ,'Enquete/Enquete/Enquetes_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Enquete ?'), $perm_del);
            ++$i;
        }
        return Array($tabela, $i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Enquetes($export = FALSE) {
        self::Endereco_Enquete(FALSE);
        $i = 0;
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Enquete',
                'Enquete/Enquete/Enquetes_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Enquete/Enquete/Enquetes',
            )
        )));
        // Conexao
        $enquetes = $this->_Modelo->db->Sql_Select('Enquete');
        if ($enquetes !== FALSE && !empty($enquetes)) {
            list($tabela, $i) = self::Enquetes_Tabela($enquetes);
            if ($export !== FALSE) {
                self::Export_Todos($export, $tabela, 'Enquetes');
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    true,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        } else {            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Enquete</font></b></center>');
        }
        $titulo = __('Listagem de Enquetes').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Enquetes'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Enquetes_Add() {
        self::Endereco_Enquete();
        // Carrega Config
        $titulo1    = __('Adicionar Enquete');
        $titulo2    = __('Salvar Enquete');
        $formid     = 'form_Sistema_Admin_Enquetes';
        $formbt     = __('Salvar');
        $formlink   = 'Enquete/Enquete/Enquetes_Add2/';
        $campos = Enquete_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Enquetes_Add2() {
        $titulo     = __('Enquete Adicionada com Sucesso');
        $dao        = 'Enquete';
        $funcao     = '$this->Enquetes();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Enquete cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Enquetes_Edit($id) {
        self::Endereco_Enquete();
        // Carrega Config
        $titulo1    = 'Editar Enquete (#'.$id.')';
        $titulo2    = __('Alteração de Enquete');
        $formid     = 'form_Sistema_AdminC_EnqueteEdit';
        $formbt     = __('Alterar Enquete');
        $formlink   = 'Enquete/Enquete/Enquetes_Edit2/'.$id;
        $editar     = Array('Enquete', $id);
        $campos = Enquete_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Enquetes_Edit2($id) {
        $titulo     = __('Enquete Editada com Sucesso');
        $dao        = Array('Enquete', $id);
        $funcao     = '$this->Enquetes();';
        $sucesso1   = __('Enquete Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Enquetes_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa enquete e deleta
        $enquete = $this->_Modelo->db->Sql_Select('Enquete', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($enquete);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Enquete deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Enquetes();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Enquete deletada com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', FALSE);
    }
}
?>
