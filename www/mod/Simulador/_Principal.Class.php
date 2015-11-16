<?php
class Simulador_Principal implements \Framework\PrincipalInterface
{
    /**
     * Função Home para o modulo mensagem aparecer na pagina HOME
     * 
     * @name Home
     * @access public
     * @static
     * 
     * @param Class &$controle Classe Controle Atual passada por Ponteiro
     * @param Class &$Modelo Modelo Passado por Ponteiro
     * @param Class &$Visual Visual Passado por Ponteiro
     *
     * @uses tag_Controle::$num_Indicados
     * 
     * @return void 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Home(&$controle, &$Modelo, &$Visual) {
        self::Widgets();
        return TRUE;
    }
    /**
     * 
     * @return boolean
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Config() {
        return FALSE;
    }
    
    static function Relatorio($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    
    static function Estatistica($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Widgets() {
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        // Tags
        $tag_qnt = $Modelo->db->Sql_Contar('Simulador_Tag');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Tags/Caracteristicas', 
            'Simulador/Tag/Tags', 
            'folder-open',
            $tag_qnt, 
            'light-green', 
            FALSE, 
            300
        );
    }
    
    
    /***********************
     * BUSCAS
     */
    static function Busca(&$controle, &$Modelo, &$Visual, $busca) {
        $i = 0;
        // Busca Tags
        $result = self::Busca_Tags($controle, $Modelo, $Visual, $busca);
        if ($result !== FALSE) {
            $i = $i + $result;
        }
        if (is_int($i) && $i>0) {
            return $i;
        } else {
            return FALSE;
        }
    }
    static function Busca_Tags($controle, $Modelo, $Visual, $busca) {
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
          'arquivo'                 => '%'.$busca.'%'
        ));
        $i = 0;
        $tags = $Modelo->db->Sql_Select('Simulador_Tag', $where);
        if ($tags === FALSE) return FALSE;
        // add botao
        $Visual->Blocar('<a title="Adicionar Tag" class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'Simulador/Tag/Tags_Add">Adicionar nova Tag</a><div class="space15"></div>');
        if (is_object($tags)) $tags = Array(0=>$tags);
        if ($tags !== FALSE && !empty($tags)) {
            $function = '';
            $table = Array();
            $i = 0;
            if ($tags !== FALSE) {
                // Percorre Tags
                if (is_object($tags)) $tags = Array(0=>$tags);
                reset($tags);
                if (!empty($tags)) {
                    $perm_download = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Simulador/Tag/Download');
                    $permissionEdit = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Edit');
                    $permissionDelete = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Del');

                    foreach ($tags as &$valor) {

                        $table['Id'][$i]    = $valor->id;
                        $table['Nome'][$i]      = $valor->nome;
                        $table['Tipo de Resultado'][$i]      = $valor->resultado_tipo;
                        $table['Observação'][$i]      = $valor->obs;
                        $table['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Pasta'        ,'Simulador/Tag/Tags_Edit/'.$valor->id.'/'.$raiz    , ''), $permissionEdit).
                                                          $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Pasta'       ,'Simulador/Tag/Tags_Del/'.$valor->id.'/'.$raiz     ,'Deseja realmente deletar essa Tag ?'), $permissionDelete);
                        
                        $function .= $table['Funções'][$i];
                        ++$i;
                    }
                }
            }
            if ($function==='') {
                unset($table['Funções']);
            }
            // Desconta Primeiro Registro
            if ($raiz !== FALSE && $raiz!=0) {
                $i = $i-1;
            }
            // Retorna List
            $Visual->Show_Tabela_DataTable($table);
        } else {        
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Tag de Simulador na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Tags: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    /**
     * Classe de Manutenção do Sistema
     * #update Acabar de Fazer
     * 
     * @param Array $log Sempre será Adicionado Novos Arrays com Indice ['Nome'] e ['Descricao']
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Manutencao(&$log) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        // Endereços dos arquivos $tags_chaves['endereco'] = 'ID';
        return TRUE;
    }
}
?>