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
    public function __construct() {
      parent::__construct();
    }
    public function Senhas() {
        // Table's primary key
        $primaryKey = 'id';
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Del');
        $permissionStatus = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status');
        $permissionFeatured = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque');
        
        if ($permissionEdit && $permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Edit/'.$d.'/'    , ''),TRUE).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),TRUE);
            };
        } else if ($permissionEdit) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Edit/'.$d.'/'    , ''),TRUE);
            };
        } else if ($permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),TRUE);
            };
        } else {
            $function = function( $d, $row ) {
                return '';
            };
        }
        
        // Colunas
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'categoria2', 'dt' => 1 ),
            array( 'db' => 'url', 'dt' => 2,
                'formatter' => function( $d, $row ) {
                    return '<a href=\'http://'.$d.'\' target="_BLANK">'.$d.'</a>';
                }
            ),
            array( 'db' => 'login', 'dt' => 3 ),
            array( 'db' => 'senha', 'dt' => 4 )
        );
        // Destaque, somente se tiver permissao
        $numero = 4;
        if ($permissionFeatured) {
            ++$numero;
            $columns[] = array( 'db' => 'destaque'    ,  'dt' => $numero ,
                    'formatter' => function( $d, $row ) {

                    if ($d=='0') {
                        $nometipo = __('Não Destaque');
                    }
                    else{
                        $nometipo = __('Destaque');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if (strpos(strtolower('Não Destaque'), strtolower($search)) !== FALSE) {
                        return '0';
                    } else if (strpos(strtolower('Destaque'), strtolower($search)) !== FALSE) {
                        return '1';
                    }
                    return FALSE;
                }
            );
        }
        if ($permissionStatus) {
            ++$numero;
            $columns[] = array( 'db' => 'status'      ,  'dt' => $numero ,
                'formatter' => function( $d, $row ) {
                    if ($d=='0') {
                        $nometipo = __('Ultrapassada');
                    }
                    else{
                        $nometipo = __('Em Uso');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if (strpos(strtolower('Ultrapassada'), strtolower($search)) !== FALSE) {
                        return '0';
                    } else if (strpos(strtolower('Em Uso'), strtolower($search)) !== FALSE) {
                        return '1';
                    }
                    return FALSE;
                }
            );
        }
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add', 'dt' => $numero );
        ++$numero;
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
                'formatter' => $function
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Desenvolvimento_Senha', $primaryKey, $columns, null,'status=1' )
        );
    }
    public function Senhas_Todas() {
        // Table's primary key
        $primaryKey = 'id';
        
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Todas_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Todas_Del');
        $permissionStatus = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status_Todas');
        $permissionFeatured = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque_Todas');
        
        if ($permissionEdit && $permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Todas_Edit/'.$d.'/'    , ''),TRUE).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),TRUE);
            };
        } else if ($permissionEdit) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Todas_Edit/'.$d.'/'    , ''),TRUE);
            };
        } else if ($permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),TRUE);
            };
        } else {
            $function = function( $d, $row ) {
                return '';
            };
        }
        
        
        //Colunas
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'usuario2', 'dt' => 1 ),
            array( 'db' => 'categoria2', 'dt' => 2 ),
            array( 'db' => 'url', 'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                    return '<a href=\'http://'.$d.'\' target="_BLANK">'.$d.'</a>';
                }
            ),
            array( 'db' => 'login', 'dt' => 4 ),
            array( 'db' => 'senha', 'dt' => 5 )
        );
        // Destaque, somente se tiver permissao
        $numero = 5;
        if ($permissionFeatured) {
            ++$numero;
            $columns[] = array( 'db' => 'destaque'    ,  'dt' => $numero ,
                    'formatter' => function( $d, $row ) {

                    if ($d=='0') {
                        $nometipo = __('Não Destaque');
                    }
                    else{
                        $nometipo = __('Destaque');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if (strpos(strtolower('Destaque'), strtolower($search)) !== FALSE) {
                        return '0';
                    } else if (strpos(strtolower('Não Destaque'), strtolower($search)) !== FALSE) {
                        return '1';
                    }
                    return FALSE;
                }
            );
        }
        if ($permissionStatus) {
            ++$numero;
            $columns[] = array( 'db' => 'status'      ,  'dt' => $numero ,
                'formatter' => function( $d, $row ) {
                    if ($d=='0') {
                        $nometipo = __('Ultrapassada');
                    }
                    else{
                        $nometipo = __('Em Uso');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if (strpos(strtolower('Ultrapassada'), strtolower($search)) !== FALSE) {
                        return '0';
                    } else if (strpos(strtolower('Em Uso'), strtolower($search)) !== FALSE) {
                        return '1';
                    }
                    return FALSE;
                }
            );
        }
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add', 'dt' => $numero );
        ++$numero;
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
                'formatter' => $function
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Desenvolvimento_Senha', $primaryKey, $columns, null,'status=1' )
        );
    }
    public function Senhas_Antigas() {
        // Table's primary key
        $primaryKey = 'id';
        
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Del');
        $permissionStatus = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status');
        $permissionFeatured = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque');
        
        if ($permissionEdit && $permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Edit/'.$d.'/'    , ''),TRUE).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),TRUE);
            };
        } else if ($permissionEdit) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Edit/'.$d.'/'    , ''),TRUE);
            };
        } else if ($permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),TRUE);
            };
        } else {
            $function = function( $d, $row ) {
                return '';
            };
        }
        

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'categoria2', 'dt' => 1 ),
            array( 'db' => 'url', 'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                    return '<a href=\'http://'.$d.'\' target="_BLANK">'.$d.'</a>';
                }
            ),
            array( 'db' => 'login', 'dt' => 3 ),
            array( 'db' => 'senha', 'dt' => 4 )
        );
        // Destaque, somente se tiver permissao
        $numero = 4;
        if ($permissionFeatured) {
            ++$numero;
            $columns[] = array( 'db' => 'destaque'    ,  'dt' => $numero ,
                    'formatter' => function( $d, $row ) {

                    if ($d=='0') {
                        $nometipo = __('Não Destaque');
                    }
                    else{
                        $nometipo = __('Destaque');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if (strpos(strtolower('Não Destaque'), strtolower($search)) !== FALSE) {
                        return '0';
                    } else if (strpos(strtolower('Destaque'), strtolower($search)) !== FALSE) {
                        return '1';
                    }
                    return FALSE;
                }
            );
        }
        if ($permissionStatus) {
            ++$numero;
            $columns[] = array( 'db' => 'status'      ,  'dt' => $numero ,
                'formatter' => function( $d, $row ) {
                    if ($d=='0') {
                        $nometipo = __('Ultrapassada');
                    }
                    else{
                        $nometipo = __('Em Uso');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if (strpos(strtolower('Ultrapassada'), strtolower($search)) !== FALSE) {
                        return '0';
                    } else if (strpos(strtolower('Em Uso'), strtolower($search)) !== FALSE) {
                        return '1';
                    }
                    return FALSE;
                }
            );
        }
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add', 'dt' => $numero );
        ++$numero;
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
                'formatter' => $function
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Desenvolvimento_Senha', $primaryKey, $columns, null,'status=0' )
        );
    }
    public function Senhas_Todas_Antigas() {
        // Table's primary key
        $primaryKey = 'id';
        
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Todas_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Senhas_Todas_Del');
        $permissionStatus = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status_Todas');
        $permissionFeatured = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque_Todas');
        
        if ($permissionEdit && $permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Todas_Edit/'.$d.'/'    , ''),TRUE).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),TRUE);
            };
        } else if ($permissionEdit) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Todas_Edit/'.$d.'/'    , ''),TRUE);
            };
        } else if ($permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Todas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),TRUE);
            };
        } else {
            $function = function( $d, $row ) {
                return '';
            };
        }
        
        // Colunas
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'usuario2', 'dt' => 1 ),
            array( 'db' => 'categoria2', 'dt' => 2 ),
            array( 'db' => 'url', 'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                    return '<a href=\'http://'.$d.'\' target="_BLANK">'.$d.'</a>';
                }
            ),
            array( 'db' => 'login', 'dt' => 4 ),
            array( 'db' => 'senha', 'dt' => 5 )
        );
        // Destaque, somente se tiver permissao
        $numero = 5;
        if ($permissionFeatured) {
            ++$numero;
            $columns[] = array( 'db' => 'destaque'    ,  'dt' => $numero ,
                    'formatter' => function( $d, $row ) {

                    if ($d=='0') {
                        $nometipo = __('Não Destaque');
                    }
                    else{
                        $nometipo = __('Destaque');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if (strpos(strtolower('Destaque'), strtolower($search)) !== FALSE) {
                        return '0';
                    } else if (strpos(strtolower('Não Destaque'), strtolower($search)) !== FALSE) {
                        return '1';
                    }
                    return FALSE;
                }
            );
        }
        if ($permissionStatus) {
            ++$numero;
            $columns[] = array( 'db' => 'status'      ,  'dt' => $numero ,
                'formatter' => function( $d, $row ) {
                    if ($d=='0') {
                        $nometipo = __('Ultrapassada');
                    }
                    else{
                        $nometipo = __('Em Uso');
                    }
                    return $nometipo;
                },
                'search' => function( $search ) {
                    if (strpos(strtolower('Ultrapassada'), strtolower($search)) !== FALSE) {
                        return '0';
                    } else if (strpos(strtolower('Em Uso'), strtolower($search)) !== FALSE) {
                        return '1';
                    }
                    return FALSE;
                }
            );
        }
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add', 'dt' => $numero );
        ++$numero;
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
                'formatter' => $function
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Desenvolvimento_Senha', $primaryKey, $columns, null,'status=0' )
        );
    }
}