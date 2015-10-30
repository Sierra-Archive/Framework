<?php
class usuario_rede_ListarControle extends usuario_rede_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_rede_ListarModelo Carrega Usuario_rede Modelo
    * @uses usuario_rede_ListarVisual Carrega Usuario_rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
        // construct
        parent::__construct();
    }
    /**
    * Função Main, Principal
    * 
    * @name Main
    * @access public
    * 
    * @uses usuario_rede_ListarModelo::$Indicados_Retorna
    * @uses usuario_rede_ListarVisual::$Show_RedeIndicados
    * @uses \Framework\App\Visual::$blocar
    * @uses \Framework\App\Visual::$Bloco_Maior_CriaJanela
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        if($this->_Acl->Usuario_GetID()!==0) {
            // CARREGA ATIVIDADES
            $redes = $this->_Modelo->Indicados_Retorna($this->_Acl->Usuario_GetID());
            //$this->_Visual->Blocar($this->_Visual->Show_RedeIndicados($redes));  
            $this->_Visual->Blocar($this->_Visual->Show_RedeIndicadosNivel($redes));  
            $this->_Visual->Bloco_Maior_CriaJanela(__('Meus Primários'),'',60);  
            $this->_Visual->Blocar('<span id="secundarios"><center><b>Por favor, clique em um dos primários.</b></center></span>');  
            $this->_Visual->Bloco_Maior_CriaJanela(__('Secundários'),'',50);
            $this->_Visual->Blocar('<span id="terciarios"><center><b>Por favor, clique em um dos secundários.</b></center></span>');  
            $this->_Visual->Bloco_Maior_CriaJanela(__('Terciários'),'',40);
            unset($redes); // LIMPA MEMÓRIA

            // carrega tabela de indicados a direita
            usuario_rede_Controle::num_Indicados($this->_Modelo, $this->_Visual, $this->_Acl->Usuario_GetID());

            // ORGANIZA E MANDA CONTEUDO
            $this->_Visual->Json_Info_Update('Titulo', __('Rede'));
        }
    }
    public function Carrega_Indicados($id,$nivel) {
        $usuarioid = (int) $id;
        $nivel = \Framework\App\Conexao::anti_injection($nivel);
        
        if($nivel==2) $div = 'secundarios';
        else          $div = 'terciarios';
        
        $redes = $this->_Modelo->Indicados_Retorna($usuarioid,$nivel);
        $html = $this->_Visual->Show_RedeIndicadosNivel($redes,$nivel);  
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Rede')); 
        $conteudo = array(
          'location' => "#".$div,
          'js' => '',
          'html' =>  $html
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
    }
}
?>