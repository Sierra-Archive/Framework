<?php
class categoria_categoriaModelo extends categoria_Modelo
{

    public function __construct() {
        parent::__construct();
    } 
    /**
     * Alterar Categoria
     * 
     * @name Categorias_alterar
     * @access public
     * 
     * @global type $tabsql
     * @param int $id Chave Primária (Id do Registro)
     * @param type $nome
     * @param type $categoria
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Categorias_alterar($id,$nome,$parent,$tipo) {
        global $config;
        $this->db->query('UPDATE '.MYSQL_CAT.' SET parent=\''.$parent.'\', nome=\''.$nome.'\' WHERE deletado!=1 AND servidor=\''.SRV_NAME_SQL.'\' && id='.$id);
        // Insere tipo caso este tenha sido trocado
        $cont = 0;
        $sql = $this->db->query('SELECT categoria FROM '.MYSQL_CAT_ACESSO.' WHERE deletado!=1 AND servidor=\''.SRV_NAME_SQL.'\' && categoria=\''.$id.'\' AND mod_acc=\''.$tipo.'\' LIMIT 1');
        while($campo = $sql->fetch_object()) {
            ++$cont;
        }
        if ($cont==0) $this->db->query('INSERT INTO '.MYSQL_CAT_ACESSO.' (servidor,categoria,mod_acc,log_date_add,user_criacao) VALUES (\''.SRV_NAME_SQL.'\',\''.$id.'\',\''.$tipo.'\',\''.APP_HORA.'\',\''.\Framework\App\Acl::Usuario_GetID_Static().'\')');
        return 1;
    }
    /**
     * 
     * @global type $tabsql
     * @param int $id Chave Primária (Id do Registro)
     * @return int
     */
    public function Categoria_Retorna($id)
    {
        $array = array();
        $i = 0; 
        $extra = '';
        
        // Nao serao ixibidos categorias com subsessao qnd for cadastro
        if ($cadastro==1) $extra = ' AND subtab=""';
        $sql = $this->db->query('SELECT parent, nome FROM '.MYSQL_CAT.' WHERE deletado!=1 AND servidor=\''.SRV_NAME_SQL.'\' && id=\''.$id.'\'');
        while($campo = $sql->fetch_object()) {
            $array['parent'] = $campo->parent;
            $array['nome'] = $campo->nome;

            ++$i;
        }
        if ($i>0)        return $array; 
        else            return 0;
    }
    /**
     * Inseri nova Categoria
     * 
     * @name Categorias_inserir
     * @access public
     * 
     * @param string $nome Nome da Categoria
     * @param int $categoria Categoria Pai
     * @param string $tipo Tipo da Categoria
     * 
     * @uses $tabsql
     * @uses $config
     * @uses \Framework\App\Modelo::$db
     * 
     * @return 1
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Categorias_inserir($nome,$parent,$tipo,$subtab='') {
        global $config;
        $this->db->query('INSERT INTO '.MYSQL_CAT.' (servidor,parent,nome,subtab,log_date_add,user) VALUES (\''.SRV_NAME_SQL.'\',\''.$parent.'\',\''.$nome.'\',\''.$subtab.'\',\''.APP_HORA.'\',\''.\Framework\App\Acl::Usuario_GetID_Static().'\')');
        $sql = $this->db->query('SELECT id FROM '.MYSQL_CAT.' WHERE deletado!=1 AND servidor=\''.SRV_NAME_SQL.'\' && parent=\''.$parent.'\' AND log_date_add=\''.APP_HORA.'\' AND nome=\''.$nome.'\' AND subtab=\''.$subtab.'\' ORDER BY id DESC LIMIT 1');
        while($campo = $sql->fetch_object()) {
            $categoria = $campo->id;
        }
        $this->db->query('INSERT INTO '.MYSQL_CAT_ACESSO.' (servidor,categoria,mod_acc,log_date_add,user_criacao) VALUES (\''.SRV_NAME_SQL.'\',\''.$categoria.'\',\''.$tipo.'\',\''.APP_HORA.'\',\''.\Framework\App\Acl::Usuario_GetID_Static().'\')');
        return 1;
    }
}
?>