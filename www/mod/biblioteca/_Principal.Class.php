<?php
class biblioteca_Principal implements \Framework\PrincipalInterface
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
     * @uses biblioteca_Controle::$num_Indicados
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
        // Bibliotecas
        $biblioteca_qnt = $Modelo->db->Sql_Contar('Biblioteca');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Biblíoteca', 
            'biblioteca/Biblioteca/Bibliotecas', 
            'folder-open',
            $biblioteca_qnt, 
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
        // Busca Bibliotecas
        $result = self::Busca_Bibliotecas($controle, $Modelo, $Visual, $busca);
        if ($result !== FALSE) {
            $i = $i + $result;
        }
        if (is_int($i) && $i>0) {
            return $i;
        } else {
            return FALSE;
        }
    }
    static function Busca_Bibliotecas($controle, $Modelo, $Visual, $busca) {
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
          'arquivo'                 => '%'.$busca.'%'
        ));
        $i = 0;
        $bibliotecas = $Modelo->db->Sql_Select('Biblioteca', $where);
        if ($bibliotecas === FALSE) return FALSE;
        // add botao
        $Visual->Blocar('<a title="Adicionar Pasta a Biblíoteca" class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas_Add">Adicionar nova Biblíoteca</a><div class="space15"></div>');
        if (is_object($bibliotecas)) $bibliotecas = Array(0=>$bibliotecas);
        if ($bibliotecas !== FALSE && !empty($bibliotecas)) {
            $function = '';
            $table = Array();
            $i = 0;
            if ($raiz !== FALSE && $raiz!=0) {
                $resultado_pasta = $Modelo->db->Sql_Select('Biblioteca', Array('id'=>$raiz),1);
                if ($resultado_pasta === FALSE) {
                    return _Sistema_erroControle::Erro_Fluxo('Essa Pasta não existe:'. $raiz,404);
                }
                $table['Tipo'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$resultado_pasta->parent.'" border="1" class="lajax" data-acao=""><img alt'.__('Voltar para Diretório Anterior').' src="'.WEB_URL.'img'.US.'arquivos'.US.'pastavoltar.png" alt="0" /></a>';
                $table['Nome'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$resultado_pasta->parent.'" border="1" class="lajax" data-acao="">Voltar para a Pasta Anterior</a>';
                $table['Descrição'][$i]        = '';
                $table['Tamanho'][$i]          = '';
                $table['Criador'][$i]          = '';
                $table['Data'][$i]  = '';
                $table['Funções'][$i]          = '';
                ++$i;
            }
            if ($bibliotecas !== FALSE) {
                // Percorre Bibliotecas
                if (is_object($bibliotecas)) $bibliotecas = Array(0=>$bibliotecas);
                reset($bibliotecas);
                if (!empty($bibliotecas)) {
                    $perm_download = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Download');
                    $permissionEdit = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Bibliotecas_Edit');
                    $permissionDelete = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Bibliotecas_Del');

                    foreach ($bibliotecas as &$valor) {
                        if ($valor->tipo==1) {
                            $tipo       =   'pasta';
                            $foto = WEB_URL.'img'.US.'arquivos'.US.$tipo.'.png';
                        } else {
                            $tipo  = \Framework\App\Sistema_Funcoes::Control_Arq_Ext($valor->ext);
                            $endereco = ARQ_PATH.'bibliotecas'.DS.strtolower($valor->arquivo).'.'.$tipo;
                            if (!file_exists($endereco)) {
                                continue;
                            }
                            if (file_exists(WEB_PATH.'img'.US.'arquivos'.US.$tipo.'.png')) {
                                $foto = WEB_URL.'img'.US.'arquivos'.US.$tipo.'.png';
                            } else {
                                $foto = WEB_URL.'img'.US.'arquivos'.US.'desconhecido.png';
                            }
                        }

                        // Tamanho
                        $tamanho = (int) $valor->tamanho;
                        if ($tamanho === 0) {
                            if ($valor->tipo==1) {
                                $tamanho = biblioteca_Controle::Bibliotecas_AtualizaTamanho_Pai($valor);
                            } else {
                                $tamanho = filesize($endereco);
                                $Modelo->db->Sql_Update($valor);
                            }
                        }

                        if ($valor->tipo==1) {
                            $table['Tipo'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$valor->id.'/" border="1" class="lajax" data-acao=""><img src="'.$foto.'" alt="'.__('Abrir Diretório').'" /></a>';
                            $table['Nome'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$valor->id.'/" border="1" class="lajax" data-acao="">'.$valor->nome.'</a>';
                        } else {
                            $table['Tipo'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Download/'.$valor->id.'/" border="1" target="_BLANK"><img src="'.$foto.'" alt="'.__('Fazer Download de Arquivo ').$tipo.'" /></a>';
                            $table['Nome'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Download/'.$valor->id.'/" border="1" target="_BLANK">'.$valor->nome.'</a>';
                        }
                        $table['Descrição'][$i]        = $valor->obs;
                        $table['Tamanho'][$i]          = \Framework\App\Sistema_Funcoes::Tranf_Byte_Otimizado($tamanho);
                        $table['Criador'][$i]          = $valor->usuario2;
                        $table['Data'][$i]             = $valor->log_date_add;

                        if ($valor->tipo==1) {
                            $table['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Pasta'        ,'biblioteca/Biblioteca/Bibliotecas_Edit/'.$valor->id.'/'.$raiz    , ''), $permissionEdit).
                                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Pasta'       ,'biblioteca/Biblioteca/Bibliotecas_Del/'.$valor->id.'/'.$raiz     ,'Deseja realmente deletar essa pasta ?'), $permissionDelete);
                        } else {
                            $table['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Baixar'     ,Array('Download de Arquivo'   ,'biblioteca/Biblioteca/Download/'.$valor->id    , ''), $perm_download).
                                                              $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Arquivo'        ,'biblioteca/Biblioteca/Bibliotecas_Edit/'.$valor->id.'/'.$raiz    , ''), $permissionEdit).
                                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Arquivo'       ,'biblioteca/Biblioteca/Bibliotecas_Del/'.$valor->id.'/'.$raiz     ,'Deseja realmente deletar esse arquivo ?'), $permissionDelete);
                        }
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
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Arquivo/Pasta na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Pasta/Arquivo na Biblíoteca: '.$busca.' ('.$i.')';
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
        // Endereços dos arquivos $bibliotecas_chaves['endereco'] = 'ID';
        $bibliotecas_chaves = Array();
        
        // Carrega Bibliotecas
        $biblioteca = $Modelo->db->Sql_Select('Biblioteca', FALSE,0, '', '*', true, '*'); // Pega Todos os Dados de Bibliotecas -> Até os Deletados.
        if (is_object($biblioteca))  $biblioteca = Array($biblioteca);
        if ($biblioteca === FALSE)     $biblioteca = Array();
        
        // Verifica se Todos tem Download Válido
        if (!empty($biblioteca)) {
            foreach($biblioteca as $valor) {

            }
        }
        
        // Percorre Todos os Arquivos da Biblioteca no SERVIDOR.
        //E verifica se Algum não está sendo usado.
    }
}
?>