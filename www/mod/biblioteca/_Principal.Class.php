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
    static function Home(&$controle, &$Modelo, &$Visual){
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
        // Bibliotecas
        $biblioteca_qnt = $Modelo->db->Sql_Contar('Biblioteca');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Biblíoteca', 
            'biblioteca/Biblioteca/Bibliotecas', 
            'folder-open',
            $biblioteca_qnt, 
            'light-green', 
            false, 
            300
        );
    }
    
    
    /***********************
     * BUSCAS
     */
    static function Busca(&$controle, &$Modelo, &$Visual,$busca){
        $i = 0;
        // Busca Bibliotecas
        $result = self::Busca_Bibliotecas($controle, $Modelo, $Visual, $busca);
        if ($result!==false){
            $i = $i + $result;
        }
        if (is_int($i) && $i>0){
            return $i;
        } else {
            return false;
        }
    }
    static function Busca_Bibliotecas($controle, $Modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
          'arquivo'                 => '%'.$busca.'%'
        ));
        $i = 0;
        $bibliotecas = $Modelo->db->Sql_Select('Biblioteca',$where);
        if ($bibliotecas===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Pasta a Biblíoteca" class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas_Add">Adicionar nova Biblíoteca</a><div class="space15"></div>');
        if (is_object($bibliotecas)) $bibliotecas = Array(0=>$bibliotecas);
        if ($bibliotecas!==false && !empty($bibliotecas)){
            $funcao = '';
            $tabela = Array();
            $i = 0;
            if ($raiz!==false && $raiz!=0){
                $resultado_pasta = $Modelo->db->Sql_Select('Biblioteca', Array('id'=>$raiz),1);
                if ($resultado_pasta===false){
                    return _Sistema_erroControle::Erro_Fluxo('Essa Pasta não existe:'. $raiz,404);
                }
                $tabela['Tipo'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$resultado_pasta->parent.'" border="1" class="lajax" data-acao=""><img alt'.__('Voltar para Diretório Anterior').' src="'.WEB_URL.'img'.US.'arquivos'.US.'pastavoltar.png" alt="0" /></a>';
                $tabela['Nome'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$resultado_pasta->parent.'" border="1" class="lajax" data-acao="">Voltar para a Pasta Anterior</a>';
                $tabela['Descrição'][$i]        = '';
                $tabela['Tamanho'][$i]          = '';
                $tabela['Criador'][$i]          = '';
                $tabela['Data'][$i]  = '';
                $tabela['Funções'][$i]          = '';
                ++$i;
            }
            if ($bibliotecas!==false){
                // Percorre Bibliotecas
                if (is_object($bibliotecas)) $bibliotecas = Array(0=>$bibliotecas);
                reset($bibliotecas);
                if (!empty($bibliotecas)){
                    $perm_download = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Download');
                    $perm_editar = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Bibliotecas_Edit');
                    $perm_del = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Bibliotecas_Del');

                    foreach ($bibliotecas as &$valor) {
                        if ($valor->tipo==1){
                            $tipo       =   'pasta';
                            $foto = WEB_URL.'img'.US.'arquivos'.US.$tipo.'.png';
                        } else {
                            $tipo  = \Framework\App\Sistema_Funcoes::Control_Arq_Ext($valor->ext);
                            $endereco = ARQ_PATH.'bibliotecas'.DS.strtolower($valor->arquivo).'.'.$tipo;
                            if (!file_exists($endereco)){
                                continue;
                            }
                            if (file_exists(WEB_PATH.'img'.US.'arquivos'.US.$tipo.'.png')){
                                $foto = WEB_URL.'img'.US.'arquivos'.US.$tipo.'.png';
                            } else {
                                $foto = WEB_URL.'img'.US.'arquivos'.US.'desconhecido.png';
                            }
                        }

                        // Tamanho
                        $tamanho = (int) $valor->tamanho;
                        if ($tamanho === 0){
                            if ($valor->tipo==1){
                                $tamanho = biblioteca_Controle::Bibliotecas_AtualizaTamanho_Pai($valor);
                            } else {
                                $tamanho = filesize($endereco);
                                $Modelo->db->Sql_Update($valor);
                            }
                        }

                        if ($valor->tipo==1){
                            $tabela['Tipo'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$valor->id.'/" border="1" class="lajax" data-acao=""><img src="'.$foto.'" alt="'.__('Abrir Diretório').'" /></a>';
                            $tabela['Nome'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$valor->id.'/" border="1" class="lajax" data-acao="">'.$valor->nome.'</a>';
                        } else {
                            $tabela['Tipo'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Download/'.$valor->id.'/" border="1" target="_BLANK"><img src="'.$foto.'" alt="'.__('Fazer Download de Arquivo ').$tipo.'" /></a>';
                            $tabela['Nome'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Download/'.$valor->id.'/" border="1" target="_BLANK">'.$valor->nome.'</a>';
                        }
                        $tabela['Descrição'][$i]        = $valor->obs;
                        $tabela['Tamanho'][$i]          = \Framework\App\Sistema_Funcoes::Tranf_Byte_Otimizado($tamanho);
                        $tabela['Criador'][$i]          = $valor->usuario2;
                        $tabela['Data'][$i]             = $valor->log_date_add;

                        if ($valor->tipo==1){
                            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Pasta'        ,'biblioteca/Biblioteca/Bibliotecas_Edit/'.$valor->id.'/'.$raiz    ,''),$perm_editar).
                                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Pasta'       ,'biblioteca/Biblioteca/Bibliotecas_Del/'.$valor->id.'/'.$raiz     ,'Deseja realmente deletar essa pasta ?'),$perm_del);
                        } else {
                            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Baixar'     ,Array('Download de Arquivo'   ,'biblioteca/Biblioteca/Download/'.$valor->id    ,''),$perm_download).
                                                              $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Arquivo'        ,'biblioteca/Biblioteca/Bibliotecas_Edit/'.$valor->id.'/'.$raiz    ,''),$perm_editar).
                                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Arquivo'       ,'biblioteca/Biblioteca/Bibliotecas_Del/'.$valor->id.'/'.$raiz     ,'Deseja realmente deletar esse arquivo ?'),$perm_del);
                        }
                        $funcao .= $tabela['Funções'][$i];
                        ++$i;
                    }
                }
            }
            if ($funcao===''){
                unset($tabela['Funções']);
            }
            // Desconta Primeiro Registro
            if ($raiz!==false && $raiz!=0){
                $i = $i-1;
            }
            // Retorna List
            $Visual->Show_Tabela_DataTable($tabela);
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
    public static function Manutencao(&$log){
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        // Endereços dos arquivos $bibliotecas_chaves['endereco'] = 'ID';
        $bibliotecas_chaves = Array();
        
        // Carrega Bibliotecas
        $biblioteca = $Modelo->db->Sql_Select('Biblioteca',false,0, '', '*', true, '*'); // Pega Todos os Dados de Bibliotecas -> Até os Deletados.
        if (is_object($biblioteca))  $biblioteca = Array($biblioteca);
        if ($biblioteca===false)     $biblioteca = Array();
        
        // Verifica se Todos tem Download Válido
        if (!empty($biblioteca)){
            foreach($biblioteca as $valor){

            }
        }
        
        // Percorre Todos os Arquivos da Biblioteca no SERVIDOR.
        //E verifica se Algum não está sendo usado.
    }
}
?>