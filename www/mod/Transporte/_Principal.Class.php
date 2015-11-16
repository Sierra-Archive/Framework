<?php
class Transporte_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo Transporte aparecer na pagina HOME
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        $Registro = Framework\App\Registro::getInstacia();
        
        // Se for Armazem Libera Painel de Armazem
        if ($Registro->_Acl->Get_Permissao_Url('Transporte/Armazem/Painel')) {
                $Visual->Bloco_Customizavel(Array(
                    Array(
                        'span'      =>      12,
                        'conteudo'  =>  Array(Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Painel sobre o Meu Armazem',
                            'html'      =>      '<span id="painel_armazem">'.Transporte_ArmazemControle::Painel_Armazem('painel_armazem').'</span>',
                        )/*,Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Sub-'.$tema,
                            'html'      =>      ' Aqui tem !',
                        ),*/),
                    )
                ));;
        }
        
        // Se for Caminhoneiro Libera Painel de Caminhoneiro
        if ($Registro->_Acl->Get_Permissao_Url('Transporte/Caminhoneiro/Painel')) {
                $Visual->Bloco_Customizavel(Array(
                    Array(
                        'span'      =>      12,
                        'conteudo'  =>  Array(Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Painel sobre o Meu Caminhoneiro',
                            'html'      =>      '<span id="painel_caminhoneiro">'.Transporte_CaminhoneiroControle::Painel_Caminhoneiro('painel_caminhoneiro').'</span>',
                        )/*,Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Sub-'.$tema,
                            'html'      =>      ' Aqui tem !',
                        ),*/),
                    )
                ));;
        }
        
        // Se for Transportadora Libera Painel de Transportadora
        if ($Registro->_Acl->Get_Permissao_Url('Transporte/Transportadora/Painel')) {
                $Visual->Bloco_Customizavel(Array(
                    Array(
                        'span'      =>      12,
                        'conteudo'  =>  Array(Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Painel sobre o Meu Transportadora',
                            'html'      =>      '<span id="painel_transportadora">'.Transporte_TransportadoraControle::Painel_Transportadora('painel_transportadora').'</span>',
                        )/*,Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Sub-'.$tema,
                            'html'      =>      ' Aqui tem !',
                        ),*/),
                    )
                ));;
        }
        
        // Se for Fornecedor Libera Painel de Fornecedor
        if ($Registro->_Acl->Get_Permissao_Url('Transporte/Fornecedor/Painel')) {
                $Visual->Bloco_Customizavel(Array(
                    Array(
                        'span'      =>      12,
                        'conteudo'  =>  Array(Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Painel sobre o Meu Fornecedor',
                            'html'      =>      '<span id="painel_fornecedor">'.Transporte_FornecedorControle::Painel_Fornecedor('painel_fornecedor').'</span>',
                        )/*,Array(
                            'div_ext'   =>      FALSE,
                            'title_id'  =>      FALSE,
                            'title'     =>      'Sub-'.$tema,
                            'html'      =>      ' Aqui tem !',
                        ),*/),
                    )
                ));;
        }
        
        return TRUE;
    }
    static function Widget(&$_Controle) {
        return TRUE;
    } 
    
    static function Busca(&$controle, &$Modelo, &$Visual, $busca) {
        $i = 0;
        // Busca Armazens
        $result = self::Busca_Armazens($controle, $Modelo, $Visual, $busca);
        if ($result !== FALSE) {
            $i = $i + $result;
        }
        // Retorna
        if (is_int($i) && $i>0) {
            return $i;
        } else {
            return FALSE;
        }
    }
    static function Config() {
        return FALSE;
    }
    
    static function Relatorio($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    
    static function Estatistica($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    /***********************
     * BUSCAS
     */
    static function Busca_Armazens($controle, $Modelo, $Visual, $busca) {
        /*$where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          //'texto'                   => '%'.$busca.'%',
        ));
        $i = 0;
        $armazens = $Modelo->db->Sql_Select('Transporte_Armazem', $where);
        if ($armazens === FALSE) return FALSE;
        // add botao
        $Visual->Blocar('<a title="Adicionar Armazem" class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'Transporte/Armazem/Armazens_Add">Adicionar novo Armazem</a><div class="space15"></div>');
        if (is_object($armazens)) $armazens = Array(0=>$armazens);
        if ($armazens !== FALSE && !empty($armazens)) {
            list($table, $i) = Transporte_ArmazemControle::Armazens_Tabela($armazens);
            $Visual->Show_Tabela_DataTable($table);
        } else {   
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Armazem na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Armazens: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;*/
        
        return FALSE;
    }
}
?>