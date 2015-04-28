<?php
class usuario_Modelo extends \Framework\App\Modelo
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
    * Retorna todos os usuarios
    * 
    * @name retorna_usuarios
    * @access public
    * 
    * @uses MYSQL_USUARIOS
    * @uses \Framework\App\Modelo::$usuario
    * @uses \Framework\App\Modelo::$db
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
     * #update
    */
    /*public function retorna_usuarios(&$usuarios,$ativado=1){
        $i = 0;
        $mysqlwhere = '';
        $sql = $this->db->query('SELECT id,nome,email,nivel_usuario,nivel_admin
        FROM '.MYSQL_USUARIOS.' WHERE deletado=0 AND ativado='.$ativado.' ORDER BY nome'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $usuarios[$i]['id'] = $campo->id;
            $usuarios[$i]['nome'] = $campo->nome;
            $usuarios[$i]['email'] = $campo->email;
            $usuarios[$i]['nivel_usuario'] = $campo->nivel_usuario;
            $usuarios[$i]['nivel_admin'] = $campo->nivel_admin;
            
            if(file_exists(MOD_PATH.'Financeiro'.DS.'Financeiro_Controle.php')){
                $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);

                if($saldo<0){
                    $usuarios[$i]['saldo'] = '<font style="color:#FF0000;">- R$ '.number_format(abs($saldo), 2, ',', '.').'</font>';
                }else{
                    $usuarios[$i]['saldo'] = 'R$ '.number_format($saldo, 2, ',', '.');
                }
            }else{
                $usuarios[$i]['saldo'] = 'R$ 0,00';
            }
            ++$i;
        }
        return $i;
    }*/
    
    /**
     * Insere usuarios no Banco de Dados
     * 
     * @name usuarios_inserir
     * @access public
     * 
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    /*public function usuarios_inserir($tipo = 'cliente'){
        GLOBAL $config;
        if($tipo=='cliente')   $pago=0;
        else                           $pago=1;
        $this->campos[] = array(
            'Nome' =>  'nivel_usuario_pago',
            'mysql' => 'nivel_usuario_pago',
            'valorpadrao' => $pago
        );
        $this->campos[] = array(
            'Nome' =>  'data_cadastro',
            'mysql' => 'data_cadastro',
            'valorpadrao' => APP_HORA
        );
        $this->db->query('INSERT INTO '.MYSQL_USUARIOS.' '.$this->mysqlInsertCampos($this->campos));

        
       if($tipo!='cliente'){
            $sql = $this->db->query('SELECT id FROM '.MYSQL_USUARIOS.' WHERE email=\''.\anti_injection($_POST['email']).'\' ORDER BY id DESC LIMIT 1');
            while ($campo = $sql->fetch_object()) {
               $id = $campo->id;
            }
            eval('$valor = CONFIG_CLI_'.\anti_injection($_POST['nivel_usuario']).'_PRECO;');
            $dt_vencimento = date("Y-m-d", time() + (FINANCEIRO_DIASVENCIMENTO * 86400));
            Financeiro_Modelo::MovInt_Inserir($this,$id,$valor,0,'usuario',\anti_injection($_POST['nivel_usuario']),$dt_vencimento);
        }
        return 1;
    }
    /**
     * 
     * @param type $id
     * @return int
     */
    /*public function usuarios_alterar($id){
        $id = (int) $id;
        if(!isset($id) || !is_int($id) || $id==0) return 0;
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET '.$this->mysqlUpdateCampos($this->campos).' WHERE id='.$id);
        
        return 1;
    }
    /**
     * 
     * @param type $id
     * @return string
     */
    /*public function retorna_usuario($id){
        $id = (int) $id;
        if(!isset($id) || !is_int($id) || $id==0) return 0;
        $sql = $this->db->query(' SELECT '.$this->mysqlSelectCampos($this->campos).'
        FROM '.MYSQL_USUARIOS.'
        WHERE id='.$id.' LIMIT 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $this->mysqlRetornaCampos($usuario,$this->campos,$campo);
            
            if(file_exists(MOD_PATH.'Financeiro'.DS.'Financeiro_Controle.php')){
                $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);

                if($saldo<0){
                    $usuario->saldo = '<font style="color:#FF0000;">- R$ '.number_format(abs($saldo), 2, ',', '.').'</font>';
                }else{
                    $usuario->saldo = 'R$ '.number_format($saldo, 2, ',', '.');
                }
            }else{
                $usuario->saldo = 'R$ 0,00';
            }
        }
        return $usuario;
        
    }
    /**
     * 
     * @param type $modelo
     * @param type $email
     * @return int
     */
    static function VerificaExtEmail(&$modelo, $email){
        $sql = $modelo->db->query(' SELECT id
        FROM '.MYSQL_USUARIOS.'
        WHERE deletado!=1 AND email=\''.$email.'\''); //P.categoria
        while ($campo = $sql->fetch_object()) {
            return true;
        }
        return false;
    }
    /**
     * 
     * @param type $modelo
     * @param type $login
     * @return int
     */
    static function VerificaExtLogin(&$modelo, $login){
        $sql = $modelo->db->query(' SELECT id
        FROM '.MYSQL_USUARIOS.'
        WHERE deletado!=1 AND login=\''.$login.'\''); //P.categoria
        while ($campo = $sql->fetch_object()) {
            return true;
        }
        return false;
    }
    /**
     * 
     * @param type $modelo
     * @param type $user
     * @return string
     */
    static function PlanoStatus($modelo, $user){
        // Carrega e Inicializa Variavies
        $registro = \Framework\App\Registro::getInstacia();
        $acl = $registro->_Acl;
        $usuarioid = $acl->Usuario_GetID();
        $planostatus = Array();
        
        // Executa
        if(file_exists(MOD_PATH.'Financeiro'.DS.'Financeiro_Controle.php')){
            // CONSULTA SE TEM DEBIDOS NO MODO USUARIO
            $planopendente = Financeiro_Modelo::MovInt_VerificaDebito($modelo,$usuarioid,'usuario');
            if($planopendente!=0){
                $planostatus['status'] = '<font color="#FF0000">Pendente</font>';
                eval('$planostatus[\'plano\'] = CONFIG_CLI_'.$planopendente.'_NOME;');
                $planostatus['alterar'] = '';
            }else{
                $planostatus['status'] = 'Pago';
                eval('$planostatus[\'plano\'] = CONFIG_CLI_'.$acl->logado_usuario->nivel_usuario.'_NOME;');
                if($acl->logado_usuario->nivel_usuario<4){
                    $planostatus['alterar'] = '<a confirma="Deseja realmente alterar o seu plano?" title="Alterar Plano de Associado" class="lajax explicar-titulo" href="'.URL_PATH.'usuario/Perfil/Plano_Popup/" acao="">Clique Aqui</a>';
                }else{
                    $planostatus['alterar'] = '';
                }
            }
            return $planostatus;
        }else{
            return 0;
        }
    }
    /**
     * 
     * @param type $modelo
     * @param type $usuarioid
     * @param type $motivoid
     * @return int
     */
    static function Financeiro($usuarioid,$motivoid){
        $usuarioid = (int) $usuarioid;
        $registro = \Framework\App\Registro::getInstacia();
        $modelo = $registro->_Modelo;
        if(!isset($usuarioid) || !is_int($usuarioid) || $usuarioid==0) return 0;
        $modelo->db->query('UPDATE '.MYSQL_USUARIOS.' SET nivel_usuario_pago=1 WHERE deletado!=1 AND id='.$usuarioid);
        return 1;
    }
    /**
     * 
     * @param type $modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Financeiro_Motivo_Exibir($motivoid){
        $registro = \Framework\App\Registro::getInstacia();
        $modelo = $registro->_Modelo;
        $text = 'CONFIG_CLI_'.$motivoid.'_NOME';
        return Array('Pagamento do Plano',$text);
    }
}
?>
