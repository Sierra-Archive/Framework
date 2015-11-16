<?php

class Transporte_ArmazemControle extends Transporte_Controle
{
    public function __construct() {
        parent::__construct();
    }
    static function Endereco_Armazem($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Armazens');
        $link = 'Transporte/Armazem/Armazens';
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
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Transporte/Armazem/Armazens');
        return FALSE;
    }
    static function Armazens_Tabela(&$armazem) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if (is_object($armazem)) $armazem = Array(0=>$armazem);reset($armazem);
        $perm_view = $Registro->_Acl->Get_Permissao_Url('Transporte/Armazem/Visualizar');
        foreach ($armazem as &$valor) {                
            $tabela['Id'][$i]           = '#'.$valor->id;
            $tabela['Razão Social'][$i] = $valor->usuario2;
            $tabela['Categoria'][$i]    = $valor->categoria2;
            $tabela['Observação'][$i]   = $valor->obs;
            $tabela['Visualizar'][$i]   = $Visual->Tema_Elementos_Btn('Visualizar'     ,Array('Visualizar'        ,'Transporte/Armazem/Visualizar/'.$valor->id    , ''), $perm_view);
            
            ++$i;
        }
        return Array($tabela, $i);
    }
    public function Visualizar($id, $export = FALSE) {
        
        
        $armazem = $this->_Modelo->db->Sql_Select('Transporte_Armazem', 'TA.id=\''.((int) $id).'\'',1);
        
        $this->Gerador_Visualizar_Unidade($armazem, 'Visualizar Armazém #'.$id);
        
    }
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Armazens($export = FALSE) {
        $i = 0;
        self::Endereco_Armazem(FALSE);
        $armazem = $this->_Modelo->db->Sql_Select('Transporte_Armazem');
        if (is_object($armazem)) $armazem = Array(0=>$armazem);
        if ($armazem !== FALSE && !empty($armazem)) {
            list($tabela, $i) = self::Armazens_Tabela($armazem);
            // SE exportar ou mostra em tabela
            if ($export !== FALSE) {
                self::Export_Todos($export, $tabela, 'Armazens');
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
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
            unset($tabela);
        } else {
            if ($export !== FALSE) {
                $mensagem = __('Nenhum Armazém Cadastrado para exportar');
            } else {
                $mensagem = __('Nenhum Armazém Cadastrado');
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Armazéns').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Listagem de Armazéns'));
    }
    /**
     * Painel Adminstrativo de Armazens
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Painel() {
        return TRUE;
    }
    static function Painel_Armazem($camada, $retornar= TRUE ) {
        $existe = FALSE;
        if ($retornar==='false') $retornar = FALSE;
        // Verifica se Existe Conexao, se nao tiver abre o adicionar conexao, se nao, abre a pasta!
        $Registro = &\Framework\App\Registro::getInstacia();
        $resultado = $Registro->_Modelo->db->Sql_Select('Transporte_Armazem', '{sigla}usuario=\''.$Registro->_Acl->Usuario_GetID().'\'',1);
        if (is_object($resultado)) {
            $existe = TRUE;
        }
        
        // Dependendo se Existir Cria Formulario ou Lista arquivos
        if ($existe === FALSE) {
            $html = '<b>Ainda faltam insformações sobre o seu Armazém</b><br>'.self::Painel_Armazem_Add($camada);
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
                            'title'     =>      'Pasta da '.$titulo.' #'.$identificador->id.' na Armazem',
                            'html'      =>      '<span id="proposta_'.$identificador->id.'">'.self::Painel_Armazem('comercio_Proposta', $identificador->id,'proposta_'.$identificador->id).'</span>',
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
    static protected function Painel_Armazem_Add($camada) {
        // Carrega Config
        $titulo1    = __('Salvar Dados');
        $titulo2    = __('Salvar Dados');
        $formid     = 'form_Transporte_Armazem_Add';
        $formbt     = __('Salvar Dados');
        $formlink   = 'Transporte/Armazem/Painel_Armazem_Add2/'.$camada;
        $campos = Transporte_Armazem_DAO::Get_Colunas();
        // Remove Essas Colunas
        self::DAO_Campos_Retira($campos, 'usuario');
        // Chama Formulario
       return \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, FALSE,'html', FALSE);
    }
    public function Painel_Armazem_Add2($camada) {
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Armazem', '{sigla}usuario=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if (is_object($resultado)) {
            self::Painel_Armazem($camada, FALSE);
            return TRUE;
        }
        $titulo     = __('Dados Atualizados com Sucesso');
        $dao        = 'Transporte_Armazem';
        $funcao     = 'Transporte_ArmazemControle::Painel_Armazem(\''.$camada.'\',\'false\');';
        $sucesso1   = __('Atualização bem sucedida');
        $sucesso2   = __('Dados Atualizados com sucesso.');
        $alterar    = Array(
            'usuario'        =>  $this->_Acl->Usuario_GetID(),
        );
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);
    }
}
?>
