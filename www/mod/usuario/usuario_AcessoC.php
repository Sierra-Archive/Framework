<?php
class usuario_AcessoControle extends usuario_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuarios_ListarModelo Carrega usuarios Modelo
    * @uses usuarios_ListarVisual Carrega usuarios Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function __construct() {
        // construct
        parent::__construct();
    }
    /**
    * Função Main, Principal
    * 
    * @name Main
    * @access public
    * 
    * @uses usuarios_AcessoControle::$usuarios_lista
    * @uses usuarios_AcessoControle::$marcas_carregajanelaadd
    * @uses \Framework\App\Visual::$Json_Start
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function Main() {
        $this->Usuarios();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Permissões de Usuários'));         
    }
    public function Listar_Clientesnao() {
        $this->Usuarios(Array(CFG_TEC_CAT_ID_CLIENTES,'Usuários'), false,100,true);
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Permissões de Usuários'));         
    }
    
    public function Usuarios($grupo = false, $ativado = false, $gravidade=0, $inverter = false) {
        $i = 0;
        if ((isset($tipo) && ($tipo) === false)) {
            $where = Array();
        } else {
            $where = Array();
        }
        // cria where de acordo com parametros
        
        if ($grupo === false) {
            $categoria = 0;
            if ($inverter) {
                $where = Array(
                    'ativado'=>$ativado
                );
            } else {
                $where = Array(
                    'ativado'=>$ativado
                );
            }
            $nomedisplay        = __('Usuários ');
            $nomedisplay_sing   = __('Usuário ');
            $nomedisplay_tipo   = __('Usuario');
            // Link
            $this->Tema_Endereco(__('Permissôes de Usuários'));
        } else {
            $categoria = (int) $grupo[0];
            
            // Pega GRUPOS VALIDOS
            $sql_grupos = $this->_Modelo->db->Sql_Select('Sistema_Grupo',Array('categoria'=>$categoria));
            $grupos_id = Array();
            if (is_object($sql_grupos)) $sql_grupos = Array(0=>$sql_grupos);
            if ($sql_grupos !== false && !empty($sql_grupos)) {
                foreach ($sql_grupos as &$valor) {
                    $grupos_id[] = $valor->id;
                }
            }
            
            // cria where de acordo com parametros
            if ($inverter) {
                $where = Array(
                    'NOTINgrupo'=>$grupos_id,
                    'ativado'=>$ativado
                );
            } else {
                $where = Array(
                    'INgrupo'=>$grupos_id,
                    'ativado'=>$ativado
                );
            }
        
            $nomedisplay        = $grupo[1].' ';
            $nomedisplay_sing   = Framework\Classes\Texto::Transformar_Plural_Singular($grupo[1]);
            $nomedisplay_tipo   = Framework\Classes\Texto::Transformar_Plural_Singular($grupo[1]);
            // Link
            $this->Tema_Endereco('Permissôes de '.$grupo[1]);
        }
        
        $linkextra = '';
        if ($grupo !== false && $grupo[0]==CFG_TEC_CAT_ID_CLIENTES && $inverter === false) {
            $linkextra = '/cliente';
        }
        else if ($grupo !== false && $grupo[0]==CFG_TEC_CAT_ID_CLIENTES && $inverter === true) {
            $linkextra = '/naocliente';
        }
        else if ($grupo !== false && $grupo[0]==CFG_TEC_CAT_ID_FUNCIONARIOS && $inverter === false) {
            $linkextra = '/funcionario';
        }
        
        if ($ativado === false) unset($where['ativado']);
        // Chama Usuarios
        $usuarios = $this->_Modelo->db->Sql_Select('Usuario', $where);
        if (is_object($usuarios)) $usuarios = Array(0=>$usuarios);
        if ($usuarios !== false && !empty($usuarios)) {
            reset($usuarios);
            $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Acesso/UsuariosAcesso_Edit');
            
            foreach ($usuarios as $indice=>&$valor) {
                $table[__('#Id')][$i]       = '#'.$valor->id;
                $table[__('Grupo')][$i]     = $valor->grupo2;
                // Atualiza Nome
                $nome = '';
                if ($valor->nome!='') {
                    $nome .= $valor->nome;
                }
                // Atualiza Razao Social
                if ($valor->razao_social!='') {
                    if ($nome!='') $nome .= '<br>';
                    $nome .= $valor->razao_social;
                }
                $table[__('Nome')][$i]      = $nome;
                // Acesso
                $acl = new \Framework\App\Acl($valor->id);
                $acl = $acl->getPermissao();
                $permissoes = '';
                if (!empty($acl)) {
                    foreach ($acl as &$valor2) {
                        if ($valor2['valor'] === true) {
                            if ($permissoes!=='') {
                                $permissoes .= ', ';
                            }
                            $permissoes .= $valor2['permissao'];
                            if ($valor2['herdado'] === true) {
                                $permissoes .= ' (Herdado)';
                            }
                        }
                    }
                } else {
                    $permissoes = __('Sem Nenhuma Permissão');
                }
                $table[__('Acesso')][$i]    = $permissoes;
                // Funcoes
                $table[__('Funções')][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Permissão do Usuario')        ,'usuario/Acesso/UsuariosAcesso_Edit/'.$valor->id.$linkextra    , ''), $permissionEdit);
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($table);
            unset($table);
        } else {           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Usuário</font></b></center>');
        }
        $titulo = __('Listagem de Permissões de Usuários').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',60);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Permissões de Usuarios'));
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function UsuariosAcesso_Edit($id, $tipo='usuario') {
        // Carrega Config
        $titulo1    = 'Editar Usuario (#'.(int) $id.')';
        $titulo2    = __('Alteração de Usuario');
        $formid     = 'formusuario_AcessoC_UsuarioEdit';
        $formbt     = __('Salvar Acesso');
        $formlink   = 'usuario/Acesso/UsuariosAcesso_Edit2/'.(int) $id.'/'.$tipo;
        $editar     = Array('Usuario',(int) $id);
        $campos = Usuario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'Permissões do Usuário', 1);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function UsuariosAcesso_Edit2($id, $tipo='usuario') {
        if (isset($_POST["nome"])) {
            $nome   = \Framework\App\Conexao::anti_injection($_POST["nome"]);
        } else {
            $nome   = '';
        }
        $titulo     = __('Usuario Editado com Sucesso');
        $dao        = Array('Usuario', $id);
        if ($tipo=='naocliente') {
            $function     = '$this->Listar_Clientesnao();';
        } else /*if ($tipo=='usuario')*/{
            $function     = '$this->Usuarios();';
        }
        $sucesso1   = __('Acesso Alterado com Sucesso.');
        $sucesso2   = $nome.' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);   
    }
}
?>