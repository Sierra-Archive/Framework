<?php
class usuario_AnexoControle extends usuario_Controle
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
    * @uses usuarios_AnexoControle::$usuarios_lista
    * @uses usuarios_AnexoControle::$marcas_carregajanelaadd
    * @uses \Framework\App\Visual::$Json_Start
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function Main($id = false, $tipo='Usuarios') {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario/Anexo/Anexar/'.$id.'/'.$tipo);
        return false;   
    }
    public function Anexar($id = false, $tipo='Usuarios') {
        // PEga usuario
        if ($id==0 || !isset($id)) {
            $id = (int) $this->_Acl->Usuario_GetID();
        } else {
            $id = (int) $id;
        }
        $usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if ($tipo === false) {
            if ($usuario->grupo==CFG_TEC_IDCLIENTE) {
                $tipo   = __('Cliente');
                $tipo2  = 'cliente';
            } else if ($usuario->grupo==CFG_TEC_IDFUNCIONARIO) {
                $tipo   = __('Funcionário');
                $tipo2  = 'funcionario';
            }
        } else {
            // Primeira Letra Maiuscula
            $tipo = ucfirst($tipo);
        }
        // GAmbiarra Para Consertar erro de acento em url
        if ($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = "Funcionário";
        if ($tipo=="Usurio" || $tipo=="Usuario")         $tipo = __('Usuário');
        // Cria Tipo 2:
        if ($tipo=='Cliente') {
            $tipo2  = 'cliente';
            $tipo   = Framework\Classes\Texto::Transformar_Plural_Singular(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome'));
            $this->Tema_Endereco(__('Clientes'),'usuario/Admin/ListarCliente');
        } else if ($tipo=='Funcionário') {
            $tipo2  = 'funcionario';
            $this->Tema_Endereco(__('Funcionários'),'usuario/Admin/ListarFuncionario');
        } else {
            $this->Tema_Endereco(__('Usuários'),'usuario/Admin/Main');
        }
        // Titulo Anexo
        $nome = '';
        if ($usuario->nome!='') {
            $nome .= $usuario->nome;
        }
        $this->Tema_Endereco('Anexos de '.$nome);
        // Upload de Chamadas
        $this->_Visual->Blocar(
            $this->_Visual->Upload_Janela(
                'usuario',
                'Anexo',
                'VisualizadordeUsuario',
                $id,
                'gif;jpg;jpeg;pdf;', // Arquivos Permitidos
                'Arquivos de Imagem'
            )
        );
        $this->_Visual->Bloco_Unico_CriaJanela(__('Fazer Upload de Anexo')  , '',8);
        
        // Processa Anexo
        list($titulo, $html, $i) = $this->Anexos_Processar($id);
        $this->_Visual->Blocar('<span id="anexo_arquivos_mostrar">'.$html.'</span>');
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',9);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Listagem de Anexos'));
    }
    public function VisualizadordeUsuario_Upload($usuario = 0) {
        if ($usuario !== false && $usuario!=0) {
            $resultado_usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$usuario),1);
            if ($resultado_usuario === false) {
                return _Sistema_erroControle::Erro_Fluxo('Esse usuário não existe:'. $usuario,404);
            }
            // Condicao de Query
            $where = Array('usuario'=>$resultado_usuario->id);
        } else {
            return _Sistema_erroControle::Erro_Fluxo('Usuário não especificado:'. $usuario,404);
        }
        $fileTypes = array(
            // Audio
            'gif',
            'jpg',
            'jpeg',
            'pdf',
        ); // File extensions
        $dir = 'usuario'.DS.'Anexos'.DS;
        $ext = $this->Upload($dir, $fileTypes, false);
        $this->layoult_zerar = false;
        // CAso tenha sucesso.
        if ($ext !== false) {
            
            $arquivo = new \Usuario_Anexo_DAO();
            $arquivo->usuario      = $usuario;
            $arquivo->ext           = $ext[0];
            $arquivo->endereco      = $ext[1];
            $arquivo->nome          = $ext[2];
            $this->_Modelo->db->Sql_Insert($arquivo);
            $this->_Visual->Json_Info_Update('Titulo', __('Upload com Sucesso'));
            $this->_Visual->Json_Info_Update('Historico', false);
            // Tras de Volta e Atualiza via Json
            list($titulo, $html, $i) = $this->Anexos_Processar($usuario);
            $conteudo = array(
                'location'  => '#anexo_arquivos_num',
                'js'        => '',
                'html'      => $i
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            $conteudo = array(
                'location'  => '#anexo_arquivos_mostrar',
                'js'        => '',
                'html'      => $html
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            
            
            // Enviar Email
            $this->Enviar_Email_Anexo($usuario, $dir.strtolower($arquivo->endereco.'.'.$arquivo->ext), $arquivo->nome);
            
        } else {
            
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Houve algum erro ao fazer upload do arquivo !')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens); 
            $this->_Visual->Json_Info_Update('Titulo', __('Erro com Upload'));
            $this->_Visual->Json_Info_Update('Historico', false);
        }
    }
    private function Anexos_Processar($usuario = false) {
        // Anexo
        if ($usuario !== false && $usuario!=0) {
            $resultado_usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$usuario),1);
            if ($resultado_usuario === false) {
                return _Sistema_erroControle::Erro_Fluxo('Esse usuário não existe:'. $usuario,404);
            }
            // Condicao de Query
            $where = Array('usuario'=>$resultado_usuario->id);
        } else {
            $usuario = 0;
            $where = Array();
        }
        $i = 0;
        $html = '';
        // COntinua
        $anexos = $this->_Modelo->db->Sql_Select('Usuario_Anexo', $where);
        if ($anexos !== false && !empty($anexos)) {
            // Percorre Anexos
            if (is_object($anexos)) $anexos = Array(0=>$anexos);
            reset($anexos);
            if (!empty($anexos)) {
                foreach ($anexos as &$valor) {
                    $endereco = ARQ_PATH.'usuario'.DS.'Anexos'.DS.strtolower($valor->endereco.'.'.$valor->ext);
                    if (file_exists($endereco)) {
                        $tamanho    =   round(filesize($endereco)/1024);
                        $tipo       =   $valor->ext;
                        $table[__('Nome')][$i]             = '<a href="'.URL_PATH.'usuario/Anexo/Download/'.$valor->id.'/" border="1" class="lajax" data-acao="">'.$valor->nome.'</a>';
                        $table[__('Tamanho')][$i]          = $tamanho.' KB';
                        $table[__('Data')][$i]             = $valor->log_date_add;
                        $table[__('Download')][$i]         = $this->_Visual->Tema_Elementos_Btn('Baixar'     ,Array(__('Download de Arquivo')   ,'usuario/Anexo/Download/'.$valor->id    , ''));
                        ++$i;
                    }
                }
            }
            $html .= $this->_Visual->Show_Tabela_DataTable($table, '', false);
            unset($table);
        } else {
            $html .= '<center><b><font color="#FF0000" size="5">Nenhum Anexo</font></b></center>';            
        }
        $titulo = 'Anexos (<span id="anexo_arquivos_num">'.$i.'</span>)';
        return Array($titulo, $html, $i);
    }
    public function Download($anexo, $usuario = false) {
        $resultado_arquivo = $this->_Modelo->db->Sql_Select('Usuario_Anexo', Array('id'=>$anexo),1);
        if ($resultado_arquivo === false || !is_object($resultado_arquivo)) {
            return _Sistema_erroControle::Erro_Fluxo('Esse anexo não existe:'. $anexo,404);
        }
        $endereco = 'usuario'.DS.'Anexos'.DS.strtolower($resultado_arquivo->endereco.'.'.$resultado_arquivo->ext);
        self::Export_Download($endereco, $resultado_arquivo->nome.'.'.$resultado_arquivo->ext);
    }
}
?>