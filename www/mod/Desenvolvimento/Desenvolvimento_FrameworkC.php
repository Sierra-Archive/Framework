<?php
class Desenvolvimento_FrameworkControle extends Desenvolvimento_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
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
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        return FALSE;
    }
    protected function Endereco_Modulo($true= TRUE ) {
        if ($true === TRUE) {
            $this->Tema_Endereco(__('Modulos'),'Desenvolvimento/Framework/Modulos');
        } else {
            $this->Tema_Endereco(__('Modulos'));
        }
    }
    static function Modulos_Tabela($modulos) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($modulos)) $modulos = Array(0=>$modulos);
        reset($modulos);
        foreach ($modulos as $indice=>&$valor) {
            $table['#Id'][$i]          =   '#'.$valor->id;
            $table['Submodulo'][$i]    =   $valor->submodulo2;
            $table['Nome'][$i]         =   $valor->nome;
            $table['Funções'][$i]      =   $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Modulo'        ,'Desenvolvimento/Framework/Modulos_Edit/'.$valor->id.'/'    , '')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Modulo'       ,'Desenvolvimento/Framework/Modulos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Modulo ?'));
            ++$i;
        }
        return Array($table, $i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Modulos($export = FALSE) {
        $this->Endereco_Modulo(FALSE);
        $i = 0;
        // Add BOtao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Modulo',
                'Desenvolvimento/Framework/Modulos_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Desenvolvimento/Framework/Modulos',
            )
        )));
        // Query
        $modulos = $this->_Modelo->db->Sql_Select('Desenvolvimento_Framework_Modulo');
        if ($modulos !== FALSE && !empty($modulos)) {
            list($table, $i) = self::Modulos_Tabela($modulos);
            if ($export !== FALSE) {
                self::Export_Todos($export, $table, 'Modulos');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Modulo</font></b></center>');
        }
        $titulo = __('Listagem de Modulos').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Modulos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Modulos_Add() {
        $this->Endereco_Modulo();
        // Carrega Config
        $titulo1    = __('Adicionar Modulo');
        $titulo2    = __('Salvar Modulo');
        $formid     = 'form_Desenvolvimento_Framework_Modulos_Add';
        $formbt     = __('Salvar');
        $formlink   = 'Desenvolvimento/Modulo/Modulos_Add2/';
        $campos = Desenvolvimento_Framework_Modulo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Modulos_Add2() {
        $titulo     = __('Modulo Adicionado com Sucesso');
        $dao        = 'Desenvolvimento_Framework_Modulo';
        $function     = '$this->Modulos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Modulo cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Modulos_Edit($id) {
        $this->Endereco_Modulo();
        // Carrega Config
        $titulo1    = 'Editar Modulo (#'.$id.')';
        $titulo2    = __('Alteração de Modulo');
        $formid     = 'form_Desenvolvimento_Framework_Modulos_Edit';
        $formbt     = __('Alterar Modulo');
        $formlink   = 'Desenvolvimento/Framework/Modulos_Edit2/'.$id;
        $editar     = Array('Desenvolvimento_Framework_Modulo', $id);
        $campos = Desenvolvimento_Framework_Modulo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Modulos_Edit2($id) {
        $titulo     = __('Modulo Editado com Sucesso');
        $dao        = Array('Desenvolvimento_Framework_Modulo', $id);
        $function     = '$this->Modulos();';
        $sucesso1   = __('Modulo Alterado com Sucesso.');
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
    public function Modulos_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $modulos = $this->_Modelo->db->Sql_Select('Desenvolvimento_Framework_Modulo', '{sigla}id=\''.$id.'\'');
        $sucesso =  $this->_Modelo->db->Sql_Delete($modulos);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Modulo Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Modulos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Modulo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    
    
    protected function Endereco_Submodulo($true= TRUE ) {
        if ($true === TRUE) {
            $this->Tema_Endereco(__('Submodulos'),'Desenvolvimento/Framework/Submodulos');
        } else {
            $this->Tema_Endereco(__('Submodulos'));
        }
    }
    static function Submodulos_Tabela($submodulos) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($submodulos)) $submodulos = Array(0=>$submodulos);
        reset($submodulos);
        foreach ($submodulos as $indice=>&$valor) {
            $table['#Id'][$i]          =   '#'.$valor->id;
            $table['Modulo'][$i]       =   $valor->modulo2;
            $table['Nome'][$i]         =   $valor->nome;
            $table['Funções'][$i]      =   $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Submodulo'        ,'Desenvolvimento/Framework/Submodulos_Edit/'.$valor->id.'/'    , '')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Submodulo'       ,'Desenvolvimento/Framework/Submodulos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Submodulo ?'));
            ++$i;
        }
        return Array($table, $i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Submodulos($export = FALSE) {
        $this->Endereco_Submodulo(FALSE);
        $i = 0;
        // Add BOtao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Submodulo',
                'Desenvolvimento/Framework/Submodulos_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Desenvolvimento/Framework/Submodulos',
            )
        )));
        // Query
        $submodulos = $this->_Modelo->db->Sql_Select('Desenvolvimento_Framework_Submodulo');
        if ($submodulos !== FALSE && !empty($submodulos)) {
            list($table, $i) = self::Submodulos_Tabela($submodulos);
            if ($export !== FALSE) {
                self::Export_Todos($export, $table, 'Submodulos');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Submodulo</font></b></center>');
        }
        $titulo = __('Listagem de Submodulos').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Submodulos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Submodulos_Add() {
        $this->Endereco_Submodulo();
        // Carrega Config
        $titulo1    = __('Adicionar Submodulo');
        $titulo2    = __('Salvar Submodulo');
        $formid     = 'form_Desenvolvimento_Framework_Submodulos_Add';
        $formbt     = __('Salvar');
        $formlink   = 'Desenvolvimento/Submodulo/Submodulos_Add2/';
        $campos = Desenvolvimento_Framework_Submodulo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Submodulos_Add2() {
        $titulo     = __('Submodulo Adicionado com Sucesso');
        $dao        = 'Desenvolvimento_Framework_Submodulo';
        $function     = '$this->Submodulos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Submodulo cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Submodulos_Edit($id) {
        $this->Endereco_Submodulo();
        // Carrega Config
        $titulo1    = 'Editar Submodulo (#'.$id.')';
        $titulo2    = __('Alteração de Submodulo');
        $formid     = 'form_Desenvolvimento_Framework_Submodulos_Edit';
        $formbt     = __('Alterar Submodulo');
        $formlink   = 'Desenvolvimento/Framework/Submodulos_Edit2/'.$id;
        $editar     = Array('Desenvolvimento_Framework_Submodulo', $id);
        $campos = Desenvolvimento_Framework_Submodulo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Submodulos_Edit2($id) {
        $titulo     = __('Submodulo Editado com Sucesso');
        $dao        = Array('Desenvolvimento_Framework_Submodulo', $id);
        $function     = '$this->Submodulos();';
        $sucesso1   = __('Submodulo Alterado com Sucesso.');
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
    public function Submodulos_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $submodulos = $this->_Modelo->db->Sql_Select('Desenvolvimento_Framework_Submodulo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($submodulos);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Submodulo Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Submodulos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Submodulo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    
    
    protected function Endereco_Metodo($true= TRUE ) {
        if ($true === TRUE) {
            $this->Tema_Endereco(__('Metodos'),'Desenvolvimento/Framework/Metodos');
        } else {
            $this->Tema_Endereco(__('Metodos'));
        }
    }
    static function Metodos_Tabela($metodos) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($metodos)) $metodos = Array(0=>$metodos);
        reset($metodos);
        foreach ($metodos as $indice=>&$valor) {
            $table['#Id'][$i]          =   '#'.$valor->id;
            $table['Nome'][$i]         =   $valor->nome;
            $table['Funções'][$i]      =   $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Metodo'        ,'Desenvolvimento/Framework/Metodos_Edit/'.$valor->id.'/'    , '')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Metodo'       ,'Desenvolvimento/Framework/Metodos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Metodo ?'));
            ++$i;
        }
        return Array($table, $i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Metodos($export = FALSE) {
        $this->Endereco_Metodo(FALSE);
        $i = 0;
        // Add BOtao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Metodo',
                'Desenvolvimento/Framework/Metodos_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Desenvolvimento/Framework/Metodos',
            )
        )));
        // Query
        $metodos = $this->_Modelo->db->Sql_Select('Desenvolvimento_Framework_Metodo');
        if ($metodos !== FALSE && !empty($metodos)) {
            list($table, $i) = self::Metodos_Tabela($metodos);
            if ($export !== FALSE) {
                self::Export_Todos($export, $table, 'Metodos');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Metodo</font></b></center>');
        }
        $titulo = __('Listagem de Metodos').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Metodos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Metodos_Add() {
        $this->Endereco_Metodo();
        // Carrega Config
        $titulo1    = __('Adicionar Metodo');
        $titulo2    = __('Salvar Metodo');
        $formid     = 'form_Desenvolvimento_Framework_Metodos_Add';
        $formbt     = __('Salvar');
        $formlink   = 'Desenvolvimento/Metodo/Metodos_Add2/';
        $campos = Desenvolvimento_Framework_Metodo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Metodos_Add2() {
        $titulo     = __('Metodo Adicionado com Sucesso');
        $dao        = 'Desenvolvimento_Framework_Metodo';
        $function     = '$this->Metodos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Metodo cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Metodos_Edit($id) {
        $this->Endereco_Metodo();
        // Carrega Config
        $titulo1    = 'Editar Metodo (#'.$id.')';
        $titulo2    = __('Alteração de Metodo');
        $formid     = 'form_Desenvolvimento_Framework_Metodos_Edit';
        $formbt     = __('Alterar Metodo');
        $formlink   = 'Desenvolvimento/Framework/Metodos_Edit2/'.$id;
        $editar     = Array('Desenvolvimento_Framework_Metodo', $id);
        $campos = Desenvolvimento_Framework_Metodo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Metodos_Edit2($id) {
        $titulo     = __('Metodo Editado com Sucesso');
        $dao        = Array('Desenvolvimento_Framework_Metodo', $id);
        $function     = '$this->Metodos();';
        $sucesso1   = __('Metodo Alterado com Sucesso.');
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
    public function Metodos_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $metodos = $this->_Modelo->db->Sql_Select('Desenvolvimento_Framework_Metodo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($metodos);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Metodo Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Metodos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Metodo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}

