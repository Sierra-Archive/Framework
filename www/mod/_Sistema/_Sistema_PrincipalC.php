<?php
class _Sistema_PrincipalControle extends _Sistema_Controle
{
    public function __construct(){
        
        parent::__construct();
    }
    /**
     * Home
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
     */
    public function Home(){
        $this->layoult_endereco_alterado = true;
        $this->layoult_endereco = Array(
            Array('Página Inicial',false)
        );
        // Carrega Conteudo dos Modulos
        foreach($this->ModulosHome as $value){
            if($value!='_Sistema'){
                eval($value.'_Principal::Home($this, $this->_Modelo, $this->_Visual);');
            }
        }
        /*if($this->_Acl->logado_usuario->grupo==CFG_TEC_IDADMINDEUS){
            _Sistema_AdminControle::AdminWidgets();
        }*/
        \Framework\App\Visual::Layoult_Home_Widgets_Show();
        //Carrega Json
       $this->_Visual->Json_Info_Update('Titulo','Página Principal');
    }
    /**
     * Busca
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
     */
    public function Busca($busca=false){
        if($busca===false){
            if(isset($_POST['busca'])){
                $busca = \anti_injection($_POST['busca']);
            }else
            if(isset($_GET['busca'])){
                $busca = \anti_injection($_GET['busca']);
            }
        }
        // Carrega Buscador dos Modulos
        $i = 0;
        foreach($this->ModulosHome as $value){
            if($value!='_Sistema'){
                eval('$retorno = '.$value.'_Principal::Busca($this, $this->_Modelo, $this->_Visual, $busca);');
                if($retorno!==false){
                    $i = $i + $retorno;
                }
            }
        }
        if($i==0){        
            $this->_Visual->Blocar('<center><p class="text-error"><b>Nenhum resultado na Busca por: \''.$busca.'\'</b></p></center>');
            $titulo = 'Busca Geral: '.$busca.' ('.$i.')';
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }
        //Carrega Json
       $this->_Visual->Json_Info_Update('Titulo','Busca');
    }
    public function Relatorio($busca=false){
        if($busca==false){
            $busca = \anti_injection($_POST['busca']);
        }
        // Carrega Buscador dos Modulos
        $i = 0;
        foreach($this->ModulosHome as $value){
            if($value!='_Sistema'){
                eval('$retorno = '.$value.'_Principal::Busca($this, $this->_Modelo, $this->_Visual, $busca);');
                if($retorno!==false){
                    $i = $i + $retorno;
                }
            }
        }
        if($i==0){
            $html .= '<center><p class="text-error"><b>Nenhum resultado na Busca por: \''.$busca.'\'</b></p></center>';            
            $this->_Visual->Blocar($html);
            $titulo = 'Busca Geral: '.$busca.' ('.$i.')';
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }
        //Carrega Json
       $this->_Visual->Json_Info_Update('Titulo','Busca');
    }
    public function Estatistica($busca=false){
        if($busca==false){
            $busca = \anti_injection($_POST['busca']);
        }
        // Carrega Buscador dos Modulos
        $i = 0;
        foreach($this->ModulosHome as $value){
            if($value!='_Sistema'){
                eval('$retorno = '.$value.'_Principal::Busca($this, $this->_Modelo, $this->_Visual, $busca);');
                if($retorno!==false){
                    $i = $i + $retorno;
                }
            }
        }
        if($i==0){
            $html .= '<center><p class="text-error"><b>Nenhum resultado na Busca por: \''.$busca.'\'</b></p></center>';            
            $this->_Visual->Blocar($html);
            $titulo = 'Busca Geral: '.$busca.' ('.$i.')';
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }
        //Carrega Json
       $this->_Visual->Json_Info_Update('Titulo','Busca');
    }
}
?>
