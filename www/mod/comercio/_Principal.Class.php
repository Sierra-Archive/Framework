<?php
class comercio_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    static function Home(&$controle,    &$Modelo, &$Visual) {
        self::Widgets();
    }
    static function Busca(&$controle, &$Modelo, &$Visual, $busca) {
        return false;
    }
    static function Config() {
        return false;
    }
    
    static function Relatorio($data_inicio, $data_final, $filtro = false) {
        return false;
    }
    
    static function Estatistica($data_inicio, $data_final, $filtro = false) {
        return false;
    }
    public static function Widgets() {
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        
        // Fornecedor
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Fornecedor')) {
            $fornecedor_qnt = $Modelo->db->Sql_Contar('Comercio_Fornecedor');
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                'Fornecedores', 
                'comercio/Fornecedor/Fornecedores', 
                'truck', 
                $fornecedor_qnt, 
                'block-yellow', 
                false, 
                150
            );
        }
        
        
        // Produto
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto')) {
            // Calculo Produto
            $produto_qnt = $Modelo->db->Sql_Contar('Comercio_Produto');
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
               'Produtos',
               'comercio/Produto/Produtos/',
               'tags',
               $produto_qnt,
               'block-azulescuro',
               false,
               113
            );
            if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Linha_Widget')) {
                // Calculo Linha
                $linha_qnt = $Modelo->db->Sql_Contar('Comercio_Linha');
               // Adiciona Widget a Pagina Inicial
                \Framework\App\Visual::Layoult_Home_Widgets_Add(
                    'Linhas',
                    'comercio/Linha/Linhas/',
                    'tag',
                    $linha_qnt,
                    'light-green',
                    false,
                    112
                );
            }
        }
        //self::maintenance(0,3,0);
        
        
    }
    
    public static function Release(&$compatibility,&$improvement,&$bug, &$melhoria, &$melhoria_qnt, &$bugs, &$bugs_qnt) {
        if ($versao<0.4) {
            $melhoria .= "\n".'- '.__('Histórico de Alteração de Status em Propostas/Os, status antigos talvez não estejam listados.');
            ++$melhoria_qnt;
            $melhoria .= "\n".'- '.__('Relatório de Movimentação de Status em Propostas/Os'); ++$melhoria_qnt;
            //$bugs .= "\n".'- Responsividade: Melhoria'; ++$bugs_qnt;
            //$bugs .= "\n".'- Outros: Outros Bugs Consertados'; ++$bugs_qnt;
        }
    }
    /**
     * Classe de Manutenção do Sistema
     * #update Acabar de Fazer
     * 
     * @param Array $log Sempre será Adicionado Novos Arrays com Indice ['Nome'] e ['Descricao']
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public static function maintenance($compatibility,$improvement,$bug) {
        $register = &\Framework\App\Registro::getInstacia();
        $model = &$Registro->_Modelo;
        $view = &$Registro->_Visual;
        $total = 0;
        
        // Cria Historico de Status para Antigas Propostas/OS
        if($compatibility===0 && $improvement<4){
            //Coloca Todas as Alterações no Novo Banco de dados
            $searchPropostas = \Framework\App\Registro::getInstacia()->_Conexao->Sql_Select(
                'Comercio_Proposta',
                '({sigla}propostaReferencia=\'0\' OR {sigla}propostaReferencia=\'\' OR {sigla}propostaReferencia is NULL) AND '.
                '({sigla}propostaNewId=\'0\' OR {sigla}propostaNewId=\'\' OR {sigla}propostaNewId is NULL OR {sigla}propostaNewId=\'false\')',
                100
            );
            if(is_object($searchPropostas)){
                $searchPropostas = Array($searchPropostas);
            }
            if($searchPropostas!==false){
                foreach ($searchPropostas as &$value){
                    $value->propostaNewId = $value->id.' - 1';
                    $value->propostaReferencia = '0';
                    $total = $total + 1;
                    // Add Novo Status
                    if(\Framework\App\Registro::getInstacia()->_Conexao->Sql_Select(
                        'Comercio_Proposta_Status',
                        '{sigla}proposta=\''.$value->id.'\''.
                        ' AND {sigla}data=\''.$value->log_date_add.'\''.
                        ' AND {sigla}status=\'0\'',
                        1
                    )===false){
                        
                        $newStatus = new Comercio_Proposta_Status_DAO();
                        $newStatus->proposta = $value->id;
                        $newStatus->propostaNome = $value->propostaNewId;
                        $newStatus->cuidados = $value->cuidados;
                        $newStatus->cliente = $value->cliente;
                        $newStatus->data = $value->log_date_add;
                        $newStatus->status = '0';
                        \Framework\App\Registro::getInstacia()->_Conexao->Sql_Insert(
                            $newStatus
                        );
                    }
                    
                    //Procura Mov INt
                    
                    $searchMovInt = \Framework\App\Registro::getInstacia()->_Conexao->Sql_Select(
                        'Financeiro_Pagamento_Interno',
                        '{sigla}motivo=\'comercio_Proposta\' AND {sigla}motivoid=\''.$value->id.'\''
                    );
                    if(is_object($searchMovInt)){
                        if(\Framework\App\Registro::getInstacia()->_Conexao->Sql_Select(
                            'Comercio_Proposta_Status',
                            '{sigla}proposta=\''.$value->id.'\''.
                            ' AND {sigla}data=\''.$value->log_date_add.'\''.
                            ' AND {sigla}status=\'2\'',
                            1
                        )===false){
                            $newStatus = new Comercio_Proposta_Status_DAO();
                            $newStatus->proposta = $value->id;
                            $newStatus->propostaNome = $value->propostaNewId;
                            $newStatus->cuidados = $value->cuidados;
                            $newStatus->cliente = $value->cliente;
                            $newStatus->data = $searchMovInt->log_date_add;
                            $newStatus->status = '2';
                            \Framework\App\Registro::getInstacia()->_Conexao->Sql_Insert(
                                $newStatus
                            );
                        }
                    }
                    
                    if($value->status!=0 && $value->status!=2){
                        if(\Framework\App\Registro::getInstacia()->_Conexao->Sql_Select(
                            'Comercio_Proposta_Status',
                            '{sigla}proposta=\''.$value->id.'\''.
                            ' AND {sigla}data=\''.$value->log_date_add.'\''.
                            ' AND {sigla}status=\''.$value->status.'\'',
                            1
                        )===false){
                            $newStatus = new Comercio_Proposta_Status_DAO();
                            $newStatus->proposta = $value->id;
                            $newStatus->propostaNome = $value->propostaNewId;
                            $newStatus->cuidados = $value->cuidados;
                            $newStatus->cliente = $value->cliente;
                            $newStatus->data = $value->log_date_edit;
                            $newStatus->status = $value->status;
                            \Framework\App\Registro::getInstacia()->_Conexao->Sql_Insert(
                                $newStatus
                            );
                        }
                    }
                }
                // Atualiza Propostas
                \Framework\App\Registro::getInstacia()->_Conexao->Sql_Update(
                    $searchPropostas
                );
            }
            
        }
        
        // Endereços dos arquivos $tags_chaves['endereco'] = 'ID';
        if($total===0){
            return true;
        } else {
            return false;
        }
    }
}
?>