<?php

class usuario_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo usuario aparecer na pagina HOME
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$Modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses \Framework\App\Controle::$usuario
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        self::Widgets();
        // Carrega Expedientes
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Expediente')) {
            usuario_ExpedienteControle::Disponivel('Maior');
            usuario_ExpedienteControle::Almoco('Menor');
        }
    }
    static function Widget(&$_Controle) {
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Cliente')) {
            $_Controle->Widget_Add('Superior',
            '<li class="dropdown mtop5">'.
                '<a class="dropdown-toggle element lajax" data-acao="" data-placement="bottom" data-toggle="tooltip" href="'.URL_PATH.'usuario/Admin/Usuarios_Add/cliente" data-original-title="Novo Cliente">'.
                    '<i class="fa fa-user"></i>'.
                '</a>'.
            '</li>');
        }
        return TRUE;
    }             
    static function Busca(&$controle, &$Modelo, &$Visual, $busca) {
        $where = Array(Array(
          'login'       => '%'.$busca.'%',
          'nome'        => '%'.$busca.'%',
          'cpf'         => '%'.$busca.'%',
          'cpf'         => '%'.$busca.'%',
          'cep'         => '%'.$busca.'%',
          'telefone'    => '%'.$busca.'%',
          'celular'     => '%'.$busca.'%',
          'email'       => '%'.$busca.'%'
        ));
        $i = 0;
        // add botao
        $usuario = $Modelo->db->Sql_Select('Usuario', $where,0, '',TRUE);
        if ($usuario === FALSE) return FALSE;
        $Visual->Blocar('<a title="Adicionar Usuário" class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Add">Adicionar novo Usuário</a><div class="space15"></div>');
        if (is_object($usuario)) $usuario = Array(0=>$usuario);
        if ($usuario !== FALSE && !empty($usuario)) {
            reset($usuario);
            foreach ($usuario as $indice=>&$valor) {
                //$table['#Id'][$i]               = '#'.$valor->id;
                $table['Nome'][$i]             = $valor->nome;
                $table['Email'][$i]            = $valor->email;
                $table['Telefone'][$i]         = $valor->telefone;
                $table['Celular'][$i]          = $valor->celular;
                //if ($grupo == FALSE) {
                    $table['Grupo'][$i]        = $valor->grupo;
                //}
                //$table['Nivel de Usuário'][$i] = $niveluser;
                //$table['Nivel de Admin'][$i]   = $niveladmin;
                if (\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro')) $table['Saldo'][$i]            = $valor->saldo;
                $table['Funções'][$i]          = '';
                if (\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro')) {
                    $table['Funções'][$i]     .= '<a data-confirma="O cliente realizou um deposito para a empresa?" title="Add quantia ao Saldo do Usuário" class="lajax explicar-titulo" data-acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_deposito/'.$valor->id.'/"><img alt="'.__('Armazenar Depósito').' src="'.WEB_URL.'img/icons/cifrao_16x16.png"></a>'.
                    '<a data-confirma="O cliente confirmou o saque?" title="Remover Quantia do Saldo do Usuário" class="lajax explicar-titulo" data-acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_retirar/'.$valor->id.'/"><img alt="'.__('Armazenar Retirada').' src="'.WEB_URL.'img/icons/cifrao_16x16.png"></a>';
                }
                $table['Funções'][$i]         .= '<a title="Editar Usuário" class="lajax explicar-titulo" data-acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Edit/'.$valor->id.'/"><img alt="'.__('Editar Usuário').' src="'.WEB_URL.'img/icons/icon_edit.png"></a> '.
                '<a data-confirma="Deseja realmente deletar esse usuário?" title="Deletar Usuário" class="lajax explicar-titulo" data-acao="" href="'.URL_PATH.'usuario/Admin/usuarios_Del/'.$valor->id.'/"><img alt="'.__('Deletar Usuário').' src="'.WEB_URL.'img/icons/icon_bad.png"></a>';
                ++$i;
            }
            $Visual->Show_Tabela_DataTable($table);;
            unset($table);
        } else { 
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Usuário na busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Usuários: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Config() {
        return FALSE;
    }
    
    static function Relatorio($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    
    static function Estatistica($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    
    public static function Widgets() {
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        //if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Principal_Widgets')) return FALSE;
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Funcionario')) {
            $where = Array(
                'EXTA.categoria'    =>  CFG_TEC_CAT_ID_FUNCIONARIOS,
                'ativado'           =>  1
            );
            $inner_join = 'INNER JOIN '.MYSQL_SIS_GRUPO.' SG ON U.grupo=SG.id';
            $funcionario_qnt = $Modelo->db->Sql_Contar('Usuario', 'SG.categoria=\''.CFG_TEC_CAT_ID_FUNCIONARIOS.'\' AND ativado=\'1\'', $inner_join);
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                'Funcionários', 
                'usuario/Admin/ListarFuncionario/', 
                'group', 
                $funcionario_qnt, 
                'light-brown', 
                FALSE, 
                140
            );
        } else {
            
            
            
            
            $usuario_qnt = $Modelo->db->Sql_Contar('Usuario', 'grupo!=4 AND ativado=1');
            
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                'Usuários',
                'usuario/Admin/ListarUsuario/',
                'unlock-alt',
                $usuario_qnt,
                'deep-gray',
                FALSE,
                111
            );
            
            
            
            
        }
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Cliente')) {
            // Clientes
            $inner_join = 'INNER JOIN '.MYSQL_SIS_GRUPO.' SG ON U.grupo=SG.id';
            $cliente_qnt = $Modelo->db->Sql_Contar('Usuario', 'SG.categoria=\''.CFG_TEC_CAT_ID_CLIENTES.'\'', $inner_join);
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome'), 
                'usuario/Admin/ListarCliente/', 
                'user', 
                $cliente_qnt, 
                'block-purple', 
                FALSE, 
                260
            );
        }
    }
}
?>
