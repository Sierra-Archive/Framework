<?php

class Seguranca_SenhaModelo extends Seguranca_Modelo
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
     * @version 2.0
     * 
     */
    public function __construct(){
      parent::__construct();
    }
    public function Senhas(){
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        if($perm_status){
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }else{
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }
        if($perm_destaque){
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }else{
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'categoria2',    'dt' => 1 ),
            array( 'db' => 'url',           'dt' => 2 ),
            array( 'db' => 'login',         'dt' => 3 ),
            array( 'db' => 'senha',         'dt' => 4 ),
            array( 'db' => 'destaque'    ,  'dt' => 5 ,
                'formatter' => $funcao_destaque),
            array( 'db' => 'status'      ,  'dt' => 6 ,
                'formatter' => $funcao_status,
                'search' => function( $search ) {
                    if(strpos(strtolower($url), strtolower($objeto->end))!=false){
                        
                    }
                    return '#'.$d;
                }),
            array( 'db' => 'log_date_add',  'dt' => 7 ),
            array( 'db' => 'id',            'dt' => 8,
                'formatter' => $funcao)
            /*array(
                'db'        => 'start_date',
                'dt'        => 4,
                'formatter' => function( $d, $row ) {
                    return date( 'jS M y', strtotime($d));
                }
            ),
            array(
                'db'        => 'salary',
                'dt'        => 5,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                }
            )*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Seguranca_Senha', $primaryKey, $columns, null,'status=1' )
        );
    }
    public function Senhas_Todas(){
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Todas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Todas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Status_Todas');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque_Todas');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Todas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Todas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        if($perm_status){
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }else{
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }
        if($perm_destaque){
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }else{
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'usuario2',      'dt' => 1 ),
            array( 'db' => 'categoria2',    'dt' => 2 ),
            array( 'db' => 'url',           'dt' => 3 ),
            array( 'db' => 'login',         'dt' => 4 ),
            array( 'db' => 'senha',         'dt' => 5 ),
            array( 'db' => 'destaque'    ,  'dt' => 6 ,
                'formatter' => $funcao_destaque),
            array( 'db' => 'status'      ,  'dt' => 7 ,
                'formatter' => $funcao_status,
                'search' => function( $search ) {
                    if(strpos(strtolower($url), strtolower($objeto->end))!=false){
                        
                    }
                    return '#'.$d;
                }),
            array( 'db' => 'log_date_add',  'dt' => 8 ),
            array( 'db' => 'id',            'dt' => 9,
                'formatter' => $funcao)
            /*array(
                'db'        => 'start_date',
                'dt'        => 4,
                'formatter' => function( $d, $row ) {
                    return date( 'jS M y', strtotime($d));
                }
            ),
            array(
                'db'        => 'salary',
                'dt'        => 5,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                }
            )*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Seguranca_Senha', $primaryKey, $columns, null,'status=1' )
        );
    }
    public function Senhas_Antigas(){
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        if($perm_status){
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }else{
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }
        if($perm_destaque){
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }else{
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'categoria2',    'dt' => 1 ),
            array( 'db' => 'url',           'dt' => 2 ),
            array( 'db' => 'login',         'dt' => 3 ),
            array( 'db' => 'senha',         'dt' => 4 ),
            array( 'db' => 'destaque'    ,  'dt' => 5 ,
                'formatter' => $funcao_destaque),
            array( 'db' => 'status'      ,  'dt' => 6 ,
                'formatter' => $funcao_status,
                'search' => function( $search ) {
                    if(strpos(strtolower($url), strtolower($objeto->end))!=false){
                        
                    }
                    return '#'.$d;
                }),
            array( 'db' => 'log_date_add',  'dt' => 7 ),
            array( 'db' => 'id',            'dt' => 8,
                'formatter' => $funcao)
            /*array(
                'db'        => 'start_date',
                'dt'        => 4,
                'formatter' => function( $d, $row ) {
                    return date( 'jS M y', strtotime($d));
                }
            ),
            array(
                'db'        => 'salary',
                'dt'        => 5,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                }
            )*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Seguranca_Senha', $primaryKey, $columns, null,'status=0' )
        );
    }
    public function Senhas_Todas_Antigas(){
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Todas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Todas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Status_Todas');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque_Todas');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Todas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Todas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        if($perm_status){
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }else{
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }
        if($perm_destaque){
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }else{
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'usuario2',      'dt' => 1 ),
            array( 'db' => 'categoria2',    'dt' => 2 ),
            array( 'db' => 'url',           'dt' => 3 ),
            array( 'db' => 'login',         'dt' => 4 ),
            array( 'db' => 'senha',         'dt' => 5 ),
            array( 'db' => 'destaque'    ,  'dt' => 6 ,
                'formatter' => $funcao_destaque),
            array( 'db' => 'status'      ,  'dt' => 7 ,
                'formatter' => $funcao_status,
                'search' => function( $search ) {
                    if(strpos(strtolower($url), strtolower($objeto->end))!=false){
                        
                    }
                    return '#'.$d;
                }),
            array( 'db' => 'log_date_add',  'dt' => 8 ),
            array( 'db' => 'id',            'dt' => 9,
                'formatter' => $funcao)
            /*array(
                'db'        => 'start_date',
                'dt'        => 4,
                'formatter' => function( $d, $row ) {
                    return date( 'jS M y', strtotime($d));
                }
            ),
            array(
                'db'        => 'salary',
                'dt'        => 5,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                }
            )*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Seguranca_Senha', $primaryKey, $columns, null,'status=0' )
        );
    }
}
?>