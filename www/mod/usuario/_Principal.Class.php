<?php

class usuario_Principal implements PrincipalInterface
{
    /**
    * Função Home para o modulo usuario aparecer na pagina HOME
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses \Framework\App\Controle::$usuario
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function Home(&$controle, &$modelo, &$Visual){
        if(\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro') && \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Financeiro_User_Planos') && \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Financeiro_User_Saldo')){
            usuario_Controle::PlanoStatus($modelo, $Visual, \Framework\App\Acl::Usuario_GetID_Static());
        }
        self::Widgets();
    }
    static function Widget(&$_Controle){
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Cliente')){
            $_Controle->Widget_Add('Superior',
            '<li class="dropdown mtop5">'.
                '<a class="dropdown-toggle element lajax" acao="" data-placement="bottom" data-toggle="tooltip" href="'.URL_PATH.'usuario/Admin/Usuarios_Add/cliente" data-original-title="Novo Cliente">'.
                    '<i class="glyphicon-user"></i>'.
                '</a>'.
            '</li>');
        }
        return true;
    }             
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
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
        $usuario = $modelo->db->Sql_Select('Usuario',$where,0,'',true);
        if($usuario===false) return false;
        $Visual->Blocar('<a title="Adicionar Usuário" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Add">Adicionar novo Usuário</a><div class="space15"></div>');
        if(is_object($usuario)) $usuario = Array(0=>$usuario);
        if($usuario!==false && !empty($usuario)){
            reset($usuario);
            foreach ($usuario as $indice=>&$valor) {
                //$tabela['#Id'][$i]               = '#'.$valor->id;
                $tabela['Nome'][$i]             = $valor->nome;
                $tabela['Email'][$i]            = $valor->email;
                $tabela['Telefone'][$i]         = $valor->telefone;
                $tabela['Celular'][$i]          = $valor->celular;
                //if($grupo==false){
                    $tabela['Grupo'][$i]        = $valor->grupo;
                //}
                //$tabela['Nivel de Usuário'][$i] = $niveluser;
                //$tabela['Nivel de Admin'][$i]   = $niveladmin;
                if(\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro')) $tabela['Saldo'][$i]            = $valor->saldo;
                $tabela['Funções'][$i]          = '';
                if(\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro')){
                    $tabela['Funções'][$i]     .= '<a confirma="O cliente realizou um deposito para a empresa?" title="Add quantia ao Saldo do Usuário" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_deposito/'.$valor->id.'/"><img border="0" src="'.WEB_URL.'img/icons/cifrao_16x16.png"></a>'.
                    '<a confirma="O cliente confirmou o saque?" title="Remover Quantia do Saldo do Usuário" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_retirar/'.$valor->id.'/"><img border="0" src="'.WEB_URL.'img/icons/cifrao_16x16.png"></a>';
                }
                $tabela['Funções'][$i]         .= '<a title="Editar Usuário" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Edit/'.$valor->id.'/"><img border="0" src="'.WEB_URL.'img/icons/icon_edit.png"></a> '.
                '<a confirma="Deseja realmente deletar esse usuário?" title="Deletar Usuário" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario/Admin/usuarios_Del/'.$valor->id.'/"><img border="0" src="'.WEB_URL.'img/icons/icon_bad.png"></a>';
                ++$i;
            }
            $Visual->Show_Tabela_DataTable($tabela);;
            unset($tabela);
        }else{ 
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Usuário na busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Usuários: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Config(){
        return false;
    }
    
    static function Relatorio($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    static function Estatistica($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    public static function Widgets(){
        $Registro = &\Framework\App\Registro::getInstacia();
        $modelo = $Registro->_Modelo;
        $Visual = $Registro->_Visual;
        //if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Principal_Widgets')) return false;
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Funcionario')){
            $where = Array(
                'EXTA.categoria'    =>  CFG_TEC_CAT_ID_FUNCIONARIOS,
                'ativado'           =>  1
            );
            $funcionario = $modelo->db->Sql_Select('Usuario',$where,0, '','id,grupo.categoria');
            if(is_object($funcionario)) $funcionario = Array(0=>$funcionario);
            if($funcionario!==false && !empty($funcionario)){reset($funcionario);$funcionario_qnt = count($funcionario);}else{$funcionario_qnt = 0;}
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                'Funcionários', 
                'usuario/Admin/ListarFuncionarios/', 
                'group', 
                $funcionario_qnt, 
                'light-brown', 
                false, 
                140
            );
        }else{
            
            
            
            
            $usuario_qnt = $modelo->db->Sql_Contar('Usuario','grupo!=4 AND ativado=1');
            
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                'Usuários',
                'usuario/Admin/ListarOutros/',
                'unlock-alt',
                $usuario_qnt,
                'deep-gray',
                false,
                111
            );
            
            
            
            
        }
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Cliente')){
            // Clientes
            $where = Array(
                'EXTA.categoria'    =>  CFG_TEC_CAT_ID_CLIENTES
            );
            $cliente = $modelo->db->Sql_Select('Usuario',$where,0, '','id,grupo.categoria');
            if(is_object($cliente)) $cliente = Array(0=>$cliente);
            if($cliente!==false && !empty($cliente)){reset($cliente);$cliente_qnt = count($cliente);}else{$cliente_qnt = 0;}
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome'), 
                'usuario/Admin/ListarCliente/', 
                'user', 
                $cliente_qnt, 
                'block-purple', 
                false, 
                260
            );
        }
    }
}
?>
