<?php
class usuario_mensagem_Modelo extends \Framework\App\Modelo
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        parent::__construct();
    } 
    /**
     * 
     * @param type $array
     * @param type $proprietario
     * @param type $ticket
     * @return int
     * 
     */
    public function Mensagens_Retorna(&$array,$proprietario=0,$ticket=0,$tipodemensagem=false){
        $i =0;
        $array = Array();
        if($proprietario==0 && $ticket==1){
            // mostra todos os tickets para ADMIN
            $where = Array(
                'para'      =>0
            );
        }else if($ticket==1){
            // mostra os tickets de certo proprietario
            $where = Array(
                'escritor'  =>$proprietario,
                'para'      =>0
            );
        }else{
            // mostra todas as suas mensagens
            $where = Array(
                '!para'=>0,
                Array(
                    'escritor'  => $proprietario,
                    'para'      => $proprietario
                )
            );
        }
        $array = $this->db->Sql_Select('Usuario_Mensagem',$where);
        return self::Mensagem_TipoChamado_GET($array,$tipodemensagem);
    }
    #update
    static function Mensagens_Retornanaolidas(&$modelo,&$mensagens,$proprietario=0,$ticket=0){
        $i =0;
        if($proprietario==0 && $ticket==1){
            // mostra todos os tickets para ADMIN
            $where = Array(
                'para'      =>0
            );
        }else if($ticket==1){
            // mostra os tickets de certo proprietario
            $where = Array(
                'escritor'  =>$proprietario,
                'para'      =>0
            );
        }else{
            // mostra todas as suas mensagens
            $where = Array(
                '!para'=>0,
                Array(
                    'escritor'  => $proprietario,
                    'para'      => $proprietario
                )
            );
        }
        $mensagens = $this->db->Sql_Select('Usuario_Mensagem',$where,0,'log_date_edit DESC');
        if($mensagens!==false){
            if(is_object($mensagens)) $mensagens = Array($mensagens);
            foreach($mensagens as &$campo){
                $j = $this->db->Sql_Select('Usuario_Mensagem',
                    Array(
                        'id_mensagem' => $campo->id
                    ),
                    1,
                    'id DESC'
                );
                if($j===false || $j->escritor==$campo->escritor){
                    ++$i;
                }else{
                    unset($campo);
                }
            }
            return $i; 
        }
    }
    #update
    public function Mensagem_Retorna(&$array,$mensagemid=0,$ticket=0){
        $array = new \Framework\Classes\Collection();
        $i = 0;
        $de = 0;
        $para = 0;
        $assunto = '';
        $mensagem = $this->db->Sql_Select('Usuario_Mensagem',Array('id'=>$mensagemid));
        // Captura Mensagem
        // é 0 pq esta em outra tabela
        $array[$i] = new \Framework\Classes\Collection(Array(
            'id'            => 0,
            'escritor'      => $mensagem->escritor,
            'escritor_nome' => $mensagem->origem2,
            'resposta'      => $mensagem->mensagem,
            'log_date_add'    => $mensagem->log_date_add
        ));
        $de = $mensagem->escritor;
        $para = $mensagem->para;
        $assunto = $mensagem->assunto2;
        if($mensagem->escritor==\Framework\App\Acl::Usuario_GetID_Static()){
            $mensagem->lido = 1;
            $this->db->Sql_Update($mensagem);
        }
        ++$i;
        // Captura Respostas
        $respostas = $this->db->Sql_Select('usuario_mensagem_Resposta',Array('id_mensagem'=>$mensagemid),0,'log_date_add');
        $sql = $this->db->query('SELECT id, escritor, escritor_nome, resposta, log_date_add FROM '.MYSQL_USUARIOS_MENS_RESP.' WHERE deletado!=1 AND id_mensagem='.$mensagemid.' ORDER BY log_date_add');
        
        if(is_object($respostas)) $respostas = Array(0=>$respostas);
        if($respostas!==false && !empty($respostas)){
            reset($respostas);
            foreach ($respostas as $campo) {
                if($para==0 && $campo->escritor!=$de){
                    $escritor = 0;
                    $escritor_nome = $mensagem->origem2;
                }else{
                    $escritor = $campo->escritor;
                    $escritor_nome = $campo->escritor_nome;
                }
                $array[$i] = new \Framework\Classes\Collection(Array(
                    'id'            => $campo->id,
                    'escritor'      => $escritor,
                    'escritor_nome' => $escritor_nome,
                    'resposta'      => $campo->resposta,
                    'log_date_add'    => $campo->log_date_add
                ));
                //$this->db->query('UPDATE '.MYSQL_USUARIOS_MENS_RESP.' SET dt_lido=\'0000-00-00 00:00:00\' WHERE id='.$campo->id.' AND escritor='.\Framework\App\Acl::Usuario_GetID_Static());
                ++$i;
            }
        }
        return $mensagem; 
    }
    /**
     * 
     * @param type $para
     * @param type $para_nome
     * @param type $mensagem
     * @return int
    */
    public function Mensagem_Resp_Inserir($mensagem,$resposta_mgs){
        // Quatnidade de respostas
        $ordem = 0;
        $quantidade = $this->db->Sql_Select('usuario_mensagem_Resposta',Array('id_mensagem'=>$mensagem),0,'ordem');
        if(is_object($quantidade)) $ordem = 1;
        else $ordem = count($quantidade);
        
        // Atualiza Mensagem
        $objeto = $this->db->Sql_Select('Usuario_Mensagem',Array('id'=>$mensagem));
        if(!is_object($objeto)) throw new \Exception('Mensagem nao existe ou existe mais delas.',3030);
        $objeto->log_date_edit = APP_HORA;
        $objeto->escritor = (int) $objeto->escritor;
        if(\Framework\App\Acl::Usuario_GetID_Static()!=$objeto->escritor){
            $objeto->finalizado = '1';
        }else{
            $objeto->finalizado = '0';
        }
        $this->db->Sql_Update($objeto);
        
        // Cria nova resposta 
        $resposta = new \usuario_mensagem_Resposta_DAO();
        $resposta->id_mensagem      = $mensagem;
        $resposta->escritor         = \Framework\App\Acl::Usuario_GetID_Static();
        $resposta->escritor_nome    = $this->_Acl->logado_usuario->nome;
        $resposta->ordem            = $ordem;
        $resposta->resposta         = $resposta_mgs;
        $sucesso =  $this->db->Sql_Inserir($resposta);
        return $sucesso;
    }
    /**
     * Retorna se uma Mensagem tem resposta nova ou nao ! (Verdadeiro ou falso)
     * 
     * #update Terá que ser Substituido por uma query, está perdendo muito em performace
     * 
     * @param type $mensagem
     * @return string {nov,lim,esg} ou false
     * @static
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
     */
    public static function Mensagem_TipoChamado(&$mensagem){
        $tipo = false;
        $registro = &\Framework\App\Registro::getInstacia();
        $Modelo = $registro->_Modelo;
        // Proteção contra erros
        if(!is_object($mensagem)) return false;
        // Captura Assunto
        /*$where = Array(
            'id' => $mensagem->assunto
        );
        $assunto = $Modelo->db->Sql_Select('Usuario_Mensagem_Assunto',$where,1);
        if(!is_object($assunto))return false;*/
        if(Data_geraTimestamp($mensagem->log_date_edit,false)!==false){
            $dataapassar = $mensagem->log_date_edit;
        }else if(Data_geraTimestamp($mensagem->log_date_add,false)!==false){
            $dataapassar = $mensagem->log_date_add;
        }else{
            if($mensagem->finalizado==1){
                $tipo = 'fin';
                $dataapassar = $mensagem->log_date_add;
            }else{
                $tipo = 'esg';
                $dataapassar = $mensagem->log_date_add;
            }
        }
        // Se tiver data valida, continua, se nao bota como esgotado direto
        if($tipo===false){
            $datapassada = Data_CalculaDiferenca($dataapassar,APP_HORA);
            if($mensagem->finalizado==1){
                $tipo = 'fin';
            }else{
                // Manipula e Ve qual é da parada
                $tempoassunto = (int) $mensagem->tempocli;
                if(isset($tempoassunto) && $tempoassunto>0){
                    $porcentagem = floor(($datapassada*100)/$tempoassunto);
                    if($porcentagem>=100)       $tipo = 'esg';
                    else if($porcentagem>=80)   $tipo = 'lim';
                    else                        $tipo = 'nov';
                }else{
                                                $tipo = 'nov';
                }
            }
        }
        return Array($tipo,$datapassada);
    }
    public static function Mensagem_TipoChamado_GET(&$array,$tipodemensagem=false){
        if( is_object($array) ) $array = Array($array);
        if(     empty($array) ) return 0;
        foreach($array as $indice=>&$valor){
            $valor->lido                            = self::Mensagem_RespNova($valor->id,$valor->escritor);
            list($valor->tipo,$valor->datapassada)  = usuario_mensagem_Modelo::Mensagem_TipoChamado($valor);
            if($valor->tipo=='nov'){
                if($tipodemensagem===false || $tipodemensagem=='nov'){
                    $valor->tipo = 'Chamado Novo';
                }else{
                    unset($array[$indice]);
                }
            }
            else if($valor->tipo=='fin'){
                if($tipodemensagem===false || $tipodemensagem=='fin'){
                    $valor->tipo = 'Finalizado';
                }else{
                    unset($array[$indice]);
                }
            }
            else if($valor->tipo=='lim'){
                if($tipodemensagem===false || $tipodemensagem=='lim'){
                    $valor->tipo = 'Tempo Limite';
                }else{
                    unset($array[$indice]);
                }
            }
            else if($valor->tipo=='esg'){
                if($tipodemensagem===false || $tipodemensagem=='esg'){
                    $valor->tipo = 'Esgotado';
                }else{
                    unset($array[$indice]);
                }
            }
        }
        return count($array);
    }
    /**
     * Retorna se uma Mensagem tem resposta nova ou nao ! (Verdadeiro ou falso)
     * @param type $mensagem
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
     */
    protected static function Mensagem_RespNova($mensagem=0,$escritor=0){
        $registro = \Framework\App\Registro::getInstacia();
        $Modelo = $registro->_Modelo;
        $acl = $registro->_Acl;
        $usuarioid = $acl->Usuario_GetID();
        // Proteção contra erros
        $mensagem = (int) $mensagem;
        $escritor = (int) $escritor;
        if($mensagem==0 || !is_int($mensagem) || $escritor==0 || !is_int($escritor)) return;
        
        $registro = &\Framework\App\Registro::getInstacia();
        $Modelo = $registro->_Modelo;
        // Carrega Mensagens de Acordo com os assuntos acima 
        $i =0;
        $array = Array();
        if($acl->logado_usuario->id==$escritor){
            // mostra todos os tickets para ADMIN
            $where = Array(
                '!escritor' => $escritor
            );
        }else{
            // mostra todos os tickets para ADMIN
            $where = Array(
                'escritor' => $escritor
            );
        }
        $array = $Modelo->db->Sql_Select('Usuario_Mensagem_Resposta',$where,1,'ordem DESC');
        if(!is_array($array) || count($array)==0) return false;
        if($array->lido==0) return true;
    }
    
    
    
    
    /**
     * 2015 - Funções mais Performaticas para Substituir as Anteriores
     */
    
    
}
?>