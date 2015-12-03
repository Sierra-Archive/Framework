<?php
class usuario_social_Modelo extends \Framework\App\Modelo
{
    public function __construct(){
        parent::__construct();
    }
    /*
    * Função para gravar Relações entre tables e usuario_social, é uma funcao static e é chamada por diversos oturos modulos
    * 
    * @name Inserir_Pers_Relacao
    * @access public
    * @static
    * 
    * @param Class $model Carrega por Ponteiro Modelo Atual
    * @param Int $user Id do Usuario admin do sistema
    * @param String $tabela Nome da Tabela que vai se relacionar com a persona
    * @param Int $tabela_id Id do Usuario admin do sistema
    * @param Int $persona Id do Usuario admin do sistema
    * 
    * @uses $config
    * @uses MYSQL_USUARIO_SOCIAL_RELACOES
    * 
    * @return int Retorna 1 se insercao for concluida com sucesso. 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public static function Inserir_Pers_Relacao(&$model, $user, $tabela, $tabela_id, $persona){
        GLOBAL $config;
        $model->db->query('INSERT INTO '.MYSQL_USUARIO_SOCIAL_RELACOES.' (user,tabela,tabela_id,persona,log_date_add) VALUES (\''.$user.'\',\''.$tabela.'\',\''.$tabela_id.'\',\''.$persona.'\',\''.APP_HORA.'\')');
        return 1;
    }
    public function porc_ficar($personaid){
        $usuario_id = \Framework\App\Acl::Usuario_GetID_Static();
        $sql = $this->db->query('SELECT COUNT(id) as total, id FROM '.MYSQL_USUARIO_SOCIAL_ACAO.' WHERE deletado!=1 AND tipo=1 && user=\''.$usuario_id.'\' && persona=\''.$personaid.'\' ORDER BY data');
        while($campo = $sql->fetch_object()){
            $id = $campo->id;
            $fiquei = $campo->total;
        }
        $sql = $this->db->query('SELECT COUNT(id) as total FROM '.MYSQL_USUARIO_SOCIAL_ACAO.' WHERE deletado!=1 AND id>id && user=\''.$usuario_id.'\' && persona=\''.$personaid.'\' ORDER BY tipo');
        while($campo = $sql->fetch_object()){
            $dps = $campo->total;
        }
        if($total!=0)$porc = 100-($dps/$fiquei*100);
        else $porc = 100;
        return $porc;
    }
    public function porc_confiar($personaid){
        $usuario_id = \Framework\App\Acl::Usuario_GetID_Static();
        //$re = 
        $sql = $this->db->query('SELECT COUNT(id) as total FROM '.MYSQL_USUARIO_SOCIAL_ACAO.' WHERE deletado!=1 AND tipo=3 && user=\''.$usuario_id.'\' && persona=\''.$personaid.'\' ORDER BY tipo');
        while($campo = $sql->fetch_object()){
                $mentiras = $campo->total;
        }
        $sql2 = $this->db->query('SELECT COUNT(id) as total FROM '.MYSQL_USUARIO_SOCIAL_ACAO.' WHERE deletado!=1 AND user=\''.$usuario_id.'\' && persona=\''.$personaid.'\' ORDER BY tipo');
        while($campo = $sql2->fetch_object()){
                $total = $campo->total;
        }
        if($total!=0)$porc = 100-($mentiras/$total*100);
        else $porc = 100;
        return $porc;
    }
    public function porc_amizade($personaid){
        $usuario_id = \Framework\App\Acl::Usuario_GetID_Static();
        $sql = $this->db->query('SELECT COUNT(id) as total FROM '.MYSQL_USUARIO_SOCIAL_ACAO.' WHERE deletado!=1 AND tipo=6 && user=\''.$usuario_id.'\' && persona=\''.$personaid.'\' ORDER BY tipo');
        while($campo = $sql->fetch_object()){
            $chata = $campo->total;
        }
        $sql2 = $this->db->query('SELECT COUNT(id) as total FROM '.MYSQL_USUARIO_SOCIAL_ACAO.' WHERE deletado!=1 AND user=\''.$usuario_id.'\' && persona=\''.$personaid.'\' ORDER BY tipo');
        while($campo = $sql2->fetch_object()){
            $total = $campo->total;
        }
        if($total!=0)$porc = 100-($chata/$total*100);
        else $porc = 100;
        return $porc;
    }
    public function retorna_usuario_social(&$usuario_social, $usuario_id=0){
        if($usuario_id==0){
            $usuario_id = \Framework\App\Acl::Usuario_GetID_Static(); 
        }
        $sql = $this->db->query('SELECT id, id_face, nome, fis_sexo, nasc, email, posicao, situacao, celular FROM '.MYSQL_USUARIO_SOCIAL.' WHERE deletado!=1 AND user=\''.$usuario_id.'\' ORDER BY nome');
        $i=0;
        while ($campo = $sql->fetch_object()) {
            $persona_pontos = 0;
            $personaid = $campo->id;
            /*$sql2 = $this->db->query("SELECT positivo, gravidade FROM '.MYSQL_USUARIO_SOCIAL_ACAO.' WHERE user=\''.$usuario_id.'\' && persona=\''.$personaid.'\' ORDER BY tipo");
            while($campo2 = $sql2->fetch_object()){
                    if($campo2->positivo==0) $persona_pontos = $persona_pontos - $campo2->gravidade;
                    else   $persona_pontos = $persona_pontos + $campo2->gravidade;
            }*/
            $usuario_social[$i]['id'] = $personaid;
            $usuario_social[$i]['id_face'] = $campo->id_face;
            $usuario_social[$i]['nome'] = $campo->nome;
            $usuario_social[$i]['fis_sexo'] = $campo->fis_sexo;
            $usuario_social[$i]['nasc'] = $campo->nasc;
            $usuario_social[$i]['email'] = $campo->email;
            $usuario_social[$i]['pontos'] = $persona_pontos;
            $usuario_social[$i]['posicao'] = $campo->posicao;
            $usuario_social[$i]['situacao'] = $campo->situacao;
            $usuario_social[$i]['celular'] = $campo->celular;
            ++$i;
        }
    } 
    public function retorna_acoes($personaid,&$acoes){
        $usuario_id = \Framework\App\Acl::Usuario_GetID_Static();
        $sql = $this->db->query('SELECT * FROM '.MYSQL_USUARIO_SOCIAL_ACAO.' WHERE deletado!=1 AND user=\''.$usuario_id.'\' && persona=\''.$personaid.'\' ORDER BY tipo');
        $i=0;
        while($campo = $sql->fetch_object()){
            if($campo->positivo==0) $persona_pontos = $persona_pontos - $campo->gravidade;
            else   $persona_pontos = $persona_pontos + $campo->gravidade;

            $tipo = $campo->tipo;
            $data = $campo->data;
            $sql2 = $this->db->query('SELECT * FROM '.MYSQL_USUARIO_SOCIAL_TIPO.' WHERE deletado!=1 AND id=\''.$tipo.'\' && user=\''.$usuario_id.'\' LIMIT 1');
            while($campo2 = $sql2->fetch_object()){
                $tiponome = $campo2->nome;
            }
            $acoes[$i]['data'] = $data;
            $acoes[$i]['tipo'] = $tipo;
            $acoes[$i]['tiponome'] = $tiponome;
            $acoes[$i]['obs'] = $campo->obs;
            $acoes[$i]['positivo'] = $campo->positivo;
            $acoes[$i]['gravidade'] = $campo->gravidade;
            ++$i;
        }
    } 
    public function estatisticas(){

    }
}
?>