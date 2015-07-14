<?php

class Locomocao_EntregaControle extends Locomocao_Controle
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Main(){
        return false;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entregas($tipobloco='Unico'){
        $this->Endereco_Entrega_Entrega(false);
        
        $tabela_colunas[] = __('Id');
        $tabela_colunas[] = __('Motoboy');
        $tabela_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'Locomocao/Entrega/Entregas');

        $titulo = __('Listagem de Entregas').' (<span id="DataTable_Contador">0</span>)';
        $bt_add = Array("link"=>"Locomocao/Entrega/Entregas_Add",'icon'=>'add','nome'=>__('Adicionar Entrega'));
        if($tipobloco==='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,$bt_add);
        }else if($tipobloco==='Maior'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',10,$bt_add);
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo,'',10,$bt_add);
        }
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Entregas'));
    }
    
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entregas_Add(){
        self::Endereco_Entrega(true);
        // Nomes
        $titulo             = __('Entrega');
        $titulo_plural      = __('Entregas');
        $titulo_unico       = 'Entregas';
        // Carrega Config
        $titulo1    = 'Adicionar '.$titulo;
        $titulo2    = 'Salvar '.$titulo;
        $formid     = 'formLocomocao_Entrega_'.$titulo_unico;
        $formbt     = __('Salvar');
        $formlink   = 'Locomocao/Entrega/Entregas_Add2/';
        $campos = Locomocao_Entrega_DAO::Get_Colunas();
        //self::Campos_Deletar($campos);
        
        $this->Entrega_Atualizar_Valor_Dinamico_Janela($formid);

        
        // Chama Formulario
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,false,'left');
        
    }
    /**
     * Pega uma Entrega/Os e Calcula o seu valor
     * @param type $identificador
     * @return boolean
     */
    private function Entrega_Atualizar_Valor(&$identificador){
        if(!is_object($identificador)){
            return false;
        }
        
        // Zera Valor
        $valortotal = 0.0;        
        
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entrega_ValorFinal')){
            
            // Pega o Tipo
            if($identificador->propostatipo==1){
                $identificador->propostatipo=1;

                // Captura o Serviço de Instalaçao
                $instalacao  = $this->_Modelo->db->Sql_Select(
                    'Locomocao_Entrega_ServicoInstalacao', 
                    Array(
                        'proposta'     =>  $identificador->id
                    )
                );
                // Pega os Valores do Serviço de Instalaçao
                if($instalacao!==false){
                    if(is_object($instalacao)) $instalacao = Array($instalacao);
                    foreach($instalacao as &$valor){
                        // Captura Preço do Gas
                        $instalacao_btu  = $this->_Modelo->db->Sql_Select(
                            'Locomocao_Servicos_Btu', 
                            Array(
                                'id'           =>  $valor->btu
                            ),
                            1
                        );
                        // Adiciona Valor da Linha para acima de 5 metros
                        if($valor->distancia>5){
                            $valortotal =   $valortotal + (Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_btu->valor_linha)*($valor->distancia-5))
                                            + \Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_btu->valor_gas);
                        }
                        // Add valor do Ar e Gas
                        $valortotal =   $valortotal
                                        //+ \Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_btu->valor_gas)
                                        + \Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_btu->valor_ar);

                        // Captura Preço do SUPORTE
                        $instalacao_suporte  = $this->_Modelo->db->Sql_Select(
                            'Locomocao_Servicos_Suporte', 
                            Array(
                                'id'            =>  $valor->suporte
                            ),
                            1
                        );
                        $valortotal = $valortotal + \Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_suporte->valor);
                    }
                }

                // Captura o Serviço de Instalaçao
                $produto  = $this->_Modelo->db->Sql_Select(
                    'Locomocao_Entrega_Produto', 
                    Array(
                        'proposta'     =>  $identificador->id
                    )
                );
                // Pega os Valores do Serviço de Instalaçao
                if($produto!==false){
                    if(is_object($produto)) $produto = Array($produto);
                    foreach($produto as &$valor){
                        // Captura Preço do SUPORTE
                        $produto_registro  = $this->_Modelo->db->Sql_Select(
                            'Locomocao_Produto', 
                            Array(
                                'id'            =>  $valor->produto
                            ),
                            1
                        );
                        if(is_object($produto_registro) && $produto_registro->preco!=NULL){
                            // Add valor do Produto
                            $valortotal =   $valortotal
                                            + (Framework\App\Sistema_Funcoes::Tranf_Real_Float($produto_registro->preco)*$valor->prod_qnt);
                        }
                    }
                }


            }else{
                $identificador->propostatipo=0;
                // Captura Tipo de Serviço
                /* NAO TEM MAIS MUDANCA DE VALOR COM SERVICOTIPO
                 * $servicotipo  = $this->_Modelo->db->Sql_Select(
                    'Locomocao_Entrega_ServicoTipo', 
                    Array(
                        'proposta'     =>  $identificador->id
                    )
                );
                // Pega os Valores do Tipo de Serviço
                if($servicotipo!==false){
                    if(is_object($servicotipo)) $servicotipo = Array($servicotipo);
                    foreach($servicotipo as &$valor){
                        $valortotal = $valortotal + $valor->diarias_qnt*Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor->diarias_valor);
                    }
                }*/

                // Captura o Serviço
                $servico  = $this->_Modelo->db->Sql_Select(
                    'Locomocao_Entrega_Servico', 
                    Array(
                        'proposta'     =>  $identificador->id
                    )
                );
                // Pega os Valores do Serviço
                if($servico!==false){
                    if(is_object($servico)) $servico = Array($servico);
                    foreach($servico as &$valor){
                        // Captura Preço do SErviço
                        $servico2  = $this->_Modelo->db->Sql_Select(
                            'Locomocao_Servicos_Servico', 
                            Array(
                                'id'     =>  $valor->servico
                            ),
                            1
                        );
                        if($servico2===false)                        continue;
                        $valortotal = $valortotal + $valor->qnt*Framework\App\Sistema_Funcoes::Tranf_Real_Float($servico2->preco);
                    }
                }

            }

            // SE tiver Mao de Obra Calcula e Soma ao Custo
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entregas_MaodeObra')){
                $valor_maodeobra_total = 0;
                // Captura o Serviço
                $maodeobra  = $this->_Modelo->db->Sql_Select(
                    'Locomocao_Entrega_MaodeObra', 
                    Array(
                        'proposta'     =>  $identificador->id
                    )
                );
                // Pega os Valores do Serviço
                if($maodeobra!==false){
                    if(is_object($maodeobra)) $maodeobra = Array($maodeobra);
                    foreach($maodeobra as &$valor){
                        $valor_maodeobra = $valor->maodeobra_qnt*$valor->maodeobra_dias*
                            (
                                \Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor->maodeobra_diaria)+
                                \Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor->maodeobra_depreciacao)+
                                \Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor->maodeobra_passagem)+
                                \Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor->maodeobra_alimentacao)
                            );
                        $valor_maodeobra_total = $valor_maodeobra_total + $valor_maodeobra;
                    }
                }
                $valortotal = $valortotal+$valor_maodeobra_total;
            }
        
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entrega_ValorExtra')!==false){
                $valortotal = $valortotal+Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor->valor_extra);
            }
            
            // Calcula Lucro
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entrega_Lucro')){
                $lucro    = \Framework\App\Sistema_Funcoes::Tranf_Porc_Float($identificador->pagar_lucro);
                $valortotal = $valortotal+($lucro*$valortotal);
            }
            // Calcula Desconto
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entrega_Desconto')){
                $desconto    = \Framework\App\Sistema_Funcoes::Tranf_Porc_Float($identificador->pagar_desconto);
                $valortotal = $valortotal-($desconto*$valortotal);
            }
            // Converte Valor Total para Real e Imprime     
        }else{
            $valortotal = \Framework\App\Sistema_Funcoes::Tranf_Real_Float($identificador->valor_fixo);
        }
        
        /*// Se tiver Comissao Add
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entrega_Comissao')!==false){
            $comissao = \Framework\App\Sistema_Funcoes::Tranf_Porc_Float($identificador->comissao);
            $valortotal = $valortotal+($comissao*$valortotal);
        }   
        
        // Se tiver Imposto Add
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entregas_Imposto')!==false){
            $imposto = \Framework\App\Sistema_Funcoes::Tranf_Porc_Float($identificador->imposto);
            $valortotal = $valortotal+($imposto*$valortotal);
        }*/
        
        // Atualiza Valor Total
        $identificador->valor = \Framework\App\Sistema_Funcoes::Tranf_Float_Real($valortotal);
        $this->_Modelo->db->Sql_Update($identificador);
    }
    /**
     * 
     * @param type $time
     * @return boolean
     */
    public function Entrega_Atualizar_Valor_Dinamico($time){
        if(!isset($_POST['status'])) return false;
        
        $html = '';
        
        
        
        // Zera Valor
        $valortotal = 0.0;
        $distanciatotal = 0.0;
        $tempototal = 0.0;

        // Pega o Tipo
        if($propostatipo==1){
            $propostatipo=1;
            
            // Pega os BTUS de instalacao
            $instalacao = \anti_injection($_POST['btu']);
            // Pega os Valores do Serviço de Instalaçao
            if(!empty($instalacao)){
                foreach($instalacao as &$valor){
                    $valor = (int) $valor;
                    if($valor===0 || $valor===NULL) continue;
                    // Captura Preço do Gas
                    $instalacao_btu  = $this->_Modelo->db->Sql_Select(
                        'Locomocao_Servicos_Btu', 
                        Array(
                            'id'           =>  $valor
                        ),
                        1
                    );
                    if($instalacao_btu===false) continue;
                    $distancia  = (int) $_POST['distancia_'.$valor];
                    $suporte    = (int) $_POST['suporte_'.$valor];
                    // Adiciona Valor da Linha para acima de 5 metros
                    if($distancia>5){
                        $valortotal =   $valortotal + (Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_btu->valor_linha)*($distancia-5))
                                        + \Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_btu->valor_gas);
                    }
                    // Add valor do Ar e Gas
                    $valortotal =   $valortotal
                                    //+ \Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_btu->valor_gas)
                                    + \Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_btu->valor_ar);
                    
                    // Captura Preço do SUPORTE
                    $instalacao_suporte  = $this->_Modelo->db->Sql_Select(
                        'Locomocao_Servicos_Suporte', 
                        Array(
                            'id'            =>  $suporte
                        ),
                        1
                    );
                    if($instalacao_suporte===false) continue;
                    $valortotal = $valortotal + \Framework\App\Sistema_Funcoes::Tranf_Real_Float($instalacao_suporte->valor);
                }
            }
            
            // Produtos
            $produto = \anti_injection($_POST['produto']);
            // Pega os Valores do Serviço de Instalaçao
            if(!empty($produto)){
                foreach($produto as &$valor){
                    $valor = (int) $valor;
                    if($valor===0 || $valor===NULL) continue;
                    // Captura Preço do SUPORTE
                    $produto_registro  = $this->_Modelo->db->Sql_Select(
                        'Locomocao_Produto', 
                        Array(
                            'id'            =>  $valor
                        ),
                        1
                    );
                    if(is_object($produto_registro) && $produto_registro->preco!=NULL){
                        $prod_qnt    = (int) $_POST['prod_qnt_'.$valor];
                        //$prod_preco  = \anti_injection($_POST['prod_preco_'.$valor]);
                        // Add valor do Produto
                        $valortotal =   $valortotal
                                        + (Framework\App\Sistema_Funcoes::Tranf_Real_Float($produto_registro->preco)*$prod_qnt);
                    }
                }
            }
            
            
        }else{
            $propostatipo=0;
            // Captura Tipo de Serviço
            // Nao Altera Mais o Valor
            /*if(isset($_POST['servicotipo'])){
                $servicotipo = \anti_injection($_POST['servicotipo']);
                // Pega os Valores do Tipo de Serviço
                if(!empty($servicotipo)){
                    foreach($servicotipo as &$valor){
                        $valor = (int) $valor;
                        if($valor===0 || $valor===NULL) continue;
                        $diarias_qnt = (int) $_POST['diarias_qnt_'.$valor];
                        $diarias_valor = \anti_injection($_POST['diarias_valor_'.$valor]);
                        $valortotal = $valortotal + $diarias_qnt*Framework\App\Sistema_Funcoes::Tranf_Real_Float($diarias_valor);
                    }
                }
            }*/

            // Captura o Serviço
            if(isset($_POST['servico'])){
                $servico = \anti_injection($_POST['servico']);
                // Pega os Valores do Serviço
                if(!empty($servico)){
                    foreach($servico as &$valor){
                        $valor = (int) $valor;
                        if($valor===0 || $valor===NULL) continue;
                        // Captura Preço do SErviço
                        $servico2  = $this->_Modelo->db->Sql_Select(
                            'Locomocao_Servicos_Servico', 
                            Array(
                                'id'     =>  $valor
                            ),
                            1
                        );
                        $qnt = (int) $_POST['qnt_'.$valor];

                        $valortotal = $valortotal + $qnt*Framework\App\Sistema_Funcoes::Tranf_Real_Float($servico2->preco);
                    }
                }
            }

        }
        
        
        // SE tiver Mao de Obra Calcula e Soma ao Custo
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entregas_MaodeObra')){
            $valor_maodeobra_total = 0;
            if(isset($_POST['grupo'])){
                $maodeobra = \anti_injection($_POST['grupo']);
                // Pega os Valores do Tipo de Serviço
                if(!empty($maodeobra)){
                    foreach($maodeobra as &$valor){
                        $valor = (int) $valor;
                        if($valor===0 || $valor===NULL) continue;
                        
                        
                        $maodeobra_qnt          = (int) $_POST['maodeobra_qnt_'.$valor];
                        $maodeobra_dias         = (int) $_POST['maodeobra_dias_'.$valor];
                        $maodeobra_diaria       = \anti_injection($_POST['maodeobra_diaria_'.$valor]);
                        $maodeobra_depreciacao  = \anti_injection($_POST['maodeobra_depreciacao_'.$valor]);
                        $maodeobra_passagem     = \anti_injection($_POST['maodeobra_passagem_'.$valor]);
                        $maodeobra_alimentacao  = \anti_injection($_POST['maodeobra_alimentacao_'.$valor]);
                        
                        $valor_maodeobra = $maodeobra_qnt*$maodeobra_dias*
                            (
                                \Framework\App\Sistema_Funcoes::Tranf_Real_Float($maodeobra_diaria)+
                                \Framework\App\Sistema_Funcoes::Tranf_Real_Float($maodeobra_depreciacao)+
                                \Framework\App\Sistema_Funcoes::Tranf_Real_Float($maodeobra_passagem)+
                                \Framework\App\Sistema_Funcoes::Tranf_Real_Float($maodeobra_alimentacao)
                            );
                        
                        $valor_maodeobra_total = $valor_maodeobra_total + $valor_maodeobra;
                    }
                }
            }
            $html .= '<b>Custo da Mão de Obra:</b> '.Framework\App\Sistema_Funcoes::Tranf_Float_Real($valor_maodeobra_total).'<br>';
            $valortotal = $valortotal+$valor_maodeobra_total;
        }
        
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entrega_ValorExtra')!==false){
            $valortotal = $valortotal+Framework\App\Sistema_Funcoes::Tranf_Real_Float(\anti_injection($_POST['valor_extra']));
            $html .= '<b>Custo Extra:</b> '.(\anti_injection($_POST['valor_extra'])?\anti_injection($_POST['valor_extra']):'R$ 0,00').'<br>';
        }
        
        // Calcula Valor de Custo da Entrega
        $html .= '<b>Valor Total de Custo:</b> '.Framework\App\Sistema_Funcoes::Tranf_Float_Real($valortotal).'<br><br>';
        
        
        
        $valortotal = \Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor_total_form);
        $html .= '<b>Valor Total:</b> '.  $valor_total_form.'<br>';
        
        // Se tiver IMPOSTO Add
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entregas_Imposto')!==false){
            $imposto = \Framework\App\Sistema_Funcoes::Tranf_Porc_Float(\anti_injection($_POST['imposto']));
            $html .= '<b>Imposto:</b> '.Framework\App\Sistema_Funcoes::Tranf_Float_Real($imposto*$valortotal).'<br>';
            $valortotal_semimposto = $valortotal-($imposto*$valortotal);
        }   
        
        // Se tiver Comissao Add
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Locomocao_Entrega_Comissao')!==false){
            $comissao = \Framework\App\Sistema_Funcoes::Tranf_Porc_Float(\anti_injection($_POST['comissao']));
            $html .= '<b>Comissão:</b> '.Framework\App\Sistema_Funcoes::Tranf_Float_Real($comissao*$valortotal_semimposto).'<br>';
            //$valortotal = $valortotal+($comissao*$valortotal);
        }        
        
        
        // Json
        $conteudo = array(
            'location'  =>  '#valortemporario'.$time,
            'js'        =>  '',
            'html'      =>  $html
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        $this->_Visual->Json_Info_Update('Historico', false);  
        return true;
    }
    /**
     * 
     * @param type $form_id
     * @param type $valor
     */
    public function Entrega_Atualizar_Valor_Dinamico_Janela($form_id,$recalcular=false){
        $time = round(TEMPO_COMECO);
        if($recalcular===false){
            $valor ='R$ 0,00';
            $tempo ='0 Min';
            $distancia ='0 Km';
        }else{
            $valor =__('Calculando');
            $tempo =__('Calculando');
            $distancia =__('Calculando');
            $this->_Visual->Javascript_Executar('params'.$time.'=$(\'#'.$form_id.'\').serialize();'
                            . 'Sierra.Modelo_Ajax_Chamar(\'Locomocao/Entrega/Entrega_Atualizar_Valor_Dinamico/'.$time.'\',params'.$time.',\'POST\',true,false,false);');
        }
        // Janela De Valor Temporario
        $this->_Visual->Javascript_Executar('function Valor_Dinamico_Rodar() {var params'.$time.' = $(\'#'.$form_id.'\').serialize();'
            . 'var intervalo'.$time.' = window.setInterval(function () {console.log(\'SierraTecnologia\',params'.$time.');'
                . 'if($(\'#'.$form_id.'\').length){'
                    . 'if(params'.$time.'!==$(\'#'.$form_id.'\').serialize()){'
                        . 'params'.$time.'=$(\'#'.$form_id.'\').serialize();'
                        . 'Sierra.Modelo_Ajax_Chamar(\'Locomocao/Entrega/Entrega_Atualizar_Valor_Dinamico/'.$time.'\',params'.$time.',\'POST\',true,false,false);'
                    . '}'
                . '}else{'
                    . 'clearInterval(intervalo'.$time.');'
                . '}'
            . '}, 1000);} Valor_Dinamico_Rodar();');
        
        // Insere Informação
        $this->_Visual->Blocar(/*'<script LANGUAGE="JavaScript" TYPE="text/javascript">'
            . 
            . '</script>'
            . */'<span id="valortemporario'.$time.'">'.
                '<b>Distância Total:</b> '.$distancia.'<br>'.
                '<b>Tempo Total:</b> '.$tempo.
                //'<b>Valor Total:</b> '.$valor.
                '</span>'
            . '<br>');
        $this->_Visual->Bloco_Menor_CriaJanela(__('Informações Temporárias'));
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entregas_Add2($tema='Entregas'){
        // Nomes
        $titulo             = __('Entrega');
        $titulo_plural      = __('Entregas');
        $titulo_unico       = 'Entregas';
        $titulo     = $titulo.' Adicionada com Sucesso';
        $dao        = 'Locomocao_Entrega';
        $funcao     = false;
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = $titulo.' cadastrada com sucesso.';
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        if($sucesso===true){
            // Pega o ID
            $identificador  = $this->_Modelo->db->Sql_Select('Locomocao_Entrega', Array(),1,'id DESC');
            $this->Entrega_Atualizar_Valor($identificador);
        }
        // Recarrega
        $this->Entregas($tema);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entregas_Edit($id){
        $this->Endereco_Entrega_Entrega();
        // Carrega Entrega
        $titulo1    = __('Editar Entrega').' (#'.$id.')';
        $titulo2    = __('Alteração de Entrega');
        $formid     = 'formLocomocao_EntregaC_EntregaEdit';
        $formbt     = __('Alterar Entrega');
        $formlink   = 'Locomocao/Entrega/Entregas_Edit2/'.$id;
        $editar     = Array('Locomocao_Entrega',$id);
        $campos = Locomocao_Entrega_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entregas_Edit2($id){
        $id = (int) $id;
        $titulo     = __('Entrega Alterada com Sucesso');
        $dao        = Array('Locomocao_Entrega',$id);
        $funcao     = '$this->Entregas();';
        $sucesso1   = __('Entrega Alterada com Sucesso');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entregas_Del($id){
        
        
    	$id = (int) $id;
        // Puxa menu e deleta
        $menu    =  $this->_Modelo->db->Sql_Select('Locomocao_Entrega', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($menu);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Entrega Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Entregas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Entrega deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $id
     * @throws \Exception
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entrega_Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Locomocao_Entrega', Array('id'=>$id),1);
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        if($resultado->status==1 || $resultado->status=='1'){
            $resultado->status='0';
        }else{
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            if($resultado->status==1 || $resultado->status=='1'){
                $texto = __('Ativado');
            }else{
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Locomocao/Entrega/Entrega_Status/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    function Endereco_Entrega($true=true){
        $titulo = __('Administração de Entregas');
        $link = 'Locomocao/Entrega/Entregas';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
            $this->Tema_Endereco($titulo);
        }
    }
    /**
     * Entregaura as Entregas Publicas
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    function Endereco_Entrega_Entrega($true=true){
        self::Endereco_Entrega();
        $titulo = __('Permissões do Sistema');
        $link = 'Locomocao/Entrega/Permissoes';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
            $this->Tema_Endereco($titulo);
        }
    }
}
?>
