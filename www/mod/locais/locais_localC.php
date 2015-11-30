<?php
class locais_localControle extends locais_Controle
{

    public function __construct() {
        $this->_Visual = new \Framework\App\Visual();
        $this->_Modelo = new locaisModelo();
        parent::__construct();
    }
    public function select_estados($id) {
        

        $pais = (int) $id;
        $select = array();
        $this->_Modelo->estados_retorna($select, $pais);

        if (LAYOULT_IMPRIMIR=='AJAX') {
            $this->_Visual->Json_Start();
            $conteudo = array(
                'id' => 'selectlocalestado',
                'valores' => $select
            );
            $this->_Visual->Json_IncluiTipo('Select', $conteudo);
            echo $this->_Visual->Json_Retorna();
        }
    }
    public function select_cidades($id) {
        

        $estado = (int) $id;
        $select = array();
        $this->_Modelo->cidades_retorna($select, $estado);

        if (LAYOULT_IMPRIMIR=='AJAX') {
                $this->_Visual->Json_Start();
                $conteudo = array(
                        'id' => 'selectlocalcidade',
                        'valores' => $select
                );
                $this->_Visual->Json_IncluiTipo('Select', $conteudo);
                echo $this->_Visual->Json_Retorna();
        }
    }
    public function select_bairros($id) {
        

        $cidade = (int) $id;
        $select = array();
        $this->_Modelo->bairros_retorna($select, $cidade);

        if (LAYOULT_IMPRIMIR=='AJAX') {
                $this->_Visual->Json_Start();
                $conteudo = array(
                        'id' => 'selectlocalbairro',
                        'valores' => $select
                );
                $this->_Visual->Json_IncluiTipo('Select', $conteudo);
                echo $this->_Visual->Json_Retorna();
        }
    }
}
?>