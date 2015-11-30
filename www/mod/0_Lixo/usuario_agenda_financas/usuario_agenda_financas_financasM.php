<?php
class Agenda_financas_financasModelo extends Agenda_financas_Modelo
{

    public function __construct(){
        parent::__construct();
	//$this->_Modelo = new usuarios_loginModelo();
        //$this->_Visual = new usuarios_loginVisual();
    } 
    // retorna todos os movimentos financeiros
    public function retorna_financeiro(&$financas,$ano = 0,$mes = 0, $dia = 0){
        $usuario_id = \Framework\App\Acl::Usuario_GetID_Static();
        $i = 0;
        $mysqlwhere = '';

        // pega financas geral
        if($ano!=0){
            // pega finan�as do ano
            if($mes==0 && $dia==0){
                    $data_iniciali = $ano.'-00-00';
                    $config_dataf = $ano.'-12-31';
            }
            // pega finan�as do mes
            elseif($dia==0){
                    $data_iniciali = $ano.'-'.$mes.'-00';
                    $config_dataf = $ano.'-'.$mes.'-31';
            }
            // pega finan�as do dia
            if($ano!=0 && $mes!=0 && $dia!=0){
                    $config_data = $ano.'-'.$mes.'-'.$dia;
                    $mysqlwhere .= ' && UAF.data=\''.$config_data.'\'';	
            }else{
                    $mysqlwhere .= ' && UAF.data BETWEEN (\''.$data_iniciali.'\') AND (\''.$config_dataf.'\')';
            }
        }
        $sql = $this->db->query('SELECT UAF.id, UAF.valor, UAF.data, UAF.positivo, UAF.obs, UAF.categoria_sub, C.subtab, C.nome
        FROM '.MYSQL_USUARIO_AGENDA_FINANCAS.' UAF, '.MYSQL_CAT.' C 
        WHERE UAF.deletado!=1 AND UAF.user='.$usuario_id.' && UAF.categoria=C.id'.$mysqlwhere.' ORDER BY UAF.data DESC'); //UAF.categoria
        while ($campo = $sql->fetch_object()) {
            $persona_pontos = 0;
            //$tipo = $campo->tipo;
            if($campo->categoria_sub!=0 && $campo->subtab!=''){
                $sql2 = $this->db->query('SELECT id, nome FROM '.$campo->subtab.' WHERE deletado!=1 AND id='.$campo->categoria_sub.' AND user='.\Framework\App\Acl::Usuario_GetID_Static());
                while($campo2 = $sql2->fetch_object()){
                    $financas[$i]['categoria'] = $campo2->nome;
                }
            }else{
                $financas[$i]['categoria'] = $campo->nome;
            }
            $financas[$i]['id'] = $campo->id;
            $financas[$i]['valor'] = $campo->valor;
            $financas[$i]['data'] = date_replace($campo->data, "d/m/y");
            $financas[$i]['positivo'] = $campo->positivo;
            $financas[$i]['obs'] = $campo->obs;
            ++$i;
        }
        return $i;
    } 
    // && C.parent=0
    // retorna os movimentos financeiros por tipo
    public function retorna_financeiro_categorias(&$array,$parent = 0,$ano = 0,$mes = 0, $dia = 0,$nivel=0, $positivo=0, $niveltitulo='Pasta Raiz'){
        $financa = 0;
        $usuario_id = \Framework\App\Acl::Usuario_GetID_Static();		
        $saldo = 0;
        $mysqlwhere = '';

        //calcula o espaço antes do nome
        $antecipa = $nivel;
        $nomeantes = '';
        $j = 0;
        while($antecipa>0){
            --$antecipa;
            $nomeantes = $nomeantes.'— ';
        }

        // pega financas geral
        if($ano!=0){
            // pega finan�as do ano
            if($mes==0 && $dia==0){
                    $data_iniciali = $ano.'-00-00';
                    $config_dataf = $ano.'-12-31';
            }
            // pega finan�as do mes
            elseif($dia==0){
                    $data_iniciali = $ano.'-'.$mes.'-00';
                    $config_dataf = $ano.'-'.$mes.'-31';
            }
            // pega finan�as do dia
            if($ano!=0 && $mes!=0 && $dia!=0){
                    $config_data = $ano.'-'.$mes.'-'.$dia;
                    $mysqlwhere .= ' && UAF.data=\''.$config_data.'\'';	
            }else{
                    $mysqlwhere .= ' && UAF.data BETWEEN (\''.$data_iniciali.'\') AND (\''.$config_dataf.'\')';
            }
        }
        $sql2 = $this->db->query('SELECT C.id, C.nome FROM '.MYSQL_CAT.' C WHERE C.deletado!=1 AND C.user='.$usuario_id.' && C.parent='.$parent.' ORDER BY C.nome');
        while ($campo2 = $sql2->fetch_object()) {
            $cat = $campo2->id;

            if(!isset($array[$cat]['nome'])) $array[$cat]['nome'] = /*$nomeantes.*/$campo2->nome;
            if(!isset($array[$cat]['valor'])) $array[$cat]['valor'] = 0;
            if(!isset($array[$cat]['parent'])) $array[$cat]['parent'] = $parent;
            if(!isset($array[$cat]['parent_nome'])) $array[$cat]['parent_nome'] = $niveltitulo;


            $sql = $this->db->query('SELECT UAF.valor, UAF.positivo, C.nome
            FROM '.MYSQL_USUARIO_AGENDA_FINANCAS.' UAF, '.MYSQL_CAT.' C WHERE UAF.deletado!=1 AND UAF.user='.$usuario_id.' && C.id='.$cat.' && UAF.positivo='.$positivo.' && UAF.categoria=C.id'.$mysqlwhere.' ORDER BY UAF.categoria');
            while ($campo = $sql->fetch_object()) {
                if($campo->positivo!=0){
                        $array[$cat]['valor'] += $campo->valor;
                        $saldo += $campo->valor;
                }else{
                        $array[$cat]['valor'] -= $campo->valor;
                        $saldo  -= $campo->valor;
                }
            }
            $financa = $this->retorna_financeiro_categorias($array,$cat,$ano,$mes,$dia,$nivel+1, $positivo, $campo2->nome);

            //if($financa>=0){
                    $array[$cat]['valor'] += $financa;
                    $saldo += $financa;
            /*}else{
                    $array[$cat]['valor'] -= $financa;
                    $saldo  -= $financa;
            }*/
        }
        return $saldo;
    }
    public function financas_inserir($data,$valor,$positivo,$categoria,$usuario_social,$obs){
        global $tabsql, $config;

        // verifica se contem subcategoria
        if(stripos($categoria, '-')){
            $categoria = explode('-',$categoria);
            $subcat = $categoria[1];
            $categoria = $categoria[0];
        }else{
            $subcat = 0;
        }

        $this->db->query('INSERT INTO '.$tabsql['Agenda_financas'].' (user,categoria,categoria_sub,persona,valor,positivo,data,obs,log_date_add) VALUES (\''.\Framework\App\Acl::Usuario_GetID_Static().'\',\''.$categoria.'\',\''.$subcat.'\',\''.$usuario_social.'\',\''.$valor.'\',\''.$positivo.'\',\''.$data.'\',\''.$obs.'\',\''.APP_HORA.'\')');
        return 1;
    }
    public function financas_del($id){
        global $tabsql, $config;
        $this->db->query('DELETE FROM '.$tabsql['Agenda_financas'].' WHERE deletado!=1 AND id='.$id);
        return 1;
    }
    
}
?>