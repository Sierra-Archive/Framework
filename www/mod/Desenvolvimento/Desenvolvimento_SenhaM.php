<?php

class Desenvolvimento_SenhaModelo extends Desenvolvimento_Modelo
{
    /**
     * __construct
     * 
     * @name __construct
     * @access public
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     * 
     */
    public function __construct(){
      parent::__construct();
    }
    public function Senhas(){
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        // Colunas
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'categoria2',    'dt' => 1 ),
            array( 'db' => 'url',           'dt' => 2,
                'formatter' => function( $d, $row ) {
                    return '<a href=\'http://'.$d.'\' target="_BLANK">'.$d.'</a>';
                }
            ),
            array( 'db' => 'login',         'dt' => 3 ),
            array( 'db' => 'senha',         'dt' => 4 )
        );
        // Destaque, somente se tiver permissao
        $numero = 4;
        if($perm_destaque){
            ++$numero;
            $columns[] = array( 'db' => 'destaque'    ,  'dt' => $numero ,
                    'formatter' => function( $d, $row ) {

                    if($d=='0'){
                        $nometipo = __('Não Destaque');
                    }
                    else{
                        $nometipo = __('Destaque');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if(strpos(strtolower('Não Destaque'), strtolower($search))!=false){
                        return '0';
                    }else if(strpos(strtolower('Destaque'), strtolower($search))!=false){
                        return '1';
                    }
                    return false;
                }
            );
        }
        if($perm_status){
            ++$numero;
            $columns[] = array( 'db' => 'status'      ,  'dt' => $numero ,
                'formatter' => function( $d, $row ) {
                    if($d=='0'){
                        $nometipo = __('Ultrapassada');
                    }
                    else{
                        $nometipo = __('Em Uso');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if(strpos(strtolower('Ultrapassada'), strtolower($search))!==false){
                        return '0';
                    }else if(strpos(strtolower('Em Uso'), strtolower($search))!==false){
                        return '1';
                    }
                    return false;
                }
            );
        }
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add',  'dt' => $numero );
        ++$numero;
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
                'formatter' => $funcao
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Desenvolvimento_Senha', $primaryKey, $columns, null,'status=1' )
        );
    }
    public function Senhas_Todas(){
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Todas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Todas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status_Todas');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque_Todas');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Todas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Todas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        
        //Colunas
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'usuario2',      'dt' => 1 ),
            array( 'db' => 'categoria2',    'dt' => 2 ),
            array( 'db' => 'url',           'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                    return '<a href=\'http://'.$d.'\' target="_BLANK">'.$d.'</a>';
                }
            ),
            array( 'db' => 'login',         'dt' => 4 ),
            array( 'db' => 'senha',         'dt' => 5 )
        );
        // Destaque, somente se tiver permissao
        $numero = 5;
        if($perm_destaque){
            ++$numero;
            $columns[] = array( 'db' => 'destaque'    ,  'dt' => $numero ,
                    'formatter' => function( $d, $row ) {

                    if($d=='0'){
                        $nometipo = __('Não Destaque');
                    }
                    else{
                        $nometipo = __('Destaque');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if(strpos(strtolower('Destaque'), strtolower($search))!=false){
                        return '0';
                    }else if(strpos(strtolower('Não Destaque'), strtolower($search))!=false){
                        return '1';
                    }
                    return false;
                }
            );
        }
        if($perm_status){
            ++$numero;
            $columns[] = array( 'db' => 'status'      ,  'dt' => $numero ,
                'formatter' => function( $d, $row ) {
                    if($d=='0'){
                        $nometipo = __('Ultrapassada');
                    }
                    else{
                        $nometipo = __('Em Uso');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if(strpos(strtolower('Ultrapassada'), strtolower($search))!=false){
                        return '0';
                    }else if(strpos(strtolower('Em Uso'), strtolower($search))!=false){
                        return '1';
                    }
                    return false;
                }
            );
        }
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add',  'dt' => $numero );
        ++$numero;
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
                'formatter' => $funcao
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Desenvolvimento_Senha', $primaryKey, $columns, null,'status=1' )
        );
    }
    public function Senhas_Antigas(){
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'categoria2',    'dt' => 1 ),
            array( 'db' => 'url',           'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return '<a href=\'http://'.$d.'\' target="_BLANK">'.$d.'</a>';
                }
            ),
            array( 'db' => 'login',         'dt' => 3 ),
            array( 'db' => 'senha',         'dt' => 4 )
        );
        // Destaque, somente se tiver permissao
        $numero = 4;
        if($perm_destaque){
            ++$numero;
            $columns[] = array( 'db' => 'destaque'    ,  'dt' => $numero ,
                    'formatter' => function( $d, $row ) {

                    if($d=='0'){
                        $nometipo = __('Não Destaque');
                    }
                    else{
                        $nometipo = __('Destaque');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if(strpos(strtolower('Não Destaque'), strtolower($search))!=false){
                        return '0';
                    }else if(strpos(strtolower('Destaque'), strtolower($search))!=false){
                        return '1';
                    }
                    return false;
                }
            );
        }
        if($perm_status){
            ++$numero;
            $columns[] = array( 'db' => 'status'      ,  'dt' => $numero ,
                'formatter' => function( $d, $row ) {
                    if($d=='0'){
                        $nometipo = __('Ultrapassada');
                    }
                    else{
                        $nometipo = __('Em Uso');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if(strpos(strtolower('Ultrapassada'), strtolower($search))!=false){
                        return '0';
                    }else if(strpos(strtolower('Em Uso'), strtolower($search))!=false){
                        return '1';
                    }
                    return false;
                }
            );
        }
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add',  'dt' => $numero );
        ++$numero;
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
                'formatter' => $funcao
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Desenvolvimento_Senha', $primaryKey, $columns, null,'status=0' )
        );
    }
    public function Senhas_Todas_Antigas(){
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Todas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Todas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status_Todas');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque_Todas');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Todas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Todas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        // Colunas
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'usuario2',      'dt' => 1 ),
            array( 'db' => 'categoria2',    'dt' => 2 ),
            array( 'db' => 'url',           'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                    return '<a href=\'http://'.$d.'\' target="_BLANK">'.$d.'</a>';
                }
            ),
            array( 'db' => 'login',         'dt' => 4 ),
            array( 'db' => 'senha',         'dt' => 5 )
        );
        // Destaque, somente se tiver permissao
        $numero = 5;
        if($perm_destaque){
            ++$numero;
            $columns[] = array( 'db' => 'destaque'    ,  'dt' => $numero ,
                    'formatter' => function( $d, $row ) {

                    if($d=='0'){
                        $nometipo = __('Não Destaque');
                    }
                    else{
                        $nometipo = __('Destaque');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if(strpos(strtolower('Destaque'), strtolower($search))!=false){
                        return '0';
                    }else if(strpos(strtolower('Não Destaque'), strtolower($search))!=false){
                        return '1';
                    }
                    return false;
                }
            );
        }
        if($perm_status){
            ++$numero;
            $columns[] = array( 'db' => 'status'      ,  'dt' => $numero ,
                'formatter' => function( $d, $row ) {
                    if($d=='0'){
                        $nometipo = __('Ultrapassada');
                    }
                    else{
                        $nometipo = __('Em Uso');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if(strpos(strtolower('Ultrapassada'), strtolower($search))!=false){
                        return '0';
                    }else if(strpos(strtolower('Em Uso'), strtolower($search))!=false){
                        return '1';
                    }
                    return false;
                }
            );
        }
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add',  'dt' => $numero );
        ++$numero;
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
                'formatter' => $funcao
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Desenvolvimento_Senha', $primaryKey, $columns, null,'status=0' )
        );
    }
}
?>