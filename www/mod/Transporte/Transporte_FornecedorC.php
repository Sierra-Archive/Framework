<?php

class Transporte_FornecedorControle extends Transporte_Controle
{
    public function __construct() {
        parent::__construct();
    }
    static function Endereco_Fornecedor($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Fornecedores');
        $link = 'Transporte/Fornecedor/Fornecedores';
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
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Transporte/Fornecedor/Fornecedores');
        return FALSE;
    }
    static function Fornecedores_Tabela(&$fornecedor) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($fornecedor)) $fornecedor = Array(0=>$fornecedor);reset($fornecedor);
        $perm_view = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Fornecedor/Visualizar');
        foreach ($fornecedor as &$valor) {                
            $table['Id'][$i]           = '#'.$valor->id;
            $table['Razão Social'][$i] = $valor->usuario2;
            $table['Categoria'][$i]    = $valor->categoria2;
            $table['Observação'][$i]   = $valor->obs;
            $table['Visualizar'][$i]   = $Visual->Tema_Elementos_Btn('Visualizar'     ,Array('Visualizar'        ,'Transporte/Fornecedor/Visualizar/'.$valor->id    , ''), $perm_view);
               
            ++$i;
        }
        return Array($table, $i);
    }
    public function Visualizar($id, $export = FALSE) {
        
        
        $fornecedor = $this->_Modelo->db->Sql_Select('Transporte_Fornecedor', 'TF.id=\''.((int) $id).'\'',1);
        
        $this->Gerador_Visualizar_Unidade($fornecedor, 'Visualizar Fornecedor #'.$id);
        
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Fornecedores($export = FALSE) {
        $i = 0;
        self::Endereco_Fornecedor(FALSE);
        $fornecedor = $this->_Modelo->db->Sql_Select('Transporte_Fornecedor');
        if (is_object($fornecedor)) $fornecedor = Array(0=>$fornecedor);
        if ($fornecedor !== FALSE && !empty($fornecedor)) {
            list($table, $i) = self::Fornecedores_Tabela($fornecedor);
            // SE exportar ou mostra em tabela
            if ($export !== FALSE) {
                self::Export_Todos($export, $table, 'Fornecedores');
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
                $mensagem = __('Nenhum Fornecedor Cadastrado para exportar');
            } else {
                $mensagem = __('Nenhum Fornecedor Cadastrado');
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Fornecedores').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Listagem de Fornecedores'));
    }
    /**
     * Painel Adminstrativo de Fornecedores
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Painel() {
        return TRUE;
    }
    static function Painel_Fornecedor($camada, $retornar= TRUE ) {
        $existe = FALSE;
        if ($retornar==='false') $retornar = FALSE;
        // Verifica se Existe Conexao, se nao tiver abre o adicionar conexao, se nao, abre a pasta!
        $Registro = &\Framework\App\Registro::getInstacia();
        $resultado = $Registro->_Modelo->db->Sql_Select('Transporte_Fornecedor', '{sigla}usuario=\''.$Registro->_Acl->Usuario_GetID().'\'',1);
        if (is_object($resultado)) {
            $existe = TRUE;
        }
        
        // Dependendo se Existir Cria Formulario ou Lista arquivos
        if ($existe === FALSE) {
            $html = '<b>Ainda faltam insformações sobre o seu Fornecedor</b><br>'.self::Painel_Fornecedor_Add($camada);
        } else {
            $html = __('Painel');
        }
        
        if ($retornar === TRUE) {
            return $html;
        } else {
            $conteudo = array(
                'location'  =>  '#'.$camada,
                'js'        =>  '',
                'html'      =>  $html
            );
            $Registro->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        }
        /*
                $this->_Visual->Bloco_Customizavel(Array(
                    Array(
                        'span'      =>      5,
                        'conteudo'  =>  Array(Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      $titulo.' #'.$identificador->id,
                            'html'      =>      $html,
                        ),),
                    ),
                    Array(
                        'span'      =>      7,
                        'conteudo'  =>  Array(Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Pasta da '.$titulo.' #'.$identificador->id.' na Fornecedor',
                            'html'      =>      '<span id="proposta_'.$identificador->id.'">'.self::Painel_Fornecedor('comercio_Proposta', $identificador->id,'proposta_'.$identificador->id).'</span>',
                        )/*,Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Sub-'.$tema,
                            'html'      =>      ' Aqui tem !',
                        ),*//*),
                    )
                ));*/
        return TRUE;
    }
    static protected function Painel_Fornecedor_Add($camada) {
        // Carrega Config
        $titulo1    = __('Salvar Dados');
        $titulo2    = __('Salvar Dados');
        $formid     = 'form_Transporte_Fornecedor_Add';
        $formbt     = __('Salvar Dados');
        $formlink   = 'Transporte/Fornecedor/Painel_Fornecedor_Add2/'.$camada;
        $campos = Transporte_Fornecedor_DAO::Get_Colunas();
        // Remove Essas Colunas
        self::DAO_Campos_Retira($campos, 'usuario');
        // Chama Formulario
       return \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, FALSE,'html', FALSE);
    }
    public function Painel_Fornecedor_Add2($camada) {
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Fornecedor', '{sigla}usuario=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if (is_object($resultado)) {
            self::Painel_Fornecedor($camada, FALSE);
            return TRUE;
        }
        $titulo     = __('Dados Atualizados com Sucesso');
        $dao        = 'Transporte_Fornecedor';
        $function     = 'Transporte_FornecedorControle::Painel_Fornecedor(\''.$camada.'\',\'false\');';
        $sucesso1   = __('Atualização bem sucedida');
        $sucesso2   = __('Dados Atualizados com sucesso.');
        $alterar    = Array(
            'usuario'        =>  $this->_Acl->Usuario_GetID(),
        );
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
}
?>
