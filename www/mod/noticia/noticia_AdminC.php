<?php

class noticia_AdminControle extends noticia_Controle
{
    public function __construct() {
        parent::__construct();
    }
    static function Endereco_Noticia($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Noticias');
        $link = 'noticia/Admin/Noticias';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'noticia/Admin/Noticias');
        return FALSE;
    }
    static function Noticias_Tabela(&$noticia) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($noticia)) $noticia = Array(0=>$noticia);reset($noticia);
        foreach ($noticia as &$valor) {                
            $table['Id'][$i]           = '#'.$valor->id;
            $table['Categoria'][$i]    = $valor->categoria2;
            $table['Foto'][$i]         = '<img alt="'.__('Foto da Noticia').' src="'.$valor->foto.'" style="max-width:100px;" />';
            $table['Titulo'][$i]       = $valor->nome;
            if ($valor->status==1 || $valor->status=='1') {
                $texto = __('Ativado');
                $valor->status='1';
            } else {
                $texto = __('Desativado');
                $valor->status='0';
            }
            $table['Funções'][$i]      = '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$valor->status     ,Array($texto        ,'noticia/Admin/Status/'.$valor->id.'/'    , '')).'</span>';
            if ($valor->destaque==1) {
                $texto = __('Em Destaque');
            } else {
                $texto = __('Não está em destaque');
            }
            $table['Funções'][$i]      .= '<span id="destaques'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Destaque'.$valor->destaque   ,Array($texto   ,'noticia/Admin/Destaques/'.$valor->id.'/'    , '')).'</span>';
            $table['Funções'][$i]      .= $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Noticia'        ,'noticia/Admin/Noticias_Edit/'.$valor->id.'/'    , '')).
                                           $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Noticia'       ,'noticia/Admin/Noticias_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Noticia ?'));
            ++$i;
        }
        return Array($table, $i);
    }
    
    /**
     * Deleta Campos de Propostas 
     * @param type $campos
     * @param type $tema
     */
    static function Campos_Deletar(&$campos) {
        // Retira Padroes
        if (!(\Framework\App\Sistema_Funcoes::Perm_Modulos('Musica'))) {
             self::DAO_Campos_Retira($campos, 'Artistas');
        }
        
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('noticia_Categoria') === FALSE) {
            self::DAO_Campos_Retira($campos, 'categoria');
        }
       
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Noticias($export = FALSE) {
        $i = 0;
        self::Endereco_Noticia(FALSE);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Noticia',
                'noticia/Admin/Noticias_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'noticia/Admin/Noticias',
            )
        )));
        $noticia = $this->_Modelo->db->Sql_Select('Noticia');
        if (is_object($noticia)) $noticia = Array(0=>$noticia);
        if ($noticia !== FALSE && !empty($noticia)) {
            list($table, $i) = self::Noticias_Tabela($noticia);
            // SE exportar ou mostra em tabela
            if ($export !== FALSE) {
                self::Export_Todos($export, $table, 'Noticias');
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $table,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    FALSE,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($table);
        } else {
            if ($export !== FALSE) {
                $mensagem = __('Nenhuma Noticia Cadastrada para exportar');
            } else {
                $mensagem = __('Nenhuma Noticia Cadastrada');
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Noticias').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Noticias'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Noticias_Add() {
        self::Endereco_Noticia(TRUE);
        // Carrega Config
        $titulo1    = __('Adicionar Noticia');
        $titulo2    = __('Salvar Noticia');
        $formid     = 'formnoticia_Admin_Noticia';
        $formbt     = __('Salvar');
        $formlink   = 'noticia/Admin/Noticias_Add2/';
        $campos = Noticia_DAO::Get_Colunas();
        
        self::Campos_Deletar($campos);

        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Noticias_Add2() {
        $titulo     = __('Noticia Adicionada com Sucesso');
        $dao        = 'Noticia';
        $function     = '$this->Noticias();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Noticia cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Noticias_Edit($id) {
        self::Endereco_Noticia(TRUE);
        // Carrega Config
        $titulo1    = 'Editar Noticia (#'.$id.')';
        $titulo2    = __('Alteração de Noticia');
        $formid     = 'formnoticia_AdminC_NoticiaEdit';
        $formbt     = __('Alterar Noticia');
        $formlink   = 'noticia/Admin/Noticias_Edit2/'.$id;
        $editar     = Array('Noticia', $id);
        $campos = Noticia_DAO::Get_Colunas();
        
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Noticias_Edit2($id) {
        $id = (int) $id;
        $titulo     = __('Noticia Alterada com Sucesso');
        $dao        = Array('Noticia', $id);
        $function     = '$this->Noticias();';
        $sucesso1   = __('Noticia Alterada com Sucesso');
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
    public function Noticias_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa noticia e deleta
        $noticia    =  $this->_Modelo->db->Sql_Select('Noticia', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($noticia);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Noticia Deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Noticias();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Noticia deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    public function Status($id = FALSE) {
        if ($id === FALSE) {
            return FALSE;
        }
        $resultado = $this->_Modelo->db->Sql_Select('Noticia', Array('id'=>$id),1);
        if ($resultado === FALSE || !is_object($resultado)) {
            return FALSE;
        }
        if ($resultado->status==1 || $resultado->status=='1') {
            $resultado->status='0';
        } else {
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if ($sucesso) {
            if ($resultado->status==1) {
                $texto = __('Ativado');
            } else {
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'noticia/Admin/Status/'.$resultado->id.'/'    , ''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    public function Destaques($id = FALSE) {
        if ($id === FALSE) {
            return FALSE;
        }
        $resultado = $this->_Modelo->db->Sql_Select('Noticia', Array('id'=>$id),1);
        if ($resultado === FALSE || !is_object($resultado)) {
            return FALSE;
        }
        if ($resultado->destaque==1 || $resultado->destaque=='1') {
            $resultado->destaque='0';
        } else {
            $resultado->destaque='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if ($sucesso) {
            if ($resultado->destaque==1) {
                $texto = __('Em destaque');
            } else {
                $texto = __('Não está em destaque');
            }
            $conteudo = array(
                'location' => '#destaques'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Destaque'.$resultado->destaque     ,Array($texto        ,'noticia/Admin/Destaques/'.$resultado->id.'/'    , ''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Destaque Alterado')); 
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
