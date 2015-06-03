<?php

class Transporte_PedidoControle extends Transporte_Controle
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Main(){
        //\Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Transporte/Pedido/Pedidos');
        return false;
    }
    /**
     * Aceita um Pedido (->)
     * @param type $id
     * @param type $status
     * @throws \Exception
     */
    public function Arma_Ped_Novas_Aceitar($id=false,$status=1){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido_Lance', '{sigla}id=\''.$id.'\' AND {sigla}fornecedor=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        if($resultado->status==1 ||$resultado->status==2){
            // Voce não pode alterar
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        if($status==1){
            $resultado->status='1';
        }else{
            $resultado->status='2';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            if($resultado->status==1){
                $texto = 'Aceito';
                $pedido = $resultado->pedido;
                
                // Caso Aceita o Resto ele Recusa
                $procurar = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido_Lance', '{sigla}pedido=\''.$pedido.'\' AND {sigla}fornecedor=\''.$this->_Acl->Usuario_GetID().'\'');
                if(is_object($procurar)) $procurar = array($procurar);
                if($procurar!==false){
                    foreach($procurar as &$valor){
                        $valor->status = '2';
                    }
                    $this->_Modelo->db->Sql_Update($procurar);
                }
                // Caso Aceita o Resto ele Recusa
                $procurar = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido', '{sigla}id=\''.$pedido.'\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
                if(is_object($procurar)) $procurar = array($procurar);
                if($procurar!==false){
                    foreach($procurar as &$valor){
                        $valor->status = '2';
                    }
                    $this->_Modelo->db->Sql_Update($procurar);
                }
                
            }else{
                $texto = 'Recusado';
            }
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => 'Sucesso',
                "mgs_secundaria"    => $texto.' com Sucesso'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Titulo',$texto.' com Sucesso'); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * Enviar Pedido (->)
     */
    public function Arma_Ped_Add(){
        //self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Adicionar Pedido';
        $titulo2    = 'Salvar Pedido';
        $formid     = 'formTransporte_Armazem_PEdido';
        $formbt     = 'Salvar';
        $formlink   = 'Transporte/Pedido/Arma_Ped_Add2/';
        $campos = Transporte_Armazem_Pedido_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * Enviar Pedido (->)
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Arma_Ped_Add2(){
        $titulo     = 'Pedido enviado com Sucesso';
        $dao        = 'Transporte_Armazem_Pedido';
        $funcao     = '$this->Arma_Ped_Novas();';
        $sucesso1   = 'Proposta enviada com Sucesso';
        $sucesso2   = 'Aguarde uma Resposta.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Arma_Ped_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa Transporte e deleta
        $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido', '{sigla}id=\''.$id.'\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if($pedido===false || $pedido->status!='0'){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Erro',
                "mgs_secundaria" => 'Você não pode deletar esse Pedido'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);  
            return false;
        }
        $sucesso =  $this->_Modelo->db->Sql_Delete($pedido);
        
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Pedido Cancelado com Sucesso'
            );
            
            $pedidos    =  $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido_Lance', '{sigla}pedido=\''.$id.'\'');
            $sucesso =  $this->_Modelo->db->Sql_Delete($pedidos);
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Pedidos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta Cancelada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Arma_Ped_Aceitas($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Arma_Ped_Aceitas',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido_Lance', '{sigla}status=\'1\' AND {sigla}fornecedor=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Arma_Ped_Novas_Aceitar');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Armazem'][$i] = '#'.$valor->log_user_id;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Status1'     ,Array('Aceitar'        ,'Transporte/Pedido/Arma_Ped_Novas_Aceitar/'.$valor->id.'/1'    ,''),$perm_status).
                                            $this->_Visual->Tema_Elementos_Btn('Status0'     ,Array('Recusar'        ,'Transporte/Pedido/Arma_Ped_Novas_Aceitar/'.$valor->id.'/2'    ,''),$perm_status);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Aceitas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Aceita para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Aceita';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Propostas Aceitas dos Meus Pedidos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Aceitas dos Meus Pedidos'));
    }
    public function Arma_Ped_Novas($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Arma_Ped_Novas',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido_Lance', '{sigla}status=\'0\' AND {sigla}fornecedor=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Arma_Ped_Novas_Aceitar');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Armazem'][$i] = '#'.$valor->log_user_id;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Status1'     ,Array('Aceitar'        ,'Transporte/Pedido/Arma_Ped_Novas_Aceitar/'.$valor->id.'/1'    ,''), $perm_status).
                                            $this->_Visual->Tema_Elementos_Btn('Status0'     ,Array('Recusar'        ,'Transporte/Pedido/Arma_Ped_Novas_Aceitar/'.$valor->id.'/2'    ,''), $perm_status);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Novas Propostas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma nova Proposta para exportar';
            }else{
                $mensagem = 'Nenhuma nova Proposta';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Novas Propostas dos Meus Pedidos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Novas Propostas dos Meus Pedidos'));
    }
    public function Arma_Ped_Minhas($export=false){
        $i = 0;
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Pedido',
                'Transporte/Pedido/Arma_Ped_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Arma_Ped_Minhas',
            )
        )));
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido', '{sigla}status=\'0\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Arma_Ped_Del');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Descrição'][$i]       = $valor->descricao_carga;
                $tabela['Dimensões'][$i]       = '<b>Altura:</b>'.$valor->altura.
                                                ' cm<br><b>Comprimento:</b>'.$valor->comprimento.
                                                ' cm<br><b>Largura:</b>'.$valor->largura.' cm<br><b>Volume:</b>'.$valor->altura*$valor->comprimento*$valor->largura.' cm³';
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Cancelar Pedido'       ,'Transporte/Pedido/Arma_Ped_Del/'.$valor->id.'/'     ,'Deseja realmente Cancelar esse Pedido ?'),$perm_del);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Pedidos Cadastrados');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhum Pedido Cadastrado para exportar';
            }else{
                $mensagem = 'Nenhum Pedido Cadastrado';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem dos meus Pedidos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Meus Pedidos'));
    }
    public function Arma_Sol_Solicitacoes($export=false){
        $i = 0;
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Arma_Ped_Minhas',
            )
        )));
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido', '{sigla}status=\'0\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_add = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Arma_Sol_Add');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Descrição'][$i]       = $valor->descricao_carga;
                $tabela['Dimensões'][$i]       = '<b>Altura:</b>'.$valor->altura.
                                                ' cm<br><b>Comprimento:</b>'.$valor->comprimento.
                                                ' cm<br><b>Largura:</b>'.$valor->largura.' cm<br><b>Volume:</b>'.$valor->altura*$valor->comprimento*$valor->largura.' cm³';
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Status1'     ,Array('Fazer Proposta'        ,'Transporte/Pedido/Arma_Sol_Add/'.$valor->id.'/'    ,''),$perm_add);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Pedidos pendentes');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhum Pedido pendente para exportar';
            }else{
                $mensagem = 'Nenhum Pedido Pendente';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem dos Pedidos Pendentes ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Pedidos Pendentes'));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function Arma_Sol_PedAceitos($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Arma_Sol_PedAceitos',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido_Lance', '{sigla}status=\'1\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Fornecedor'][$i] = '#'.$valor->fornecedor2;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Aceitas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Aceita para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Aceita';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Proposta Aceitas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Aceitas'));
    }
    public function Arma_Sol_PedRecusados($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Arma_Sol_PedRecusados',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido_Lance', '{sigla}status=\'2\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Fornecedor'][$i] = '#'.$valor->fornecedor2;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Recusadas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Recusada para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Recusada';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Proposta Recusadas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Recusadas'));
    }
    public function Arma_Sol_PedPendente($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Arma_Sol_PedPendente',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido_Lance', '{sigla}status=\'0\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Arma_Sol_Del');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Fornecedor'][$i] = '#'.$valor->fornecedor2;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Cancelar Proposta'       ,'Transporte/Pedido/Arma_Sol_Del/'.$valor->id.'/'     ,'Deseja realmente Cancelar essa Proposta ?'),$perm_del);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Pendentes');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Pendente para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Pendente';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Proposta Pendentes ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Pendentes'));
    }
    
    
    
    
    
    
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Arma_Sol_Add($pedido=false){
        if($pedido===false) return false;
        else{
            $pedido = (int) $pedido;
            
            $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido', '{sigla}id=\''.$pedido.'\'',1);
            if($pedido===false || $pedido->status!=0){
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => $language['mens_erro']['erro'],
                    "mgs_secundaria" => 'Você não pode Adicionar uma Solicitação a este pedido'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                return false;
            }
        }
        //self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Adicionar Proposta de Pedido';
        $titulo2    = 'Salvar Proposta de Pedido';
        $formid     = 'formTransporte_Pedido_Arma_Sol_Add';
        $formbt     = 'Salvar';
        $formlink   = 'Transporte/Pedido/Arma_Sol_Add2/'.$pedido;
        $campos = Transporte_Armazem_Pedido_Lance_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos,'pedido');
        self::DAO_Campos_Retira($campos,'status');
        self::DAO_Campos_Retira($campos,'fornecedor');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Arma_Sol_Add2($pedido=false){
        if($pedido===false) return false;
        else{
            $pedido = (int) $pedido;
            
            $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido', '{sigla}id=\''.$pedido.'\'',1);
            if($pedido===false || $pedido->status!=0){
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => $language['mens_erro']['erro'],
                    "mgs_secundaria" => 'Você não pode Adicionar uma Solicitação a este pedido'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                return false;
            }
        }
        $titulo     = 'Proposta enviada com Sucesso';
        $dao        = 'Transporte_Armazem_Pedido_Lance';
        $funcao     = '$this->Arma_Sol_Solicitacoes();';
        $sucesso1   = 'Proposta enviada com Sucesso';
        $sucesso2   = 'Aguarde uma Resposta.';
        $alterar    = Array('status'=>'0','fornecedor'=>$pedido->log_user_add,'pedido'=>$pedido->id);
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Arma_Sol_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa Transporte e deleta
        $pedido_lance    =  $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido_Lance', '{sigla}id=\''.$id.'\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'',1);
        
        if($pedido_lance===false || $pedido_lance->status!=0){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Você não pode deletar'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            return false;
        }
        
        $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Armazem_Pedido', '{sigla}id=\''.$pedido_lance->pedido.'\'',1);
        if($pedido===false || $pedido->status!=0){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Você não pode deletar'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            return false;
        }
        
        $sucesso =  $this->_Modelo->db->Sql_Delete($pedido_lance);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Proposta Cancelada com Sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Arma_Sol_Solicitacoes();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta Cancelada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    
    
    
    
    
    
    /**
     * Aceita um Pedido (->)
     * @param type $id
     * @param type $status
     * @throws \Exception
     */
    public function Trans_Ped_Novas_Aceitar($id=false,$status=1){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido_Lance', '{sigla}id=\''.$id.'\' AND {sigla}fornecedor=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        if($resultado->status==1 ||$resultado->status==2){
            // Voce não pode alterar
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        if($status==1){
            $resultado->status='1';
        }else{
            $resultado->status='2';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            if($resultado->status==1){
                $texto = 'Aceito';
                $pedido = $resultado->pedido;
                
                // Caso Aceita o Resto ele Recusa
                $procurar = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido_Lance', '{sigla}pedido=\''.$pedido.'\' AND {sigla}fornecedor=\''.$this->_Acl->Usuario_GetID().'\'');
                if(is_object($procurar)) $procurar = array($procurar);
                if($procurar!==false){
                    foreach($procurar as &$valor){
                        $valor->status = '2';
                    }
                    $this->_Modelo->db->Sql_Update($procurar);
                }
                // Caso Aceita o Resto ele Recusa
                $procurar = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido', '{sigla}id=\''.$pedido.'\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
                if(is_object($procurar)) $procurar = array($procurar);
                if($procurar!==false){
                    foreach($procurar as &$valor){
                        $valor->status = '2';
                    }
                    $this->_Modelo->db->Sql_Update($procurar);
                }
                
            }else{
                $texto = 'Recusado';
            }
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => 'Sucesso',
                "mgs_secundaria"    => $texto.' com Sucesso'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Titulo',$texto.' com Sucesso'); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * Enviar Pedido (->)
     */
    public function Trans_Ped_Add(){
        //self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Adicionar Pedido';
        $titulo2    = 'Salvar Pedido';
        $formid     = 'formTransporte_Transportadora_PEdido';
        $formbt     = 'Salvar';
        $formlink   = 'Transporte/Pedido/Trans_Ped_Add2/';
        $campos = Transporte_Transportadora_Pedido_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * Enviar Pedido (->)
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Trans_Ped_Add2(){
        $titulo     = 'Pedido enviado com Sucesso';
        $dao        = 'Transporte_Transportadora_Pedido';
        $funcao     = '$this->Trans_Ped_Novas();';
        $sucesso1   = 'Proposta enviada com Sucesso';
        $sucesso2   = 'Aguarde uma Resposta.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Trans_Ped_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa Transporte e deleta
        $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido', '{sigla}id=\''.$id.'\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if($pedido===false || $pedido->status!='0'){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Erro',
                "mgs_secundaria" => 'Você não pode deletar esse Pedido'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);  
            return false;
        }
        $sucesso =  $this->_Modelo->db->Sql_Delete($pedido);
        
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Pedido Cancelado com Sucesso'
            );
            
            $pedidos    =  $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido_Lance', '{sigla}pedido=\''.$id.'\'');
            $sucesso =  $this->_Modelo->db->Sql_Delete($pedidos);
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Pedidos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta Cancelada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Trans_Ped_Aceitas($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Trans_Ped_Aceitas',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido_Lance', '{sigla}status=\'1\' AND {sigla}fornecedor=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Trans_Ped_Novas_Aceitar');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Transportadora'][$i] = '#'.$valor->log_user_id;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Status1'     ,Array('Aceitar'        ,'Transporte/Pedido/Trans_Ped_Novas_Aceitar/'.$valor->id.'/1'    ,''),$perm_status).
                                            $this->_Visual->Tema_Elementos_Btn('Status0'     ,Array('Recusar'        ,'Transporte/Pedido/Trans_Ped_Novas_Aceitar/'.$valor->id.'/2'    ,''),$perm_status);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Aceitas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Aceita para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Aceita';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Propostas Aceitas dos Meus Pedidos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Aceitas dos Meus Pedidos'));
    }
    public function Trans_Ped_Novas($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Trans_Ped_Novas',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido_Lance', '{sigla}status=\'0\' AND {sigla}fornecedor=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Trans_Ped_Novas_Aceitar');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Transportadora'][$i] = '#'.$valor->log_user_id;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Status1'     ,Array('Aceitar'        ,'Transporte/Pedido/Trans_Ped_Novas_Aceitar/'.$valor->id.'/1'    ,''),$perm_status).
                                            $this->_Visual->Tema_Elementos_Btn('Status0'     ,Array('Recusar'        ,'Transporte/Pedido/Trans_Ped_Novas_Aceitar/'.$valor->id.'/2'    ,''), $perm_status);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Novas Propostas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma nova Proposta para exportar';
            }else{
                $mensagem = 'Nenhuma nova Proposta';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Novas Propostas dos Meus Pedidos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Novas Propostas dos Meus Pedidos'));
    }
    public function Trans_Ped_Minhas($export=false){
        $i = 0;
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Pedido',
                'Transporte/Pedido/Trans_Ped_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Trans_Ped_Minhas',
            )
        )));
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido', '{sigla}status=\'0\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Trans_Ped_Del');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Descrição'][$i]       = $valor->descricao_carga;
                $tabela['Dimensões'][$i]       = '<b>Altura:</b>'.$valor->altura.
                                                ' cm<br><b>Comprimento:</b>'.$valor->comprimento.
                                                ' cm<br><b>Largura:</b>'.$valor->largura.' cm<br><b>Volume:</b>'.$valor->altura*$valor->comprimento*$valor->largura.' cm³';
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Cancelar Pedido'       ,'Transporte/Pedido/Trans_Ped_Del/'.$valor->id.'/'     ,'Deseja realmente Cancelar esse Pedido ?'),$perm_del);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Pedidos Cadastrados');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhum Pedido Cadastrado para exportar';
            }else{
                $mensagem = 'Nenhum Pedido Cadastrado';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem dos meus Pedidos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Meus Pedidos'));
    }
    public function Trans_Sol_Solicitacoes($export=false){
        $i = 0;
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Trans_Ped_Minhas',
            )
        )));
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido', '{sigla}status=\'0\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Trans_Sol_Add');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Descrição'][$i]       = $valor->descricao_carga;
                $tabela['Dimensões'][$i]       = '<b>Altura:</b>'.$valor->altura.
                                                ' cm<br><b>Comprimento:</b>'.$valor->comprimento.
                                                ' cm<br><b>Largura:</b>'.$valor->largura.' cm<br><b>Volume:</b>'.$valor->altura*$valor->comprimento*$valor->largura.' cm³';
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Status1'     ,Array('Fazer Proposta'        ,'Transporte/Pedido/Trans_Sol_Add/'.$valor->id.'/'    ,''),$perm_status);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Pedidos pendentes');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhum Pedido pendente para exportar';
            }else{
                $mensagem = 'Nenhum Pedido Pendente';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem dos Pedidos Pendentes ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Pedidos Pendentes'));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function Trans_Sol_PedAceitos($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Trans_Sol_PedAceitos',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido_Lance', '{sigla}status=\'1\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Fornecedor'][$i] = '#'.$valor->fornecedor2;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Aceitas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Aceita para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Aceita';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Proposta Aceitas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Aceitas'));
    }
    public function Trans_Sol_PedRecusados($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Trans_Sol_PedRecusados',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido_Lance', '{sigla}status=\'2\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Fornecedor'][$i] = '#'.$valor->fornecedor2;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Recusadas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Recusada para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Recusada';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Proposta Recusadas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Recusadas'));
    }
    public function Trans_Sol_PedPendente($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Trans_Sol_PedPendente',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido_Lance', '{sigla}status=\'0\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Trans_Sol_Del');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Fornecedor'][$i] = '#'.$valor->fornecedor2;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Cancelar Proposta'       ,'Transporte/Pedido/Trans_Sol_Del/'.$valor->id.'/'     ,'Deseja realmente Cancelar essa Proposta ?'),$perm_del);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Pendentes');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Pendente para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Pendente';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Proposta Pendentes ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Pendentes'));
    }
    
    
    
    
    
    
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Trans_Sol_Add($pedido=false){
        if($pedido===false) return false;
        else{
            $pedido = (int) $pedido;
            
            $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido', '{sigla}id=\''.$pedido.'\'',1);
            if($pedido===false || $pedido->status!=0){
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => $language['mens_erro']['erro'],
                    "mgs_secundaria" => 'Você não pode Adicionar uma Solicitação a este pedido'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                return false;
            }
        }
        //self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Adicionar Proposta de Pedido';
        $titulo2    = 'Salvar Proposta de Pedido';
        $formid     = 'formTransporte_Pedido_Trans_Sol_Add';
        $formbt     = 'Salvar';
        $formlink   = 'Transporte/Pedido/Trans_Sol_Add2/'.$pedido;
        $campos = Transporte_Transportadora_Pedido_Lance_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos,'pedido');
        self::DAO_Campos_Retira($campos,'status');
        self::DAO_Campos_Retira($campos,'fornecedor');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Trans_Sol_Add2($pedido=false){
        if($pedido===false) return false;
        else{
            $pedido = (int) $pedido;
            
            $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido', '{sigla}id=\''.$pedido.'\'',1);
            if($pedido===false || $pedido->status!=0){
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => $language['mens_erro']['erro'],
                    "mgs_secundaria" => 'Você não pode Adicionar uma Solicitação a este pedido'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                return false;
            }
        }
        $titulo     = 'Proposta enviada com Sucesso';
        $dao        = 'Transporte_Transportadora_Pedido_Lance';
        $funcao     = '$this->Trans_Sol_Solicitacoes();';
        $sucesso1   = 'Proposta enviada com Sucesso';
        $sucesso2   = 'Aguarde uma Resposta.';
        $alterar    = Array('status'=>'0','fornecedor'=>$pedido->log_user_add,'pedido'=>$pedido->id);
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Trans_Sol_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa Transporte e deleta
        $pedido_lance    =  $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido_Lance', '{sigla}id=\''.$id.'\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'',1);
        
        if($pedido_lance===false || $pedido_lance->status!=0){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Você não pode deletar'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            return false;
        }
        
        $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Transportadora_Pedido', '{sigla}id=\''.$pedido_lance->pedido.'\'',1);
        if($pedido===false || $pedido->status!=0){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Você não pode deletar'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            return false;
        }
        
        $sucesso =  $this->_Modelo->db->Sql_Delete($pedido_lance);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Proposta Cancelada com Sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Trans_Sol_Solicitacoes();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta Cancelada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }


    /**
     * Aceita um Pedido (->)
     * @param type $id
     * @param type $status
     * @throws \Exception
     */
    public function Caminho_Ped_Novas_Aceitar($id=false,$status=1){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido_Lance', '{sigla}id=\''.$id.'\' AND {sigla}transportadora=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        if($resultado->status==1 ||$resultado->status==2){
            // Voce não pode alterar
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        if($status==1){
            $resultado->status='1';
        }else{
            $resultado->status='2';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            if($resultado->status==1){
                $texto = 'Aceito';
                $pedido = $resultado->pedido;
                
                // Caso Aceita o Resto ele Recusa
                $procurar = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido_Lance', '{sigla}pedido=\''.$pedido.'\' AND {sigla}transportadora=\''.$this->_Acl->Usuario_GetID().'\'');
                if(is_object($procurar)) $procurar = array($procurar);
                if($procurar!==false){
                    foreach($procurar as &$valor){
                        $valor->status = '2';
                    }
                    $this->_Modelo->db->Sql_Update($procurar);
                }
                // Caso Aceita o Resto ele Recusa
                $procurar = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido', '{sigla}id=\''.$pedido.'\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
                if(is_object($procurar)) $procurar = array($procurar);
                if($procurar!==false){
                    foreach($procurar as &$valor){
                        $valor->status = '2';
                    }
                    $this->_Modelo->db->Sql_Update($procurar);
                }
                
            }else{
                $texto = 'Recusado';
            }
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => 'Sucesso',
                "mgs_secundaria"    => $texto.' com Sucesso'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Titulo',$texto.' com Sucesso'); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * Enviar Pedido (->)
     */
    public function Caminho_Ped_Add(){
        //self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Adicionar Pedido';
        $titulo2    = 'Salvar Pedido';
        $formid     = 'formTransporte_Caminhoneiro_PEdido';
        $formbt     = 'Salvar';
        $formlink   = 'Transporte/Pedido/Caminho_Ped_Add2/';
        $campos = Transporte_Caminhoneiro_Pedido_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * Enviar Pedido (->)
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caminho_Ped_Add2(){
        $titulo     = 'Pedido enviado com Sucesso';
        $dao        = 'Transporte_Caminhoneiro_Pedido';
        $funcao     = '$this->Caminho_Ped_Novas();';
        $sucesso1   = 'Proposta enviada com Sucesso';
        $sucesso2   = 'Aguarde uma Resposta.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caminho_Ped_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa Transporte e deleta
        $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido', '{sigla}id=\''.$id.'\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if($pedido===false || $pedido->status!='0'){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Erro',
                "mgs_secundaria" => 'Você não pode deletar esse Pedido'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);  
            return false;
        }
        $sucesso =  $this->_Modelo->db->Sql_Delete($pedido);
        
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Pedido Cancelado com Sucesso'
            );
            
            $pedidos    =  $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido_Lance', '{sigla}pedido=\''.$id.'\'');
            $sucesso =  $this->_Modelo->db->Sql_Delete($pedidos);
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Pedidos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta Cancelada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caminho_Ped_Aceitas($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Caminho_Ped_Aceitas',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido_Lance', '{sigla}status=\'1\' AND {sigla}transportadora=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Caminho_Ped_Novas_Aceitar');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Caminhoneiro'][$i] = '#'.$valor->log_user_id;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Status1'     ,Array('Aceitar'        ,'Transporte/Pedido/Caminho_Ped_Novas_Aceitar/'.$valor->id.'/1'    ,''),$perm_status).
                                            $this->_Visual->Tema_Elementos_Btn('Status0'     ,Array('Recusar'        ,'Transporte/Pedido/Caminho_Ped_Novas_Aceitar/'.$valor->id.'/2'    ,''),$perm_status);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Aceitas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Aceita para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Aceita';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Propostas Aceitas dos Meus Pedidos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Aceitas dos Meus Pedidos'));
    }
    public function Caminho_Ped_Novas($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Caminho_Ped_Novas',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido_Lance', '{sigla}status=\'0\' AND {sigla}transportadora=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Caminho_Ped_Novas_Aceitar');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Caminhoneiro'][$i] = '#'.$valor->log_user_id;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Status1'     ,Array('Aceitar'        ,'Transporte/Pedido/Caminho_Ped_Novas_Aceitar/'.$valor->id.'/1'    ,''),$perm_status).
                                            $this->_Visual->Tema_Elementos_Btn('Status0'     ,Array('Recusar'        ,'Transporte/Pedido/Caminho_Ped_Novas_Aceitar/'.$valor->id.'/2'    ,''),$perm_status);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Novas Propostas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma nova Proposta para exportar';
            }else{
                $mensagem = 'Nenhuma nova Proposta';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Novas Propostas dos Meus Pedidos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Novas Propostas dos Meus Pedidos'));
    }
    public function Caminho_Ped_Minhas($export=false){
        $i = 0;
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Pedido',
                'Transporte/Pedido/Caminho_Ped_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Caminho_Ped_Minhas',
            )
        )));
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido', '{sigla}status=\'0\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Caminho_Ped_Del');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Descrição'][$i]       = $valor->descricao_carga;
                $tabela['Dimensões'][$i]       = '<b>Altura:</b>'.$valor->altura.
                                                ' cm<br><b>Comprimento:</b>'.$valor->comprimento.
                                                ' cm<br><b>Largura:</b>'.$valor->largura.' cm<br><b>Volume:</b>'.$valor->altura*$valor->comprimento*$valor->largura.' cm³';
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Cancelar Pedido'       ,'Transporte/Pedido/Caminho_Ped_Del/'.$valor->id.'/'     ,'Deseja realmente Cancelar esse Pedido ?'), $perm_del);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Pedidos Cadastrados');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhum Pedido Cadastrado para exportar';
            }else{
                $mensagem = 'Nenhum Pedido Cadastrado';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem dos meus Pedidos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Meus Pedidos'));
    }
    public function Caminho_Sol_Solicitacoes($export=false){
        $i = 0;
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Caminho_Ped_Minhas',
            )
        )));
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido', '{sigla}status=\'0\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_add = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Caminho_Sol_Add');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Descrição'][$i]       = $valor->descricao_carga;
                $tabela['Dimensões'][$i]       = '<b>Altura:</b>'.$valor->altura.
                                                ' cm<br><b>Comprimento:</b>'.$valor->comprimento.
                                                ' cm<br><b>Largura:</b>'.$valor->largura.' cm<br><b>Volume:</b>'.$valor->altura*$valor->comprimento*$valor->largura.' cm³';
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Status1'     ,Array('Fazer Proposta'        ,'Transporte/Pedido/Caminho_Sol_Add/'.$valor->id.'/'    ,''),$perm_add);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Pedidos pendentes');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhum Pedido pendente para exportar';
            }else{
                $mensagem = 'Nenhum Pedido Pendente';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem dos Pedidos Pendentes ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Pedidos Pendentes'));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function Caminho_Sol_PedAceitos($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Caminho_Sol_PedAceitos',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido_Lance', '{sigla}status=\'1\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Transportadora'][$i] = '#'.$valor->transportadora2;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Aceitas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Aceita para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Aceita';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Proposta Aceitas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Aceitas'));
    }
    public function Caminho_Sol_PedRecusados($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Caminho_Sol_PedRecusados',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido_Lance', '{sigla}status=\'2\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Transportadora'][$i] = '#'.$valor->transportadora2;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Recusadas');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Recusada para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Recusada';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Proposta Recusadas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Recusadas'));
    }
    public function Caminho_Sol_PedPendente($export=false){
        
        //self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Pedido/Caminho_Sol_PedPendente',
            )
        )));
        $i = 0;
        $pedido = $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido_Lance', '{sigla}status=\'0\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($pedido)) $pedido = Array(0=>$pedido);
        if($pedido!==false && !empty($pedido)){
            $i = 0;
            reset($pedido);
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Transporte/Pedido/Caminho_Sol_Del');
            foreach ($pedido as &$valor) {                
                $tabela['Id'][$i]           = '#'.$valor->id;
                $tabela['Pedido'][$i] = '#'.$valor->pedido2;
                $tabela['Transportadora'][$i] = '#'.$valor->transportadora2;
                $tabela['Valor'][$i]       = $valor->valor;
                $tabela['Observação'][$i]       = $valor->obs;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Cancelar Proposta'       ,'Transporte/Pedido/Caminho_Sol_Del/'.$valor->id.'/'     ,'Deseja realmente Cancelar essa Proposta ?'),$perm_del);
                ++$i;
            }
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Propostas Pendentes');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = 'Nenhuma Proposta Pendente para exportar';
            }else{
                $mensagem = 'Nenhuma Proposta Pendente';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Proposta Pendentes ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Propostas Pendentes'));
    }
    
    
    
    
    
    
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caminho_Sol_Add($pedido=false){
        if($pedido===false) return false;
        else{
            $pedido = (int) $pedido;
            
            $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido', '{sigla}id=\''.$pedido.'\'',1);
            if($pedido===false || $pedido->status!=0){
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => $language['mens_erro']['erro'],
                    "mgs_secundaria" => 'Você não pode Adicionar uma Solicitação a este pedido'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                return false;
            }
        }
        //self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Adicionar Proposta de Pedido';
        $titulo2    = 'Salvar Proposta de Pedido';
        $formid     = 'formTransporte_Pedido_Caminho_Sol_Add';
        $formbt     = 'Salvar';
        $formlink   = 'Transporte/Pedido/Caminho_Sol_Add2/'.$pedido;
        $campos = Transporte_Caminhoneiro_Pedido_Lance_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos,'pedido');
        self::DAO_Campos_Retira($campos,'status');
        self::DAO_Campos_Retira($campos,'transportadora');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caminho_Sol_Add2($pedido=false){
        if($pedido===false) return false;
        else{
            $pedido = (int) $pedido;
            
            $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido', '{sigla}id=\''.$pedido.'\'',1);
            if($pedido===false || $pedido->status!=0){
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => $language['mens_erro']['erro'],
                    "mgs_secundaria" => 'Você não pode Adicionar uma Solicitação a este pedido'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                return false;
            }
        }
        $titulo     = 'Proposta enviada com Sucesso';
        $dao        = 'Transporte_Caminhoneiro_Pedido_Lance';
        $funcao     = '$this->Caminho_Sol_Solicitacoes();';
        $sucesso1   = 'Proposta enviada com Sucesso';
        $sucesso2   = 'Aguarde uma Resposta.';
        $alterar    = Array('status'=>'0','transportadora'=>$pedido->log_user_add,'pedido'=>$pedido->id);
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caminho_Sol_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa Transporte e deleta
        $pedido_lance    =  $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido_Lance', '{sigla}id=\''.$id.'\' AND {sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'',1);
        
        if($pedido_lance===false || $pedido_lance->status!=0){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Você não pode deletar'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            return false;
        }
        
        $pedido    =  $this->_Modelo->db->Sql_Select('Transporte_Caminhoneiro_Pedido', '{sigla}id=\''.$pedido_lance->pedido.'\'',1);
        if($pedido===false || $pedido->status!=0){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Você não pode deletar'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            return false;
        }
        
        $sucesso =  $this->_Modelo->db->Sql_Delete($pedido_lance);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Proposta Cancelada com Sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Caminho_Sol_Solicitacoes();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Proposta Cancelada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
