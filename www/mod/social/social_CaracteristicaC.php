<?php
class social_CaracteristicaControle extends social_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses social_rede_PerfilModelo::Carrega Rede Modelo
    * @uses social_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses social_Controle::$acoesPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        return FALSE; 
    }
    static function Endereco_Caracteristica($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true === TRUE) {
            $_Controle->Tema_Endereco(__('Caracteristicas'),'social/Caracteristica/Caracteristica');
        } else {
            $_Controle->Tema_Endereco(__('Caracteristicas'));
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Caracteristica($export = FALSE) {
        self::Endereco_Caracteristica(FALSE);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Caracteristica',
                'social/Caracteristica/Caracteristicas_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'social/Caracteristica/Caracteristicas',
            )
        )));
        $caracteristicas = $this->_Modelo->db->Sql_Select('Social_Caracteristica');
        if ($caracteristicas !== FALSE && !empty($caracteristicas)) {
            if (is_object($caracteristicas)) $caracteristicas = Array(0=>$caracteristicas);
            reset($caracteristicas);
            foreach ($caracteristicas as $indice=>&$valor) {
                $table['Nome'][$i]            = $valor->nome;
                $table['Descriçao'][$i]        = $valor->descricao;
                $table['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Caracteristica'        ,'social/Caracteristica/Caracteristicas_Edit/'.$valor->id.'/'    , '')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Caracteristica'       ,'social/Caracteristica/Caracteristicas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Caracteristica ?'));
                ++$i;
            }
            if ($export !== FALSE) {
                self::Export_Todos($export, $table, 'Caracteristicas');
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $table,     // Array Com a Tabela
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
            unset($table);
        } else {           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Caracteristica</font></b></center>');
        }
        $titulo = __('Listagem de Caracteristicas').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Caracteristicas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Caracteristicas_Add() {
        self::Endereco_Caracteristica(TRUE);
        // Carrega Config
        $titulo1    = __('Adicionar Caracteristica');
        $titulo2    = __('Salvar Caracteristica');
        $formid     = 'form_Sistema_Caracteristica_Caracteristicas';
        $formbt     = __('Salvar');
        $formlink   = 'social/Caracteristica/Caracteristicas_Add2/';
        $campos = Social_Caracteristica_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Caracteristicas_Add2() {
        $titulo     = __('Caracteristica adicionada com Sucesso');
        $dao        = 'Social_Caracteristica';
        $function     = '$this->Caracteristica();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Caracteristica cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Caracteristicas_Edit($id) {
        self::Endereco_Caracteristica(TRUE);
        // Carrega Config
        $titulo1    = 'Editar Caracteristica (#'.$id.')';
        $titulo2    = __('Alteração de Caracteristica');
        $formid     = 'form_Sistema_CaracteristicaC_CaracteristicaEdit';
        $formbt     = __('Alterar Caracteristica');
        $formlink   = 'social/Caracteristica/Caracteristicas_Edit2/'.$id;
        $editar     = Array('Social_Caracteristica', $id);
        $campos = Social_Caracteristica_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Caracteristicas_Edit2($id) {
        $titulo     = __('Caracteristica editada com Sucesso');
        $dao        = Array('Social_Caracteristica', $id);
        $function     = '$this->Caracteristica();';
        $sucesso1   = __('Caracteristica Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Caracteristicas_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Social_Caracteristica', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Caracteristica deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Caracteristica();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Caracteristica deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
