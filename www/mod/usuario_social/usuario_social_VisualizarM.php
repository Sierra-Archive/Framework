<?php
class usuario_social_VisualizarModelo extends usuario_social_Modelo
{

    public function __construct(){
        parent::__construct();
    } 
    public function retorna_persona($id){
        $usuario_id = \Framework\App\Acl::Usuario_GetID_Static();
        $por_chata = $this->porc_amizade($id);
        $por_confiar = $this->porc_confiar($id);
        $por_ficar = $this->porc_ficar($id);

        $sql = $this->db->query('SELECT id_face, nome, fis_sexo, posicao FROM '.MYSQL_USUARIO_SOCIAL.' WHERE deletado!=1 AND id=\''.$id.'\' && user=\''.$usuario_id.'\' ORDER BY nome LIMIT 1');
        while ($campo = $sql->fetch_object()) {
            $persona_pontos = 0;
            $personaid = $campo->id;
            /*$sql2 = $this->db->query("SELECT positivo, gravidade FROM MYSQL_USUARIO_SOCIAL_ACAO WHERE user='$usuario_id' && persona='$personaid' ORDER BY tipo");
            while($campo2 = $sql2->fetch_object()){
                if($campo2->positivo==0) $persona_pontos = $persona_pontos - $campo2->gravidade;
                else   $persona_pontos = $persona_pontos + $campo2->gravidade;
            }*/
            $persona['id'] = $personaid;
            $persona['id_face'] = $campo->id_face;
            $persona['nome'] = $campo->nome;
            $persona['fis_sexo'] = $campo->fis_sexo;
            $persona['nasc'] = $campo->nasc;
            $persona['pontos'] = $persona_pontos;
            $persona['posicao'] = $campo->posicao;
            $persona['por_chata'] = $por_chata;
            $persona['por_chata'] = $por_chata;
            $persona['por_chata'] = $por_chata;
            $persona['por_confiar'] = $por_confiar;
            $persona['por_ficar'] = $por_ficar;

            return $persona;
        }
    } 
}
?>