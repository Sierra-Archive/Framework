<?php
class locais_localModelo extends locais_Modelo
{

    public function __construct() {
        parent::__construct();
    }
    public function local_retorna($id) {
        global $tabsql;
        if (empty($id)) exit;
        $sql = $this->db->query('SELECT L.nome, L.endereco, L.numero, B.nome as BAIRRO, C.nome as CIDADE, E.sigla as ESTADO FROM (('.MYSQL_SIS_LOCAIS.' L JOIN '.MYSQL_SIS_LOCALIZACAO_BAIRROS.' B on (L.bairro=B.id)) JOIN '.MYSQL_SIS_LOCALIZACAO_CIDADES.' C on (B.cidade=C.id)) JOIN '.MYSQL_SIS_LOCALIZACAO_ESTADOS.' E on (C.estado=E.id) WHERE L.deletado!=1 AND L.id='.$id.' LIMIT 1');
        while($campo = $sql->fetch_object()) {
                  $array['nome'] = $campo->nome;
                  $array['endereco'] = $campo->endereco;
                  $array['numero'] = $campo->numero;
                  $array['bairro'] = $campo->BAIRRO;
                  $array['cidade'] = $campo->CIDADE;
                  $array['estado'] = $campo->ESTADO;
        }
        return $array;
    }
}
?>