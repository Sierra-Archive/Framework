<?php
class predial_AdvertenciaControle extends predial_Controle
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
    * @uses predial_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'predial/Advertencia/Advertencias');
        return false;
    }
    static function Endereco_Advertencia($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Advertencias');
        $link = 'predial/Advertencia/Advertencias';
        if ($true === true) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Advertencias_Tabela(&$advertencias) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($advertencias)) $advertencias = Array(0=>$advertencias);
        reset($advertencias);
        foreach ($advertencias as &$valor) {
            $table[__('Bloco')][$i]            = $valor->bloco2;
            $table[__('Apartamento')][$i]      = $valor->apart2;
            $table[__('Nome')][$i]             = $valor->nome;
            $table[__('Descrição')][$i]        = $valor->descricao;
            $table[__('Data do Ocorrido')][$i] = $valor->data_acontecimento;
            $table[__('Data Registrado')][$i]  = $valor->log_date_add;
            $table[__('Funções')][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Advertência')        ,'predial/Advertencia/Advertencias_Edit/'.$valor->id.'/'    , '')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Advertência')       ,'predial/Advertencia/Advertencias_Del/'.$valor->id.'/'     , __('Deseja realmente deletar essa Advertência ?')));
            ++$i;
        }
        return Array($table, $i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Advertencias() {
        self::Endereco_Advertencia();
        $i = 0;
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Advertência',
                'predial/Advertencia/Advertencias_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'predial/Advertencia/Advertencias',
            )
        )));
        // Busca
        $advertencias = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Advertencia');
        if ($advertencias !== false && !empty($advertencias)) {
            list($table, $i) = self::Advertencias_Tabela($advertencias);
            $this->_Visual->Show_Tabela_DataTable($table);
            unset($table);
        } else {            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Advertência</font></b></center>');
        }
        $titulo = __('Listagem de Advertências').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Advertências'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Advertencias_Add() {
        self::Endereco_Advertencia(false);
        // Carrega Config
        $titulo1    = __('Adicionar Advertência');
        $titulo2    = __('Salvar Advertência');
        $formid     = 'form_Sistema_Admin_Advertencias';
        $formbt     = __('Salvar');
        $formlink   = 'predial/Advertencia/Advertencias_Add2/';
        $campos = Predial_Bloco_Apart_Advertencia_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Advertencias_Add2() {
        $titulo     = __('Advertência Adicionada com Sucesso');
        $dao        = 'Predial_Bloco_Apart_Advertencia';
        $function     = '$this->Advertencias();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Advertência cadastrada com sucesso.');
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
        if ($sucesso === true) {
            // Pega o Correio
            $identificador  = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Advertencia', Array(),1,'id DESC');
            // Captura Apartamento Responsavel
            $enviar = false;
            $apartamento  = $this->_Modelo->db->Sql_Select(
                'Predial_Bloco_Apart', 
                Array(
                    'id'        =>  $identificador->apart,
                    'bloco'        =>  $identificador->bloco
                ),
                1,
                'id DESC'
            );
            if (!is_object($apartamento)) {
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Apartamento não existe.')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
                return false;
            }
            if (is_int($apartamento->morador) && $apartamento->morador!=0) {
                $usuario  = $this->_Modelo->db->Sql_Select(
                    'Usuario', 
                    Array('id'=>$apartamento->morador),
                    1
                );
                if ($usuario !== false) {
                    $nome = $usuario->nome;
                    $enviar = '';
                    if ($usuario->email!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email)) {
                        $enviar .= '->setTo(\''.$usuario->email.'\', \''.$nome.'\')';
                    }
                    if ($usuario->email2!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email2)) {
                        $enviar .= '->setTo(\''.$usuario->email2.'\', \''.$nome.'\')';
                    }
                }
            }
            // Avisa que nao foi, ou manda 
            if ($enviar === false || $enviar=='') {
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Advertência não Enviada'),
                    "mgs_secundaria" => __('Verifique se o Morador está registrado no sistema e com um email válido.')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
            } else {
                $mailer = new \Framework\Classes\Email();
                // Mandar Mensagem
                $mensagem   =   'Prezado Sr. / Sra. '.$nome.',
<br><br>Venho, por meio deste, informar que o Sr. / Sra. está sendo advertido em vista de ( ocorrido ). Caso haja mais duas novas advertências, o Sr. / Sra. irá receber uma multa. Sinta-se à vontade para entrar em contato com a administração para dirimir eventuais dúvidas.
<br><br>Atenciosamente,<br><br><br>A Administração<br>'.
                                '<b>Bloco / Apart:</b>'.$identificador->bloco.' / '.$identificador->apart.'<br>';
                // Cadastra Aviso
                $aviso = new \Predial_Bloco_Apart_Correio_Aviso_DAO();
                $aviso->advertencia = $identificador->id;
                $aviso->mensagem = $mensagem;
                $this->_Modelo->bd->Sql_Insert($aviso);
                // Manda Email
                eval('$send	= $mailer'.$enviar.'
                ->setSubject(\'Nova Advertência - \'.SISTEMA_NOME)
                ->setFrom(SISTEMA_EMAIL, SISTEMA_NOME)
                ->addGenericHeader(\'X-Mailer\', \'PHP/\' . phpversion())
                ->addGenericHeader(\'Content-Type\', \'text/html; charset="utf-8"\')
                ->setMessage(\'<strong>'.$mensagem.'</strong>\')
                ->setWrap(78)->send();');
                if (!$send) {
                    $mensagens = array(
                        "tipo" => 'erro',
                        "mgs_principal" => __('Advertência não Enviada'),
                        "mgs_secundaria" => __('Verifique se o Morador está registrado no sistema e com um email válido.')
                    );
                    $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
                }
            }
        }
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Advertencias_Edit($id) {
        self::Endereco_Advertencia(false);
        // Carrega Config
        $titulo1    = 'Editar Advertência (#'.$id.')';
        $titulo2    = __('Alteração de Advertência');
        $formid     = 'form_Sistema_AdminC_AdvertenciaEdit';
        $formbt     = __('Alterar Advertência');
        $formlink   = 'predial/Advertencia/Advertencias_Edit2/'.$id;
        $editar     = Array('Predial_Bloco_Apart_Advertencia', $id);
        $campos = Predial_Bloco_Apart_Advertencia_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Advertencias_Edit2($id) {
        $titulo     = __('Advertência Editada com Sucesso');
        $dao        = Array('Predial_Bloco_Apart_Advertencia', $id);
        $function     = '$this->Advertencias();';
        $sucesso1   = __('Advertência Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Advertencias_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa advertencia e deleta
        $advertencia = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Advertencia', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($advertencia);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Advertência deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Advertencias();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Advertência deletada com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    
    
    
    
    
    
    
    static function Personalizados_Tabela(&$advertencias) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($advertencias)) $advertencias = Array(0=>$advertencias);
        reset($advertencias);
        foreach ($advertencias as &$valor) {
            $table[__('Nome')][$i]             = $valor->nome;
            $table[__('Descrição')][$i]        = $valor->descricao;
            $table[__('Data do Ocorrido')][$i] = $valor->data_acontecimento;
            $table[__('Data Registrado')][$i]  = $valor->log_date_add;
            ++$i;
        }
        return Array($table, $i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    static function Personalizados($apartamento) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $i = 0;
        // Botao Add
        $html = $Registro->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'predial/Advertencia/Advertencias',
            )
        ));
        // Busca
        $where = Array(
            'apart' =>   (int) $apartamento
        );
        $advertencias = $Registro->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Advertencia', $where);
        if ($advertencias !== false && !empty($advertencias)) {
            list($table, $i) = self::Personalizados_Tabela($advertencias);
            $html .= $Registro->_Visual->Show_Tabela_DataTable($table, '', false);
            unset($table);
        } else {            
            $html .= '<center><b><font color="#FF0000" size="3">Nenhuma Advertência para seu Apartamento</font></b></center>';
        }
        $titulo = __('Listagem de Advertências').' ('.$i.')';
        return Array($titulo, $html);
    }
}
?>
