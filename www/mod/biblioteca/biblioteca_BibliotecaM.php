<?php

class biblioteca_BibliotecaModelo extends biblioteca_Modelo
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
    * @version 0.4.2
    */
    public function __construct() {
        parent::__construct();
    }
    public function Bibliotecas($raiz = FALSE) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Biblioteca';
        if ($raiz === FALSE) {
            $raiz = 0;
        }
        $where = 'parent=\''.$raiz.'\'';
        
    
        $perm_baixar = $this->_Registro->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Download');
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Bibliotecas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Bibliotecas_Del');
        
        $function = '';
        $function .= ' if ($row[\'tipo\']==1) { ';
            if ($perm_editar) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Visualizar\'     ,Array(__(\'Visualizar Pasta\')        ,\'biblioteca/Biblioteca/Bibliotecas/\'.$d    ,\'\'),TRUE);';
            if ($perm_editar) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Pasta\')        ,\'biblioteca/Biblioteca/Bibliotecas_Edit/\'.$d.\'/'.$raiz.'\'    ,\'\'),TRUE);';
            if ($perm_del) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(__(\'Deletar Pasta\')       ,\'biblioteca/Biblioteca/Bibliotecas_Del/\'.$d.\'/'.$raiz.'\'     ,__(\'Deseja realmente deletar essa pasta ?\')),TRUE);';
        $function .= ' } else { ';
            if ($perm_baixar) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Baixar\'     ,Array(__(\'Download de Arquivo\')   ,\'biblioteca/Biblioteca/Download/\'.$d    ,\'\'),TRUE);';
            if ($perm_editar) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Arquivo\')        ,\'biblioteca/Biblioteca/Bibliotecas_Edit/\'.$d.\'/'.$raiz.'\'    ,\'\'),TRUE);';
            if ($perm_del) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(__(\'Deletar Arquivo\')       ,\'biblioteca/Biblioteca/Bibliotecas_Del/\'.$d.\'/'.$raiz.'\'     ,__(\'Deseja realmente deletar esse arquivo ?\')),TRUE);';
        $function .= ' } ';
        $columns = Array();
        
        $numero = -1;
        

        //'#Tipo';
        ++$numero;
        $columns[] = array( 'db' => 'tipo', 'dt' => $numero,
            'formatter' => function( $d, $row ) {
                if ($d==1) {
                    $tipo       =   'pasta';
                    $foto = WEB_URL.'img'.US.'arquivos'.US.$tipo.'.png';
                    return '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$row['id'].'/" border="1" class="lajax" data-acao=""><img src="'.$foto.'" alt="'.__('Abrir Diretório').'" /></a>';
                } else {
                    $tipo  = \Framework\App\Sistema_Funcoes::Control_Arq_Ext($row['ext']);
                    $endereco = ARQ_PATH.'bibliotecas'.DS.strtolower($row['arquivo']).'.'.$tipo;
                    if (!file_exists($endereco)) {
                        return 'X';
                    }
                    if (file_exists(WEB_PATH.'img'.US.'arquivos'.US.$tipo.'.png')) {
                        $foto = WEB_URL.'img'.US.'arquivos'.US.$tipo.'.png';
                    } else {
                        $foto = WEB_URL.'img'.US.'arquivos'.US.'desconhecido.png';
                    }
                    return '<a href="'.URL_PATH.'biblioteca/Biblioteca/Download/'.$row['id'].'/" border="1" target="_BLANK"><img src="'.$foto.'" alt="'.__('Fazer Download de Extensão: ').$tipo.'" /></a>';
                }
            }
        );
        
        //'ext';
        ++$numero;
        $columns[] = array( 'db' => 'ext', 'dt' => $numero,
            'formatter' => function( $d, $row ) {
                if ($row['tipo']==1) {
                    return 'Pasta';
                } else {
                    return \Framework\App\Sistema_Funcoes::Control_Arq_Ext($d);
                }
            }
        );
        
        // Nome
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero,
            'formatter' => function( $d, $row ) {
                if ($row['tipo']==1) {
                    return '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$row['id'].'/" border="1" class="lajax" data-acao="">'.$d.'</a>';
                } else {
                    return '<a href="'.URL_PATH.'biblioteca/Biblioteca/Download/'.$row['id'].'/" border="1" target="_BLANK">'.$d.'</a>';
                }
            }
        );
        
                
                        
        ++$numero;
        $columns[] = array( 'db' => 'obs', 'dt' => $numero); //'DEscricao';

        
        
        
        
        // Tamanho
        ++$numero;
        $columns[] = array( 'db' => 'tamanho', 'dt' => $numero,
            'formatter' => function( $d, $row ) {
                // Tamanho
                $tamanho = (int) $d;
                if ($tamanho === 0) {
                    if ($row['tipo']==1) {
                        $tamanho = \Framework\App\Registro::getInstacia()->_Controle->Bibliotecas_AtualizaTamanho_Pai($row['id']);
                    } else {
                        $endereco = ARQ_PATH.'bibliotecas'.DS.strtolower($row['arquivo']).'.'.\Framework\App\Sistema_Funcoes::Control_Arq_Ext($row['ext']);
                        if (!file_exists($endereco)) {
                            return 'X';
                        }
                        $tamanho = filesize($endereco);
                        \Framework\App\Registro::getInstacia()->query('UPDATE '.  \Framework\App\Conexao::$tabelas['Biblioteca_DAO']['nome'].' SET tamanho=\''.$tamanho.'\' WHERE id='.$row['id']);

                    }
                }
                return \Framework\App\Sistema_Funcoes::Tranf_Byte_Otimizado($tamanho);
            }
        );
        
        ++$numero;
        $columns[] = array( 'db' => 'usuario2', 'dt' => $numero); //'Criador';
        
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add', 'dt' => $numero); //'Data';
        
        //'Arquivo'; 
        ++$numero;
        $columns[] = array( 'db' => 'arquivo', 'dt' => $numero,
            'formatter' => function( $d, $row ) {
                if ($row['tipo']==1) {
                    return __('Diretório');
                } else {
                    return $d.'.'.$row['ext'];
                }
            }
        ); 
        
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null, $where)
        );
    }
}
?>