<?php

class usuario_mensagem_SuporteModelo extends usuario_mensagem_Modelo
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
     * @param type $grupo
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
     */
    public function Suporte_MensagensSetor(&$array,$grupo=0){
        $array = Array();
        // Carrega Todos os Grupos
        if($grupo!=0){
            $where = Array(
                'grupo'      => $grupo
            );
            $setores = $this->db->Sql_Select('Usuario_Mensagem_Setor',$where);
            $i = 0;
            $setoreswhere = Array();
            if(is_object($setores)) $setores = Array($setores);
            if(!empty($setores)){
                foreach($setores as $valor){
                    $setoreswhere[$i] = $valor->id;
                    ++$i;
                }
            }else{
                return 0;
            }
            // Carrega Assuntos de Acordo com os grupos acima 
            $i =0;
            $array = Array();
            if($setor!=0){
                // mostra todos os tickets para ADMIN
                $where = Array(
                    'INsetor'      => $setoreswhere
                );
            }else{
                // mostra todas as suas mensagens
                $where = Array();
            }
            // Carrega Todos os Assuntos
            $assuntos = $this->db->Sql_Select('Usuario_Mensagem_Assunto',$where);
            $i = 0;
            $assuntoswhere = Array();
            if(is_object($assuntos)) $assuntos = Array($assuntos);
            foreach($assuntos as $valor){
                $assuntoswhere[$i] = $valor->id;
                ++$i;
            }
            // Carrega Mensagens de Acordo com os assuntos acima 
            $i =0;
            $array = Array();
            // mostra todos os tickets para ADMIN
            $where = Array(
                'INassunto'      => $assuntoswhere,
                '!finalizado'     => 1
            );
        }else{
            // mostra todas as suas mensagens
            $where = Array('!finalizado'     => 1);
        }
        $array = $this->db->Sql_Select('Usuario_Mensagem',$where);
        return self::Mensagem_TipoChamado_GET($array);
    }
    /**
     * 
     * @param type $array
     * @param type $cliente
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
     */
    public static function Suporte_MensagensCliente(&$array,$cliente=0){
        $registro = &\Framework\App\Registro::getInstacia();
        $modelo = $registro->_Modelo;
        // Carrega Mensagens de Acordo com os assuntos acima 
        $i =0;
        $array = Array();
        if($cliente!=0){
            // mostra todos os tickets para ADMIN
            $where = Array(
                'cliente'      => $cliente
            );
        }else{
            // mostra todas as suas mensagens
            $where = Array();
        }
        // Puxa Banco de Dados
        $array = $modelo->db->Sql_Select('Usuario_Mensagem',$where);
        if($array!==false){
            if(is_object($array)) $array = Array($array);
            foreach($array as &$valor){
                $valor->lido = self::Mensagem_RespNova($valor->id,$valor->escritor);
                list($valor->tipo,$valor->tempopassado) = usuario_mensagem_Modelo::Mensagem_TipoChamado($valor);
                if($valor->tipo=='nov') $valor->tipo = 'Chamado Novo';
                if($valor->tipo=='lim') $valor->tipo = 'Tempo Limite';
                if($valor->tipo=='esg') $valor->tipo = 'Esgotado';
                if($valor->tipo=='fin') $valor->tipo = 'Finalizado';
            }
        }
        return count($array); 
    }
    public static function Suporte_MensagensCliente_Qnt($cliente=0){
        $registro = &\Framework\App\Registro::getInstacia();
        $modelo = $registro->_Modelo;
        // Carrega Mensagens de Acordo com os assuntos acima 
        $i =0;
        $array = Array();
        if($cliente!=0){
            // mostra todos os tickets para ADMIN
            $where = 'cliente='.$cliente;
        }else{
            // mostra todas as suas mensagens
            $where = false;
        }
        // Puxa Banco de Dados
        return $modelo->db->Sql_Contar('Usuario_Mensagem',$where);
    }
}
?>