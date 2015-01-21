<?php
namespace Framework\App;
/**
 * Class de Controle de Acesso
 * 
 * E controle de Configuracoes, e suas permissoes de acesso
 *
 */
class Acl{
    // Informacoes de Login
    public  $logado;
    public  $logado_usuario;
    
    // Id de Usuario, Grupo e Permissoes
    private $_id;
    private $_grupo;
    private $_permissao = Array();
    
    // Permissoes do Sistema
    public static $Sis_Permissao = false;
    
    // Registro e banco de dados
    private $_Registro;
    private $_db;
    private $_Request;
    
    // Configuracoes
    public      static  $config = false;    
    
    public function __construct($id = false) {
        $tempo = new \Framework\App\Tempo('ACl');   
        
        // Recupera Registro
        $this->_Registro    = &\Framework\App\Registro::getInstacia();
        $this->_db          = &$this->_Registro->_Conexao;
        $this->_Request     = &$this->_Registro->_Request;
        $tempo = new \Framework\App\Tempo('Acl - Construct');
        if($id!==false){
            // Caso esteja carregando de outro usuario
            $this->_id = (int) $id;
        }else{
            // Caso LOGIN
            if(\Framework\App\Session::get(SESSION_ADMIN_ID)){
                $this->_id =  (int) \Framework\App\Session::get(SESSION_ADMIN_ID);
            }else{
                $this->_id = 0; // Nao esta logado
            }
            
            
            // Começa Teste Login
            
            // verifica se foi pedido o logout
            if(isset($_GET['logout'])) $logout = 'sair';
            else                       $logout = false;
            // Caso Tenha Pedido Pra sair, SAIR
            if($logout==='sair'){
                \Framework\App\Session::destroy(false);
                $this->logado           = false;
                $Visual = new \Framework\App\Visual();
                $Visual->renderizar_login(/*$this->calendario,$this->config_dia,$this->config_mes,$this->config_ano,$this->config_dataixi*/);
                \Framework\App\Controle::Tema_Travar();
            }else
            // CASO NAO TENHA FEITO LOGIN, E NEM PREENCHIDO O 
            if(!isset($_POST['sistema_login']) && !isset($_POST['sistema_senha']) && \Framework\App\Session::get(SESSION_ADMIN_LOG)===false && \Framework\App\Session::get(SESSION_ADMIN_SENHA)===false){
                $this->logado           = false;
            }else
            // Caso nao tenha sessao quer dizer que tem POST
            // se nao tiver sessao, verifica se o post foi acessado, caso contrario verifica se a sessao corresponde ao usuario e senha
            if(isset($_POST['sistema_login']) && isset($_POST['sistema_senha']) && (\Framework\App\Session::get(SESSION_ADMIN_LOG)===false || \Framework\App\Session::get(SESSION_ADMIN_SENHA)===false || \Framework\App\Session::get(SESSION_ADMIN_LOG)=='' || \Framework\App\Session::get(SESSION_ADMIN_SENHA)=='')){
                // Puxa Login E senha e verifica cadastro
                $login = \anti_injection($_POST['sistema_login']);
                $senha = \Framework\App\Sistema_Funcoes::Form_Senha_Blindar($_POST['sistema_senha']);
                //var_dump($login,$senha);
                $this->logado = $this->Usuario_Senha_Verificar($login, $senha);
                
                // Avisa se login nao teve resultado
                if($this->logado===false){
                    // Verifica se Possui Modulo PRedial e corresponde a um Apartamento sem nenhum cadastro
                    if(\Framework\App\Sistema_Funcoes::Perm_Modulos('predial') && $senha == 'd41d8cd98f00b204e9800998ecf8427e' && strpos($login, '/')!==false){
                        $login = explode($login, '/');
                        $where = Array(
                            'nome'             => $login[1],
                        );
                        $bloco    = $this->_db->Sql_Select(  
                            'Predial_Bloco',            
                            $where,
                            1
                        );
                        if($bloco===false){
                            _Sistema_erroControle::Erro_Puro(5062);
                        }else{
                            $where = Array(
                                'num'            => $login[0],
                                'bloco'         => $bloco->id
                            );
                            $apartamento    = $this->_db->Sql_Select(  
                                'Predial_Bloco_Apart',            
                                $where,
                                1
                            );
                            if($apartamento!==false){
                                if($apartamento->morador==0){
                                    $Visual = new \Framework\App\Visual();
                                    $Visual->renderizar();
                                    \Framework\App\Controle::Tema_Travar();
                                }else{
                                    _Sistema_erroControle::Erro_Puro(5060);
                                }
                            }else{
                                _Sistema_erroControle::Erro_Puro(5061);
                            }
                        }
                    }
                    // Deleta Sessoes e Puxa Erro
                    \Framework\App\Session::destroy(SESSION_ADMIN_ID);
                    \Framework\App\Session::destroy(SESSION_ADMIN_LOG);
                    \Framework\App\Session::destroy(SESSION_ADMIN_SENHA);
                    \Framework\App\Sistema_Funcoes::Erro('5051');
                }else{
                    $this->_id = \Framework\App\Session::get(SESSION_ADMIN_ID);
                }
            }else{
                $usuario = \Framework\App\Session::get(SESSION_ADMIN_LOG);
                $senha   = \Framework\App\Session::get(SESSION_ADMIN_SENHA);
                $this->logado = $this->Usuario_Senha_Verificar($usuario, $senha);

                // Avisa se login nao teve resultado
                if($this->logado===false ){
                    \Framework\App\Session::destroy(SESSION_ADMIN_ID);
                    \Framework\App\Session::destroy(SESSION_ADMIN_LOG);
                    \Framework\App\Session::destroy(SESSION_ADMIN_SENHA);
                    \Framework\App\Sistema_Funcoes::Erro('5051');
                }
            }
            // SE A PAGINA FOR PROIBIDA PARA USUARIOS DESLOGADOS TRAVA
            if($this->logado===false && TEMA_LOGIN===true && $this->_Request->getSubModulo()!=='erro' && $this->_Request->getSubModulo()!=='Recurso' && $this->_Request->getSubModulo()!=='localidades'){
                
                if(LAYOULT_IMPRIMIR==='AJAX'){
                    \Framework\App\Sistema_Funcoes::Erro('5060');
                    \Framework\App\Controle::Tema_Travar();
                }else{
                    $visual = new \Framework\App\Visual();
                    $visual->renderizar_login(/*$this->calendario,$this->config_dia,$this->config_mes,$this->config_ano,$this->config_dataixi*/);
                    \Framework\App\Controle::Tema_Travar();
                }
            }            
        }
        self::$Sis_Permissao = $this->_db->Sql_Select('Sistema_Permissao');
        if(self::$Sis_Permissao===false){
            $this->Sistema_Permissoes_InserirPadrao();
            self::$Sis_Permissao = $this->_db->Sql_Select('Sistema_Permissao');
        }
        if($this->_id!==0){
            $this->_grupo       = $this->getGrupo();
            if($this->_grupo!==false){
                if(!is_int($this->_grupo) || $this->_grupo==0){
                    self::grupos_inserir();
                    throw new \Exception('Grupo não existente: '.$this->_grupo, 2901);
                }
                $this->_permissao   = $this->getPermissaoGrupo();
                $this->compilarAcl();
                // SE for nulo o Compilar, carrega permissoes
                //if(count($this->_permissao)==0){ 

                //}
            }
        }
        return true;
    }
    /**
     * 
     * PERMISSOES DO SISTEMA
     * Serve pra Recuperar algum valor do objeto permissao que quiser
     * @param type $chave
     * @param type $campo
     * @return type
     */
    public function Get_Permissao_Nome($chave,$campo='Nome') {
        $array = &self::$Sis_Permissao;
        reset($array);
        while(key($array)!==NULL){
            $objeto = current($array);
            if($objeto->chave===$chave){
                return $objeto->$campo;
                
            }
            next($array);
        }
        return $chave;
    }
    /**
     * Recupera Permissoes do Usuario
     * @return type
     */
    public function getPermissao(){
        if(isset($this->_permissao) && count($this->_permissao)){
            return $this->_permissao;
        }
    }    
    public function Get_Permissao_Chave($chave,$campo='Nome') {
        $array = $this->getPermissao();
        if(isset($array[$chave])){
            return $array[$chave]['valor'];
        }else{
            return false;
        }
    }
    /**
     * Permissoes de URL
     * @param type $url
     * @return boolean
     */
    public function Get_Permissao_Url($url) {
        $permissoes_quepossuem = Array();
        $array = &self::$Sis_Permissao;
        reset($array);
        while(key($array)!==NULL){
            $objeto = current($array);
            
            // CAso nao Vazio
            if($objeto->end!=''){
            
                // Verifica se permissao inclue a url de entrada
                $consta = strpos(strtolower($url), strtolower($objeto->end));
                if($consta!==false){
                    $permissoes_quepossuem[] = Array(
                        'Perm'      => $objeto,
                        'Gravidade' => strlen($objeto->end)); // tamanho da url vira a gravidade
                }
                
            }
            next($array);
        }
        // Ordena Array Multi indices
        orderMultiDimensionalArray($permissoes_quepossuem, 'Gravidade', true);
        
        //var_dump($permissoes_registro,$permissoes_quepossuem);
        // Percorre Verificando Permissoes
        $permissoes_registro = $this->getPermissao();
        reset($permissoes_quepossuem);
        while(key($permissoes_quepossuem)!==NULL){
            $objeto = current($permissoes_quepossuem);
            if(!isset($permissoes_registro[$objeto['Perm']->chave]) || $permissoes_registro[$objeto['Perm']->chave]['valor']===false){
                return false;
            }
            next($permissoes_quepossuem);
        }
        return true;
    }
    private function compilarAcl(){
        $usuario_perm = $this->getUsuarioPermissao();
        $this->_permissao = array_merge(
                $this->_permissao,
                $usuario_perm
        );
    }
    private function getGrupo(){
        $sql = $this->_db->query(
            'SELECT U.grupo,SG.categoria FROM '.MYSQL_USUARIOS.' U LEFT JOIN '.MYSQL_SIS_GRUPO.' SG '.
            'ON U.grupo=SG.id WHERE U.deletado!=1 AND U.id='.$this->_id
        );
        /*echo 'SELECT U.grupo,SG.categoria FROM '.MYSQL_USUARIOS.' U LEFT JOIN '.MYSQL_SIS_GRUPO.' SG '.
            'ON U.grupo=SG.id WHERE U.deletado!=1 AND U.id='.$this->_id; exit;*/
        $grupo = $sql->fetch_object();
        if($grupo==NULL) return false;
        if($grupo->categoria!==NULL && $grupo->categoria!=0){
            return (int) $grupo->grupo;    
        }
        // Caso Categoria Não existe, continua
        $sql = $this->_db->query(
            'SELECT * FROM '.MYSQL_CAT.' C LEFT JOIN '.MYSQL_CAT_ACESSO.' CA '.
            'ON C.id WHERE CA.mod_acc=\'usuario_grupo\''
        ,true);
        $categoria = $sql->fetch_object();
        // Caso nao Exista, cria as categorias
        if($categoria===NULL){
            $manutencao = new \Framework\Classes\SierraTec_Manutencao();
            
            // Gerais
            $this->_db->query(
                'INSERT INTO '.MYSQL_CAT.' (log_date_add,servidor,parent,nome,deletado)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\',0,\'Gerais\',0);'
            ,true);
            $id = (int) $this->_db->ultimo_id();
            $cadastrar = $this->_db->query(
                'INSERT INTO '.MYSQL_CAT_ACESSO.' (log_date_add,servidor,categoria,mod_acc)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\','.$id.',\'usuario_grupo\');'
            ,true);
            $manutencao->Alterar_Config('CFG_TEC_CAT_ID_ADMIN',$id);
            // Atualiza GRUPOs REFErentes
            $this->_db->query('UPDATE '.MYSQL_SIS_GRUPO.' SET categoria='.$id.' WHERE id!='.CFG_TEC_IDFUNCIONARIO.' AND id!='.CFG_TEC_IDCLIENTE,true,false);
            
            // Funcionarios
            $this->_db->query(
                'INSERT INTO '.MYSQL_CAT.' (log_date_add,servidor,parent,nome,deletado)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\',0,\'Clientes\',0);'
            ,true);
            $id = (int) $this->_db->ultimo_id();
            $cadastrar = $this->_db->query(
                'INSERT INTO '.MYSQL_CAT_ACESSO.' (log_date_add,servidor,categoria,mod_acc)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\','.$id.',\'usuario_grupo\');'
            ,true);
            $manutencao->Alterar_Config('CFG_TEC_CAT_ID_CLIENTES',$id);
            // Atualiza GRUPOs REFErentes
            $this->_db->query('UPDATE '.MYSQL_SIS_GRUPO.' SET categoria='.$id.' WHERE id='.CFG_TEC_IDCLIENTE,true,false);
            
            // Funcionarios
            $this->_db->query(
                'INSERT INTO '.MYSQL_CAT.' (log_date_add,servidor,parent,nome,deletado)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\',0,\'Funcionários\',0);'
            ,true);
            $id = (int) $this->_db->ultimo_id();
            $cadastrar = $this->_db->query(
                'INSERT INTO '.MYSQL_CAT_ACESSO.' (log_date_add,servidor,categoria,mod_acc)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\','.$id.',\'usuario_grupo\');'
            ,true);
            $manutencao->Alterar_Config('CFG_TEC_CAT_ID_FUNCIONARIOS',$id);
            // Atualiza GRUPOs REFErentes
            $this->_db->query('UPDATE '.MYSQL_SIS_GRUPO.' SET categoria='.$id.' WHERE id='.CFG_TEC_IDCLIENTE,true,false);
            
            // Clientes 
            $this->_db->query(
                'INSERT INTO '.MYSQL_CAT.' (log_date_add,servidor,parent,nome,deletado)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\',0,\'Clientes\',0);'
            ,true);
            $id = (int) $this->_db->ultimo_id();
            $cadastrar = $this->_db->query(
                'INSERT INTO '.MYSQL_CAT_ACESSO.' (log_date_add,servidor,categoria,mod_acc)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\','.$id.',\'usuario_grupo\');'
            ,true);
            $manutencao->Alterar_Config('CFG_TEC_CAT_ID_CLIENTES',$id);
            // Atualiza GRUPOs REFErentes
            $this->_db->query('UPDATE '.MYSQL_SIS_GRUPO.' SET categoria='.$id.' WHERE id='.CFG_TEC_IDFUNCIONARIO,true,false);

        }else{
            // tenta botar em grupos ja existentes
            if($grupo->grupo=='1'){
                $this->_db->query('UPDATE '.MYSQL_USUARIOS.' SET grupo='.CFG_TEC_IDADMINDEUS.' WHERE grupo='.$grupo->grupo,true,false);
            }else if($grupo->grupo=='2'){
                $this->_db->query('UPDATE '.MYSQL_USUARIOS.' SET grupo='.CFG_TEC_IDADMIN.' WHERE grupo='.$grupo->grupo,true,false);
            }else if($grupo->grupo=='4' || $grupo->grupo=='3'){
                $this->_db->query('UPDATE '.MYSQL_USUARIOS.' SET grupo='.CFG_TEC_IDCLIENTE.' WHERE grupo='.$grupo->grupo,true,false);
            }else if($grupo->grupo=='5'){
                $this->_db->query('UPDATE '.MYSQL_USUARIOS.' SET grupo='.CFG_TEC_IDFUNCIONARIO.' WHERE grupo='.$grupo->grupo,true,false);
            }
        }
        // REEXECUTA QUERY
        $sql = $this->_db->query(
            'SELECT U.grupo,SG.categoria FROM '.MYSQL_USUARIOS.' U LEFT JOIN '.MYSQL_SIS_GRUPO.' SG '.
            'ON U.grupo=SG.id WHERE U.deletado!=1 AND U.id='.$this->_id
        );
        $grupo = $sql->fetch_object();
        if($grupo==NULL) return false;
        if($grupo->categoria!==NULL && $grupo->categoria!=0){
            return (int) $grupo->grupo;    
        }
    }/*
    private function getPermissaoGrupoId(){
        $id = Array();
        $i = 0;
        $sql_ids = $this->_db->query(
                'SELECT permissao FROM '.MYSQL_SIS_GRUPO_PERMISSAO.
                ' WHERE deletado!=1 AND grupo = '.$this->_grupo
                );
        while ($campo = $sql_ids->fetch_object()) {
            $id[$i] = '\''.$campo->permissao.'\'';
            ++$i;
        }
        return $id;
    }*/
    private function getPermissaoGrupo(){
        $data = Array();
        $sql_permissoes = $this->_db->query(
            'SELECT SP.chave,SP.modulo,SP.submodulo,SP.metodo,SP.end,SP.nome,SGP.valor FROM '.MYSQL_SIS_GRUPO_PERMISSAO.' SGP, '.MYSQL_SIS_PERMISSAO.' SP'.
            ' WHERE SGP.deletado!=1 AND SGP.permissao = SP.chave AND SGP.grupo = '.$this->_grupo
        );
        while ($campo = $sql_permissoes->fetch_object()) {
            
            if($campo->valor=='1'){
                $v = true;
            }else{
                $v = false;
            }
            
            $data[$campo->chave] = Array(
                'chave'     => $campo->chave,
                'mod'       => $campo->modulo,
                'sub'       => $campo->submodulo,
                'met'       => $campo->metodo,
                'end'       => $campo->end,
                'permissao' => $campo->nome,
                'valor'     => $v,
                'herdado'   => true
            );
        }  
        return $data;
    }
    /**
     * #update
     * @return array
     */
    private function getUsuarioPermissao(){
        $data = Array();
        /*$ids = $this->getPermissaoGrupoId();
        if(empty($ids))     return $data;
        // verifica consistencia do ids
        $teste = '';
        foreach($ids as $valor){
            $teste .= $valor;
        }
        if($teste=='')      return $data;*/
        

        $permissao = $this->_db->query('SELECT SP.chave,SP.modulo,SP.submodulo,SP.metodo,SP.end,SP.nome,UP.valor FROM '.MYSQL_USUARIO_PERMISSAO.' UP, '.MYSQL_SIS_PERMISSAO.' SP'.
                ' WHERE UP.deletado!=1 AND UP.permissao = SP.chave AND UP.servidor = \''.SRV_NAME_SQL.'\' AND UP.usuario = '.$this->_id
                //.' AND UP.permissao in ( '.implode(',',$ids).' )'
                ,true);
        while ($campo = $permissao->fetch_object()) {            
            if($campo->valor==1 || $campo->valor=='1'){
                $v = true;
            }else{
                $v = false;
            }
            
            $data[$campo->chave] = Array(
                'chave'     => $campo->chave,
                'mod'       => $campo->modulo,
                'sub'       => $campo->submodulo,
                'met'       => $campo->metodo,
                'end'       => $campo->end,
                'permissao' => $campo->nome,
                'valor'     => $v,
                'herdado'   => false,
            );
        }
        return $data;
    }
    /**
     * Retorna id do Usuario
     * 
     * @name Usuario_GetID
     * @access public
     * 
     * @uses \Framework\App\Controle::$usuario
     * 
     * @return int 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0.1
     */
    public function Usuario_GetID(){
        if(!isset($this->logado_usuario) || !is_numeric($this->logado_usuario->id) || $this->logado===false){
            return 0;
        }
        $id = (int) $this->logado_usuario->id;
        return $id;
    }
    
    /**
     * Retorna id do Usuario
     * 
     * @name Usuario_GetID
     * @access public
     * 
     * @uses \Framework\App\Controle::$usuario
     * 
     * @return int 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0.1
     */
    public static function Usuario_GetID_Static(){
        $registro = \Framework\App\Registro::getInstacia();
        $Acl = $registro->_Acl;
        return ($Acl)?$Acl->Usuario_GetID():0;
    }
    /**
    * Verifica o usuario e senha do usuario logado e retorna
    * 
    * @name Usuario_Senha_Verificar
    * @access public
    * 
    * @param string $email
    * @param string $senha
    * @param Array $usuario Carrega Ponteiro da variavel Usuario para Controle
    * @param Array $usuario2 Carrega Ponteiro da variavel Usuario para Visual
    * 
    * @uses \Framework\App\Modelo::$usuario
    * @uses \Framework\App\Modelo::$bd
    * @uses \Framework\App\Conexao::$query
    * 
    * @return int 1
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0.1 
    * Revisão:
    *  - 0.1.1 2013-05-13 Sessao Automatizada por Constante
    */
    public function Usuario_Senha_Verificar($email=false,$senha=false)
    {
        if($email===false){
                $email = \anti_injection($_POST['sistema_login']);
        }
        if($senha===false){
                $senha = \Framework\App\Sistema_Funcoes::Form_Senha_Blindar($_POST['sistema_senha']);
        }
        
        $query = $this->_db->query('SELECT id,grupo,nome,foto,email,cpf,telefone,celular,endereco,numero,complemento,'.
                'cidade,bairro,cep,foto_cnh,foto_res,foto_cnh_apv,foto_res_apv'
                . ' FROM '.MYSQL_USUARIOS.' WHERE servidor=\''.SRV_NAME_SQL.'\' AND (login=\''.$email.'\' OR email=\''.$email.'\') AND senha=\''.$senha.'\' AND ativado=1 AND deletado=0 LIMIT 1');
        
        // Procura Resultado
        while($this->logado_usuario = $query->fetch_object()){
            $this->Usuario_Logar($email,$senha,$this->logado_usuario->id);
            return true;
        }
        // CAso nao AChe
        $this->logado_usuario = new \Usuario_DAO();
        $this->logado_usuario->id = 0;
        return false;
        
    }
    /**
     * 
     * @param type $login
     * @param type $senha
     * @param type $id
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
     */
    public function Usuario_Logar($login='',$senha='',$id=0){
        if($login!=='') \Framework\App\Session::set(SESSION_ADMIN_LOG,   $login);
        if($senha!=='') \Framework\App\Session::set(SESSION_ADMIN_SENHA, $senha);
        if($senha!==0) \Framework\App\Session::set(SESSION_ADMIN_ID,    $id);
        return true;
    }
    /**
     * Retorna se ta logado
     * 
     * @name Usuario_GetLogado
     * @access public
     * 
     * @uses \Framework\App\Controle::$logado
     * 
     * @return int 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0.0
     */
    public function Usuario_GetLogado(){
        return $this->logado;
    }
    public function Usuario_GetLogado_Static(){
        return \Framework\App\Registro::getInstacia()->_Acl->logado;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function grupos_inserir(){
        
        // Caso Categoria Não existe, continua
        $sql = $this->_db->query(
            'SELECT * FROM '.MYSQL_CAT.' C LEFT JOIN '.MYSQL_CAT_ACESSO.' CA '.
            'ON C.id WHERE CA.mod_acc=\'usuario_grupo\''
        ,true);
        $categoria = $sql->fetch_object();
        // Caso nao Exista, cria as categorias
        if($categoria===NULL){
            $manutencao = new \Framework\Classes\SierraTec_Manutencao();
            
            // Gerais
            $this->_db->query(
                'INSERT INTO '.MYSQL_CAT.' (log_date_add,servidor,parent,nome,deletado)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\',0,\'Gerais\',0);'
            ,true);
            $gerais_id = (int) $this->_db->ultimo_id();
            $cadastrar = $this->_db->query(
                'INSERT INTO '.MYSQL_CAT_ACESSO.' (log_date_add,servidor,categoria,mod_acc)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\','.$gerais_id.',\'usuario_grupo\');'
            ,true);
            $manutencao->Alterar_Config('CFG_TEC_CAT_ID_ADMIN',$gerais_id);
            
            // Clientes
            $this->_db->query(
                'INSERT INTO '.MYSQL_CAT.' (log_date_add,servidor,parent,nome,deletado)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\',0,\'Clientes\',0);'
            ,true);
            $clientes_id = (int) $this->_db->ultimo_id();
            $cadastrar = $this->_db->query(
                'INSERT INTO '.MYSQL_CAT_ACESSO.' (log_date_add,servidor,categoria,mod_acc)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\','.$clientes_id.',\'usuario_grupo\');'
            ,true);
            $manutencao->Alterar_Config('CFG_TEC_CAT_ID_CLIENTES',$clientes_id);
            
            // Funcionarios
            $this->_db->query(
                'INSERT INTO '.MYSQL_CAT.' (log_date_add,servidor,parent,nome,deletado)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\',0,\'Funcionários\',0);'
            ,true);
            $funcionarios_id = (int) $this->_db->ultimo_id();
            $cadastrar = $this->_db->query(
                'INSERT INTO '.MYSQL_CAT_ACESSO.' (log_date_add,servidor,categoria,mod_acc)
                VALUES (\''.APP_HORA.'\',\''.SRV_NAME_SQL.'\','.$funcionarios_id.',\'usuario_grupo\');'
            ,true);
            $manutencao->Alterar_Config('CFG_TEC_CAT_ID_FUNCIONARIOS',$funcionarios_id);
        }else{
            
            $gerais_id = (int) CFG_TEC_CAT_ID_ADMIN;
            $clientes_id = (int) CFG_TEC_CAT_ID_CLIENTES;
            $funcionarios_id = (int) CFG_TEC_CAT_ID_FUNCIONARIOS;
        }
        
        
        $grupos = $this->_db->Sql_Select('Sistema_Grupo');
        if($grupos===false){
            
            // Admin Master
            $grupo = new \Sistema_Grupo_DAO();
            //$grupo->id = 1;
            $grupo->nome = 'Admin Master';
            $grupo->categoria = $gerais_id;
            $this->_db->Sql_Inserir($grupo);
            
            // Admin
            $grupo = new \Sistema_Grupo_DAO();
            //$grupo->id = 2;
            $grupo->nome = 'Admin';
            $grupo->categoria = $gerais_id;
            $this->_db->Sql_Inserir($grupo);
            
            // Cliente
            $grupo = new \Sistema_Grupo_DAO();
            //$grupo->id = 3;
            $grupo->nome = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome');
            $grupo->categoria = $clientes_id;
            $this->_db->Sql_Inserir($grupo);
            
            // Funcionario
            $grupo = new \Sistema_Grupo_DAO();
            //$grupo->id = 3;
            $grupo->nome = 'Funcionário';
            $grupo->categoria = $funcionarios_id;
            $this->_db->Sql_Inserir($grupo);
            
            // Newsletter
            $grupo = new \Sistema_Grupo_DAO();
            //$grupo->id = 4;
            $grupo->nome = 'Newsletter';
            $grupo->categoria = $funcionarios_id;
            $this->_db->Sql_Inserir($grupo);
        }
        
        
    }
    
    /**
     * Ve o valor de algum Config Funcional
     */
    public static function Sistema_Modulos_Configs_Funcional($chave=false){
        if($chave===false || $chave=='') return false;
        if(self::$config===false){
            self::$config     = &self::Sistema_Modulos_Carregar_Funcional();
        }
        $percorrer  = &self::$config[$chave]['Valor'];
        
        // Percorre Funcional
        /*if(empty($percorrer)) return false;
        foreach($percorrer as &$valor){
            if($valor['chave']==$chave){
                return $valor['Valor'];
            }
        }*/
        if(isset($percorrer))
            return $percorrer;
        return false;
    }
    public static function &Sistema_Modulos_Carregar_Menu(){
        $tempo = new \Framework\App\Tempo('\Framework\App\Acl::Sistema_Modulos_Configs->Menu');
        // Le todos arquivos Menus dos modulos permitidos
        $ponteiro   = Array('_Sistema' => '_Sistema');
        if(function_exists('config_modulos')){
            $ponteiro   = array_merge($ponteiro,config_modulos());
        }
        $config     = Array();
        reset($ponteiro);
        while (key($ponteiro) !== null) {
            $current = current($ponteiro);
            if (is_dir(MOD_PATH.''.$current)) {
                // SE existe arquivo config
                if(file_exists(MOD_PATH.''.$current.'/_Config.php')){
                    // Puxa
                    include MOD_PATH.''.$current.'/_Config.php';
                    // Realiza Merge para Indexir Configuracoes
                    $config         = array_merge_recursive($config     ,$config_Menu()         );
                } 
            }
            next($ponteiro);
        }
        return $config;
    }
    public static function &Sistema_Modulos_Carregar_Permissoes(){
        $tempo = new \Framework\App\Tempo('\Framework\App\Acl::Sistema_Modulos_Configs->Permissoes');
        // Le todos arquivos Menus dos modulos permitidos
        $ponteiro   = Array('_Sistema' => '_Sistema');
        if(function_exists('config_modulos')){
            $ponteiro   = array_merge($ponteiro,config_modulos());
        }
        $config     = Array();
        reset($ponteiro);
        while (key($ponteiro) !== null) {
            $current = current($ponteiro);
            if (is_dir(MOD_PATH.''.$current)) {
                // SE existe arquivo config
                if(file_exists(MOD_PATH.''.$current.'/_Config.php')){
                    // Puxa
                    include MOD_PATH.''.$current.'/_Config.php';
                    // Realiza Merge para Indexir Configuracoes
                    $config    = array_merge_recursive($config,$config_Permissoes()   );
                } 
            }
            next($ponteiro);
        }
        return $config;
    }
    public static function &Sistema_Modulos_Carregar_Funcional(){
        $tempo = new \Framework\App\Tempo('\Framework\App\Acl::Sistema_Modulos_Configs->Funcional');
        // ordena na ordem correta
        $registro = \Framework\App\Registro::getInstacia();
        $funcional = $registro->_Cache->Ler('Config_Funcional');
        if (!$funcional) {
            $funcional = self::Sistema_Modulos_Carregar_Funcional_Completo();
            $registro->_Cache->Salvar('Config_Funcional', $funcional);
        }
        return $funcional;
    }
    public static function &Sistema_Modulos_Carregar_Funcional_Completo(){
        $tempo = new \Framework\App\Tempo('\Framework\App\Acl::Sistema_Modulos_Configs->Funcional_Completo');
        // Le todos arquivos Menus dos modulos permitidos
        $ponteiro   = Array('_Sistema' => '_Sistema');
        if(function_exists('config_modulos')){
            $ponteiro   = array_merge($ponteiro,config_modulos());
        }
        $config     = Array();
        reset($ponteiro);
        while (key($ponteiro) !== null) {
            $current = current($ponteiro);
            if (is_dir(MOD_PATH.''.$current)) {
                // SE existe arquivo config
                if(file_exists(MOD_PATH.''.$current.'/_Config.php')){
                    // Puxa
                    include MOD_PATH.''.$current.'/_Config.php';
                    // Merge Com Config Funcional se Existir
                    if(file_exists(INI_PATH.SRV_NAME.'/'.$current.'.php')){
                        include INI_PATH.SRV_NAME.'/'.$current.'.php';
                        // Pega Arrays com configs
                        $config_funciona = $config_Funcional();
                        $config_Funcional = $Funcional;

                        // Merge só valor
                        reset($config_Funcional);
                        while (key($config_Funcional) !== null) {
                            $current2 = current($config_Funcional);
                            if(isset($current2['Valor'])){
                                $config_funciona[key($config_Funcional)]['Valor'] = $current2['Valor'];
                            }
                            next($config_Funcional);
                        }
                    }else{
                        $config_funciona = $config_Funcional();
                    }
                    // Realiza Merge para Indexir Configuracoes
                    $config    = array_merge_recursive($config,$config_funciona       );
                } 
            }
            next($ponteiro);
        }
        return $config;
    }
    /**
     * 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
     */
    private function Sistema_Permissoes_InserirPadrao(){
        $configPermissoes = self::Sistema_Modulos_Carregar_Permissoes();
        if(!empty($configPermissoes)){
            foreach($configPermissoes as &$valor){
                if($valor['Chave']!=''){
                    // Verifica se ja existe
                    $where = Array(
                        'chave' => $valor['Chave'],
                    );
                    $retorno = $this->_db->Sql_Select('Sistema_Permissao',$where);
                    if($retorno===false){
                        
                        
                        // Se nao tiver Permissao funcional requerida, entao passa direto
                        $trava = false;
                        if(isset($valor['Permissao_Func']) && is_array($valor['Permissao_Func'])){
                            foreach($valor['Permissao_Func'] as $indicepermfunc=>&$permfunc){
                                if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional($indicepermfunc)!==$permfunc){
                                    $trava = true;
                                }
                            }
                        }
                        if($trava) continue;
                        
                        // Faz as Paradas Cria Permissao e Grava no Banco
                        $endereco   = explode('/',$valor['End']);
                        $modulo     = $endereco[0];
                        if(isset($endereco[1])){
                            $submodulo  = $endereco[1];
                        }else{
                            $submodulo  = '*';
                        }
                        $inserir = new \Sistema_Permissao_DAO();
                        $inserir->nome        = $valor['Nome'];
                        $inserir->descricao   = $valor['Desc'];
                        $inserir->modulo      = $modulo;
                        $inserir->submodulo   = $submodulo;
                        $inserir->end         = $valor['End'];
                        $inserir->chave       = $valor['Chave'];
                        $this->_db->Sql_Inserir($inserir);
                    }
                }
            }
        }
    }
}
?>
