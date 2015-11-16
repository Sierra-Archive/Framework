<?php
class _Sistema_PrincipalControle extends _Sistema_Controle
{
    public function __construct() {
        
        parent::__construct();
    }
    public function Main() {
        return $this->Home();
    }
    /**
     * Home
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Home() {
        $tempo = new \Framework\App\Tempo('HOME');   
        $this->layoult_endereco_alterado = TRUE;
        $this->layoult_endereco = Array(
            Array(__('Página Inicial'), FALSE)
        );
        // Carrega Conteudo dos Modulos
        foreach($this->ModulosHome as $value) {
            if ($value!='_Sistema') {
                eval($value.'_Principal::Home($this, $this->_Modelo, $this->_Visual);');
            }
        }
        /*if ($this->_Acl->logado_usuario->grupo==CFG_TEC_IDADMINDEUS) {
            _Sistema_AdminControle::AdminWidgets();
        }*/
        \Framework\App\Visual::Layoult_Home_Widgets_Show();
        //Carrega Json
       $this->_Visual->Json_Info_Update('Titulo', __('Página Principal'));
    }
    /**
     * Busca
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Busca($busca = FALSE) {
        if ($busca === FALSE) {
            if (isset($_POST['busca'])) {
                $busca = \Framework\App\Conexao::anti_injection($_POST['busca']);
            } else
            if (isset($_GET['busca'])) {
                $busca = \Framework\App\Conexao::anti_injection($_GET['busca']);
            }
        }
        // Carrega Buscador dos Modulos
        $i = 0;
        foreach($this->ModulosHome as $value) {
            if ($value!='_Sistema') {
                eval('$retorno = '.$value.'_Principal::Busca($this, $this->_Modelo, $this->_Visual, $busca);');
                if ($retorno !== FALSE) {
                    $i = $i + $retorno;
                }
            }
        }
        if ($i==0) {        
            $this->_Visual->Blocar('<center><p class="text-error"><b>Nenhum resultado na Busca por: \''.$busca.'\'</b></p></center>');
            $titulo = 'Busca Geral: '.$busca.' ('.$i.')';
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }
        //Carrega Json
       $this->_Visual->Json_Info_Update('Titulo', __('Busca'));
    }
    public function Relatorio($busca = FALSE) {
        $html = '';
        $i = 0;
        if ($busca == FALSE) {
            $busca = \Framework\App\Conexao::anti_injection($_POST['busca']);
        }
        // Carrega Buscador dos Modulos
        foreach($this->ModulosHome as $value) {
            if ($value!='_Sistema') {
                eval('$retorno = '.$value.'_Principal::Busca($this, $this->_Modelo, $this->_Visual, $busca);');
                if ($retorno !== FALSE) {
                    $i = $i + $retorno;
                }
            }
        }
        if ($i==0) {
            $html .= '<center><p class="text-error"><b>Nenhum resultado na Busca por: \''.$busca.'\'</b></p></center>';            
            $this->_Visual->Blocar($html);
            $titulo = 'Busca Geral: '.$busca.' ('.$i.')';
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }
        //Carrega Json
       $this->_Visual->Json_Info_Update('Titulo', __('Busca'));
    }
    public function Estatistica($busca = FALSE) {
        $html = '';
        $i = 0;
        if ($busca == FALSE) {
            $busca = \Framework\App\Conexao::anti_injection($_POST['busca']);
        }
        // Carrega Buscador dos Modulos
        foreach($this->ModulosHome as $value) {
            if ($value!='_Sistema') {
                eval('$retorno = '.$value.'_Principal::Busca($this, $this->_Modelo, $this->_Visual, $busca);');
                if ($retorno !== FALSE) {
                    $i = $i + $retorno;
                }
            }
        }
        if ($i==0) {
            $html .= '<center><p class="text-error"><b>Nenhum resultado na Busca por: \''.$busca.'\'</b></p></center>';            
            $this->_Visual->Blocar($html);
            $titulo = 'Busca Geral: '.$busca.' ('.$i.')';
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }
        //Carrega Json
       $this->_Visual->Json_Info_Update('Titulo', __('Busca'));
    }
    public function Release($versao = FALSE, $melhoria='', $melhoria_qnt = 0, $bugs='', $bugs_qnt = 0) {
        if ($versao<0.4) {
            $melhoria .= "\n".'- Possibilidade de Instalação no IOS: Possibilidade'; ++$melhoria_qnt;
            $bugs .= "\n".'- Responsividade: Melhoria'; ++$bugs_qnt;
            $bugs .= "\n".'- Outros: Outros Bugs Consertados'; ++$bugs_qnt;
        }
    }
}
?>
