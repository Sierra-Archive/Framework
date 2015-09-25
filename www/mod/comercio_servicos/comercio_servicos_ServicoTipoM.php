<?php

class comercio_servicos_ServicoTipoModelo extends comercio_servicos_Modelo
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
    public function __construct(){
        parent::__construct();
    }
    public function Servico_Tipo(){
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Comercio_Servicos_Servico_Tipo';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/ServicoTipo/Servico_Tipo_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/ServicoTipo/Servico_Tipo_Del');
        
        $function = '';
        if($perm_editar){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar Produto\'        ,\'comercio_servicos/ServicoTipo/Servico_Tipo_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if($perm_del){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar Produto\'       ,\'comercio_servicos/ServicoTipo/Servico_Tipo_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar esse Tipo de Serviço ?\'),true);';
        }

        $columns = Array();
        
        $numero = -1;

        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Nome';

        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null)
        );
    }
}
?>