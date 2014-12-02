<?php

class _Sistema_LoginControle extends _Sistema_Controle
{
    public function __construct(){
        parent::__construct();
    }
    public function Main($codigo){
        if(LAYOULT_IMPRIMIR=='AJAX'){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Erro '.$codigo,
                "mgs_secundaria" => $this->_getError($codigo)
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }else{
            $this->_Visual->Blocar($this->_getError($codigo));
            $this->_Visual->Bloco_Maior_CriaJanela('Erro '.$codigo);
        }
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Erro '.$codigo);
    }
    private function _getError($codigo = false){
        if($codigo){
            $codigo = (int) $codigo;
        }else{
            $codigo = 'default';
        }
        
        $error['default'] = 'Um erro ocorreu e a página não pode ser mostrada.';
        $error['5050']    = 'Essa página tem acesso restrito.';
        $error['5051']    = 'Login ou Senha inválida.';
        $error['5052']    = 'Acesso negado devido a falta de pagamento.';
        
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }else{
            return $error['default'];
        }
        
        
    }
}
?>