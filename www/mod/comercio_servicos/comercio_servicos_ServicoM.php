<?php

class comercio_servicos_ServicoModelo extends comercio_servicos_Modelo
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
    public function Servico() {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Comercio_Servicos_Servico';
        
        // Titulos
        $titulo             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2            = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        if (Framework\Classes\Texto::Captura_Palavra_Masculina($titulo2)===true) {
            $titulo_com_sexo    = 'o '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        } else {
            $titulo_com_sexo    = 'a '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        }
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/Servico/Servicos_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/Servico/Servicos_Del');
        
        $function = '';
        if ($perm_editar) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar '.$titulo2.'\'        ,\'comercio_servicos/Servico/Servicos_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($perm_del) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar '.$titulo2.'\'       ,\'comercio_servicos/Servico/Servicos_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar ess'.$titulo_com_sexo.' ?\'),true);';
        }

        
        $columns = Array();
        $numero = -1;

        
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_ServicoTipo')) {
            ++$numero;
            $columns[] = array( 'db' => 'tipo2', 'dt' => $numero); //'#Tipo de ...';
        }
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_nome')) {
            ++$numero;
            $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'#Nome';
        }
        ++$numero;
        $columns[] = array( 'db' => 'descricao', 'dt' => $numero); //'#Descriçao';
        ++$numero;
        $columns[] = array( 'db' => 'preco', 'dt' => $numero); //'#Preço';
        
        // Funcoes        
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