<?php
class locais_localidadesModelo extends locais_Modelo
{

    public function __construct(){
        parent::__construct();
    }
	
    public function bairro_inserir($pais,$estado,$cidade,$zona,$nome){
        global $tabsql, $config;
        $this->db->query('INSERT INTO '.MYSQL_SIS_LOCALIZACAO_BAIRROS.' (pais,estado,cidade,zona,nome,info_cadastrodata,info_cadastrouser) VALUES (\''.$pais.'\', \''.$estado.'\', \''.$cidade.'\', \''.$zona.'\', \''.$nome.'\', \''.APP_HORA.'\', \''.\Framework\App\Acl::Usuario_GetID_Static().'\')');
        return 1;
    }
    public function cidade_inserir($pais,$estado,$nome){
        global $tabsql, $config;
        $this->db->query('INSERT INTO '.MYSQL_SIS_LOCALIZACAO_CIDADES.' (pais,estado,nome,info_cadastrodata,info_cadastrouser) VALUES (\''.$pais.'\', \''.$estado.'\', \''.$nome.'\', \''.APP_HORA.'\', \''.\Framework\App\Acl::Usuario_GetID_Static().'\')');
        return 1;
    }
    public function estado_inserir($pais,$sigla,$nome){
        global $tabsql, $config;
        $this->db->query('INSERT INTO '.MYSQL_SIS_LOCALIZACAO_ESTADOS.' (pais,nome,sigla,info_cadastrodata,info_cadastrouser) VALUES (\''.$pais.'\', \''.$nome.'\', \''.$sigla.'\', \''.APP_HORA.'\', \''.\Framework\App\Acl::Usuario_GetID_Static().'\')');
        return 1;
    }
    public function pais_inserir($nome){
        global $tabsql, $config;
        $this->db->query('INSERT INTO '.MYSQL_SIS_LOCALIZACAO_PAIZES.' (nome,info_cadastrodata,info_cadastrouser) VALUES (\''.$nome.'\', \''.APP_HORA.'\', \''.\Framework\App\Acl::Usuario_GetID_Static().'\')');
        return 1;
    }
}
?>