<?php
class Curso_Modelo extends \Framework\App\Modelo
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
    static function Financeiro_Motivo_Exibir($motivoid){
        $motivoid = (int) $motivoid;
        $registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$registro->_Modelo;
        $item = $_Modelo->db->Sql_Select('Curso_Turma_Inscricao','{sigla}id=\''.$motivoid.'\'',1);
        return Array('<b>Matricula na Turma </b> em '.$item->turma2,$item->usuario2);
    }
}
?>