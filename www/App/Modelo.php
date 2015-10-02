<?php
namespace Framework\App;
/**
 * Class Pai dos Modelos, Responsavél pelo tratamento e exibicoes dos Dados do Sistema
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
class Modelo
{
    public              $usuario;
    public              $_Registro;
    public              $db;    
    public              $_request;    
    public              $_Cache;    
    public              $_Acl;    
    public      static  $config = false;    
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Conexao Carrega Conexao Mysql da Requisicao
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct(){
        $this->_Registro = &\Framework\App\Registro::getInstacia();
        $this->db = &$this->_Registro->_Conexao;
        $this->_request     = &$this->_Registro->_Request;
        $this->_Cache       = &$this->_Registro->_Cache;
        $this->_Acl         = &$this->_Registro->_Acl;
        
        return 0;
    }
    /**
     * 
     * @param type $parent
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Sistema_Menu($parent=0){
        $where = Array('parent'=>$parent, 'status'  =>    '1');
        $menu = $this->db->Sql_Select('Sistema_Menu',$where,0,'','id,link,ext,nome,img,icon,gravidade');
        if($menu===false && $parent==0){
            $configmenu = \Framework\App\Acl::Sistema_Modulos_Carregar_Menu();
            $this->Sistema_Menu_Insere($configmenu);
            // fim da Leitura
            // Começa a carregar no banco de dados
            $menu = $this->db->Sql_Select('Sistema_Menu',$where);
        }
        
        if($menu===false)           return false;
        if(is_object($menu))        $menu = Array($menu);
        // Verifica todos valores e acrescenta os corretos
        foreach($menu as $indice=>&$valor){
            if(strpos($valor->link, 'www.')!==false || strpos($valor->link, 'http:')!==false){
                $valor->link            = $valor->link;
                $valor->ext            = true;
            }else{
                $valor->link            = URL_PATH.$valor->link;
                $valor->ext            = false;
            }
            $valor->ativo           = 0;
            $valor->filhos          = $this->Sistema_Menu($valor->id);
        }
        if(empty($menu)) return false;
        $menu = \Framework\App\Sistema_Funcoes::Transf_Object_Array($menu);
        orderMultiDimensionalArray($menu, 'gravidade', true);
        return $menu;
    }
    /**
     * 
     * @param type $menu
     * @param type $modulo
     * @param type $parent
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    protected function Sistema_Menu_Insere(&$menu,$modulo='_Sistema',$parent=0){
        
        $parent = (int) $parent;
        if(!is_int($parent)) $parent = 0;
        if(!is_array($menu) || empty($menu)) return false;
        foreach($menu as &$valor){
            // Inicia Dao Inserir
            $inserir                = new \Sistema_Menu_DAO();
            // Se nao existir cria erro
            if(!isset($valor['Link'])){
                throw new \Exception('Erro no Código: '.  serialize($valor),2800);
            }
            // SE for Duplo, pega só um 
            if(is_array($valor['Link']))         $valor['Link']         = $valor['Link'][0];
            if(is_array($valor['Nome']))         $valor['Nome']         = $valor['Nome'][0];
            if(is_array($valor['Img']))          $valor['Img']          = $valor['Img'][0];
            if(is_array($valor['Icon']))         $valor['Icon']         = $valor['Icon'][0];
            if(is_array($valor['Gravidade']))    $valor['Gravidade']    = $valor['Gravidade'][0];
            if(isset($valor['Filhos']) && is_array($valor['Filhos']) && isset($valor['Filhos'][0]) && $valor['Filhos'][0]===false){
                $valor['Filhos']     = false;
            }
            
            
            // Trata Link
            $linkdividido           = explode('/',$valor['Link']);
            $inserir->parent        = $parent;
            $tamanho_link = count($linkdividido);
            if($tamanho_link>0){
                $inserir->modulo        = $linkdividido[0];
            }else{
                $inserir->modulo        = '*';
            }
            if($tamanho_link>1){
                $inserir->submodulo     = $linkdividido[1];
            }else{
                $inserir->submodulo        = '*';
            }
            if($tamanho_link>2){
                $inserir->metodo        = $linkdividido[2];
            }else{
                $inserir->metodo        = '*';
            }
            // Grava o Resto 
            $inserir->link          = $valor['Link'];
            $inserir->nome          = $valor['Nome'];
            $inserir->img           = $valor['Img'];
            $inserir->icon          = $valor['Icon'];
            $inserir->gravidade     = $valor['Gravidade'];
            $inserir->status        = '1';
            
            $trava = false;
            if(isset($valor['Permissao_Func']) && is_array($valor['Permissao_Func'])){
                foreach($valor['Permissao_Func'] as $indicepermfunc=>&$permfunc){
                    if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional($indicepermfunc)!==$permfunc){
                        $trava = true;
                    }
                }
            }
            if($trava) continue;
            
            // Insere e Faz recursividade para os filhos
            $this->db->Sql_Inserir($inserir);
            if(isset($valor['Filhos']) && $valor['Filhos']!==false && is_array($valor['Filhos'])) {
                $identificador  = $this->db->Sql_Select('Sistema_Menu', Array(),1,'id DESC');
                $identificador  = $identificador->id;
                
                $this->Sistema_Menu_Insere($valor['Filhos'],$modulo,$identificador);
            }
        }
        return true;
    }
    /**
     * Função Responsavel por Preencher as Opções para Form generico
     * 
     * @param type $array
     * @param type $opcoes
     * @param type $padrao
     * @param type $i
     * @param type $nivel
     * @return type
     */
    public function Categorias_Carrega_Opcoes(&$array,&$opcoes,$i=0,$nivel=0){
        $antecipa = $nivel;
        $nomeantes = '';
        $j = 0;
        while($antecipa>0){
            --$antecipa;
            $nomeantes = $nomeantes.'— ';
        }
        if(!empty($array)){
              reset($array);
              foreach ($array as &$valor) {
                $opcoes[] = array(
                    'value' =>  $valor['id'],
                    'nome' => $nomeantes.$valor['nome']
                );
                ++$i;
                if(!empty($array[$j]['filhos'])){
                    $i = $this->Categorias_ShowSelect($array[$j]['filhos'],$form,$padrao,$i,$nivel+1);
                }
                ++$j;
              }
          }
        return $i;
    }
    /**
    * MODULO CATEGORIA
    * 
    * COndicoes:
    * Se cadastro=1 não sera ixibidos todas as subcategorias que tiverem subsessao
    *
    * Retorna Todas as Categorias
    * 
    * @name Categorias_Retorna
    * @access public
    * 
    * @param string $tipo Tipo das Categorias
    * @param int $categoria Id da Categoria Pai
    * @param int $cadastro Se � cadastro ou nao
    * 
    * @uses $tabsql
    * @uses \Framework\App\Modelo::$db
    * @uses \Framework\App\Modelo::$usuario
    * @uses \Framework\App\Modelo::$Categorias_Permissoes
    * @uses \Framework\App\Modelo::$Categorias_RetornaSub
    * @uses \Framework\App\Modelo::$Categorias_Retorna
    * 
    * @return Array $array
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Categorias_Retorna($tipo='',$parent=0, $cadastro=0)
    {
        $array = array();
        $i = 0; 
        $extra = '';
        
        // Nao serao ixibidos categorias com subsessao qnd for cadastro
        if($cadastro==1) $extra = ' AND C.subtab=""';
        if($tipo==''){
            $sql = 'SELECT C.id, C.nome, C.subtab FROM '.MYSQL_CAT.' C WHERE C.deletado!=1 AND C.servidor=\''.SRV_NAME_SQL.'\' AND C.parent='.$parent.$extra. ' ORDER BY C.nome';
        }else{
            $sql = 'SELECT C.id, C.nome, C.subtab FROM '.MYSQL_CAT.' C, '.MYSQL_CAT_ACESSO.' CA WHERE C.deletado!=1 AND CA.deletado!=1 AND C.servidor=\''.SRV_NAME_SQL.'\' AND CA.categoria=C.id AND CA.mod_acc=\''.$tipo.'\' AND C.parent='.$parent.$extra. ' AND CA.deletado!=1 ORDER BY C.nome';
        }
        $sql = $this->db->query($sql);
        while($campo = $sql->fetch_object()){
            if($campo->id!=0&&$campo->id!='0'){
                $array[$i]['id'] = $campo->id;
                $array[$i]['nome'] = $campo->nome;
                if($cadastro==0){
                    $array[$i]['acesso'] = $this->Categorias_Permissoes($campo->id);
                    if($campo->subtab!=''){
                        $array[$i]['filhos'] = $this->Categorias_RetornaSub($campo->id,$campo->subtab, $array[$i]['acesso']);
                    }else{
                        $array[$i]['filhos'] = $this->Categorias_Retorna($tipo,$campo->id, $cadastro);
                    }
                }else{
                    $array[$i]['filhos'] = $this->Categorias_Retorna($tipo,$campo->id, $cadastro);
                }

                ++$i;
            }
        }
        if($i>0)        return $array; 
        else            return 0;
    }
    /**
    * CArrega as Permissoes de Cada Categoria
    * 
    * @name Categorias_Permissoes
    * @access public
    * 
    * @param int $categoria Id da Categoria
    * 
    * @uses MYSQL_CAT_ACESSO
    * @uses \Framework\App\Modelo::$usuario
    * 
    * @return Array $array
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Categorias_Permissoes($categoria='')
    {
        if($categoria=='') return 0;
        $array = array();
        $i = 0; 
        $sql = $this->db->query('SELECT CA.mod_acc FROM '.MYSQL_CAT_ACESSO.' CA WHERE CA.servidor=\''.SRV_NAME_SQL.'\' AND CA.deletado!=1 AND CA.categoria=\''.$categoria.'\'');
        while($campo = $sql->fetch_object()){
              $array[$i] = $campo->mod_acc;
              ++$i;
        }
        if($i>0)        return $array; 
        else            return 0;
    }
    /**
    * Retorna Subcategorias que sao de outras tabelas
    * 
    * @name Categorias_RetornaSub
    * @access public
    * 
    * @param int $categoria Id da Categoria Pai
    * @param string $subtab Nome da Tabela
    * @param Array $acesso
    * 
    * @uses \Framework\App\Modelo::$db
    * @uses \Framework\App\Modelo::$usuario
    * 
    * @return Array $array
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Categorias_RetornaSub($categoria, $subtab, $acesso)
    {
        $array = array();
        $i = 0; 
        
        $sql = $this->db->query('SELECT id, nome FROM '.$subtab.' WHERE servidor=\''.SRV_NAME_SQL.'\' AND deletado!=1');
        while($campo = $sql->fetch_object()){
            $array[$i]['id'] = $categoria.'-'.$campo->id;
            $array[$i]['nome'] = $campo->nome;
            $array[$i]['filhos'] = 0;
            $array[$i]['acesso'] = $acesso;
            ++$i;
        }
        if($i>0)        return $array; 
        else            return 0;
    }
}
?>
