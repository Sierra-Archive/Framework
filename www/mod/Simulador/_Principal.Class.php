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
    static function Home(&$controle, &$modelo, &$Visual){
        self::Widgets();
        return true;
    }
    /**
     * 
     * @return boolean
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Config(){
        return false;
    }
    
    static function Relatorio($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    static function Estatistica($data_inicio,$data_final,$filtro=false){
        return false;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Widgets(){
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
            false, 
            300
        );
    }
    
    
    /***********************
     * BUSCAS
     */
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        $i = 0;
        // Busca Tags
        $result = self::Busca_Tags($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        if(is_int($i) && $i>0){
            return $i;
        }else{
            return false;
        }
    }
    static function Busca_Tags($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
          'arquivo'                 => '%'.$busca.'%'
        ));
        $i = 0;
        $tags = $Modelo->db->Sql_Select('Simulador_Tag',$where);
        if($tags===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Tag" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Simulador/Tag/Tags_Add">Adicionar nova Tag</a><div class="space15"></div>');
        if(is_object($tags)) $tags = Array(0=>$tags);
        if($tags!==false && !empty($tags)){
            $funcao = '';
            $tabela = Array();
            $i = 0;
            if($tags!==false){
                // Percorre Tags
                if(is_object($tags)) $tags = Array(0=>$tags);
                reset($tags);
                if(!empty($tags)){
                    $perm_download = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Simulador/Tag/Download');
                    $perm_editar = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Edit');
                    $perm_del = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Del');

                    foreach ($tags as &$valor) {

                        $tabela['Id'][$i]    = $valor->id;
                        $tabela['Nome'][$i]      = $valor->nome;
                        $tabela['Tipo de Resultado'][$i]      = $valor->resultado_tipo;
                        $tabela['Observação'][$i]      = $valor->obs;
                        $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Pasta'        ,'Simulador/Tag/Tags_Edit/'.$valor->id.'/'.$raiz    ,''),$perm_editar).
                                                          $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Pasta'       ,'Simulador/Tag/Tags_Del/'.$valor->id.'/'.$raiz     ,'Deseja realmente deletar essa Tag ?'),$perm_del);
                        
                        $funcao .= $tabela['Funções'][$i];
                        ++$i;
                    }
                }
            }
            if($funcao===''){
                unset($tabela['Funções']);
            }
            // Desconta Primeiro Registro
            if($raiz!==false && $raiz!=0){
                $i = $i-1;
            }
            // Retorna List
            $Visual->Show_Tabela_DataTable($tabela);
        }else{        
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
    public static function Manutencao(&$log){
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        // Endereços dos arquivos $tags_chaves['endereco'] = 'ID';
        return true;
    }
}
?>