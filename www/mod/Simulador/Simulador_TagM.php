<?php

class Simulador_TagModelo extends Simulador_Modelo
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
    * @version 3.1.1
    */
    public function __construct(){
        parent::__construct();
    }
    public function Tags(){
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Simulador_Tag';
        $where = '';
        
    
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Del');
        
        $function = '';
        $function .= ' if($row[\'tipo\']==1){ ';
            if($perm_editar) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Pasta\')        ,\'Simulador/Tag/Tags_Edit/\'.$d.\'/'.$raiz.'\'    ,\'\'),true);';
            if($perm_del) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(__(\'Deletar Pasta\')       ,\'Simulador/Tag/Tags_Del/\'.$d.\'/'.$raiz.'\'     ,__(\'Deseja realmente deletar essa pasta ?\')),true);';
        $function .= ' }else{ ';
            if($perm_baixar) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Baixar\'     ,Array(__(\'Download de Arquivo\')   ,\'Simulador/Tag/Download/\'.$d    ,\'\'),true);';
            if($perm_editar) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Arquivo\')        ,\'Simulador/Tag/Tags_Edit/\'.$d.\'/'.$raiz.'\'    ,\'\'),true);';
            if($perm_del) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(__(\'Deletar Arquivo\')       ,\'Simulador/Tag/Tags_Del/\'.$d.\'/'.$raiz.'\'     ,__(\'Deseja realmente deletar esse arquivo ?\')),true);';
        $function .= ' } ';
        $columns = Array();
        
        $numero = -1;
        
        //'ext';
        ++$numero;
        $columns[] = array( 'db' => 'ext', 'dt' => $numero,
            'formatter' => function( $d, $row ) {
                if($row['tipo']==1){
                    return 'Pasta';
                }else{
                    return \Framework\App\Sistema_Funcoes::Control_Arq_Ext($d);
                }
            }
        );
        
        // Nome
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero
        );
        
                
                        
        ++$numero;
        $columns[] = array( 'db' => 'obs', 'dt' => $numero); //'DEscricao';

        
        
        
        
        ++$numero;
        $columns[] = array( 'db' => 'usuario2', 'dt' => $numero); //'Criador';
        
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add', 'dt' => $numero); //'Data';
        
        //'Arquivo'; 
        ++$numero;
        $columns[] = array( 'db' => 'arquivo', 'dt' => $numero,
            'formatter' => function( $d, $row ) {
                if($row['tipo']==1){
                    return __('Diretório');
                }else{
                    return $d.'.'.$row['ext'];
                }
            }
        ); 
        
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where)
        );
    }
}
?>