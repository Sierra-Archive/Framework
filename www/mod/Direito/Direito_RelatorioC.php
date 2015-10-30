<?php
class Direito_RelatorioControle extends Direito_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Direito_rede_RelatorioModelo::Carrega Rede Modelo
    * @uses Direito_rede_RelatorioView::Carrega Rede View
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct(){
        parent::__construct();
    }
    /**
     * Main
     * 
     * FUNCAO PRINCIPAL, EXECUTA O PRIMEIRO PASSO 
     * 
     * @name Main
     * @access public
     * 
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Main(){
        // FORMULARIO PARA O PASSO 1
        $form = new \Framework\Classes\Form('Direito_Relatorio_Impressao','Direito/Relatorio/Impressao/','formajax','full');
        $form->Select_Novo('Tipo de Impressão','selecttipoimpressao','selecttipoimpressao');
        $form->Select_Opcao('Por Audiência',0,1);
        $form->Select_Opcao('Por Fase',1,0);
        $form->Select_Opcao('Por Comarca',2,0);
        $form->Select_Opcao('Por Vara',3,0);
        $form->Select_Opcao('Por Vara e Comarca',4,0);
        $form->Select_Opcao('Sem Alteração',5,0);
        $form->Select_Fim();
        // ORGANIZA E MANDA CONTEUDO
        $formulario = $form->retorna_form('Avançar');
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Maior_CriaJanela('Impressão de Relatórios - Passo 1');
        // Imprimi Numeros a Direita
        $this->Meus_Numeros();
        // Altera Titulo da Pagina
        $this->_Visual->Json_Info_Update('Titulo','Impressão de Relatórios - Passo 1'); 
    }
    /**
     * Executa segundo passo
     * @param type $tipo
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Impressao($tipo = -1,$id1=0,$id2=0){
        if ($tipo==-1) $tipo = \Framework\App\Conexao::anti_injection($_POST['selecttipoimpressao']);
        // POR AUDIENCIA
        if ($tipo==0){
            $form = new \Framework\Classes\Form('Direito_Relatorio_Relatorio_Audiencia','Direito/Relatorio/Relatorio_Audiencia/','formajax','full');
            // SELECT AUDIENCIA
            /*$resultado = Array();
            $total = $this->_Modelo->Listar(MYSQL_ADVOGADO_TIPOAUDIENCIAS,'titulo',$resultado);
            $form->Select_Novo('Audiência','selectadv_audiencias','selectadv_audiencias');
            for($i=0;$i<$total;++$i){
                if ($id1==0){
                    if ($i==0)                       $ativado = 1;
                    else                            $ativado = 0;
                } else {
                    if ($resultado[$i]['id']==$id1)  $ativado = 1;
                    else                            $ativado = 0;
                }
                $form->Select_Opcao($resultado[$i]['titulo'],$resultado[$i]['id'],$ativado);
            }
            $form->Select_Fim();*/
            // Chama funcao js
            if ($id1==0) $id1 = data_eua_brasil(APP_DATA);
            if ($id2==0) $id2 = date('d/m/Y', strtotime("+1 days"));
            $this->_Visual->Javascript_Executar('Sierra.Control_Layoult_Calendario_Intervalo_SemLimite(\'data_inicial\',\'data_final\',\''.$id1.'\',\''.$id2.'\');');
            $form->Input_Novo('Data Inicial','data_inicial',$id1,'text', 10,'obrigatorio', '', false,'','','Data','', false);
            $form->Input_Novo('Data Final',  'data_final',  $id2,'text', 10,'obrigatorio', '', false,'','','Data','', false);
        }
        // POR FASE
        else if ($tipo==1){
            $form = new \Framework\Classes\Form('Direito_Relatorio_Relatorio_Fase','Direito/Relatorio/Relatorio_Fase/','formajax','full');
            // SELECT FASE
            $resultado = Array();
            $total = $this->_Modelo->Listar(MYSQL_ADVOGADO_TIPOFASES,'titulo',$resultado);
            $form->Select_Novo('Fase','selectadv_fase','selectadv_fase');
            for($i=0;$i<$total;++$i){
                if ($id1==0){
                    if ($i==0)                       $ativado = 1;
                    else                            $ativado = 0;
                } else {
                    if ($resultado[$i]['id']==$id1)  $ativado = 1;
                    else                            $ativado = 0;
                }
                $form->Select_Opcao($resultado[$i]['titulo'],$resultado[$i]['id'],$ativado);
            }
            $form->Select_Fim();
        }
        // POR COMARCA
        else if ($tipo==2){
            $form = new \Framework\Classes\Form('Direito_Relatorio_Relatorio_Comarca','Direito/Relatorio/Relatorio_Comarca/','formajax','full');
            // SELECT COMARCA
            $resultado = Array();
            $total = $this->_Modelo->Listar(MYSQL_ADVOGADO_COMARCA,'titulo',$resultado);
            $form->Select_Novo('Comarca','selectadv_comarca','selectadv_comarca');
            for($i=0;$i<$total;++$i){
                if ($id1==0){
                    if ($i==0)                       $ativado = 1;
                    else                            $ativado = 0;
                } else {
                    if ($resultado[$i]['id']==$id1)  $ativado = 1;
                    else                            $ativado = 0;
                }
                $form->Select_Opcao($resultado[$i]['titulo'],$resultado[$i]['id'],$ativado);
            }
            $form->Select_Fim();
        }
        // POR VARA
        else if ($tipo==3){
            $form = new \Framework\Classes\Form('Direito_Relatorio_Relatorio_Vara','Direito/Relatorio/Relatorio_Vara/','formajax','full');
            // SELECT VARAS
            $resultado = Array();
            $total = $this->_Modelo->Listar(MYSQL_ADVOGADO_VARAS,'titulo',$resultado);
            $form->Select_Novo('Vara','selectadv_varas','selectadv_varas');
            for($i=0;$i<$total;++$i){
                if ($id1==0){
                    if ($i==0)                       $ativado = 1;
                    else                            $ativado = 0;
                } else {
                    if ($resultado[$i]['id']==$id1)  $ativado = 1;
                    else                            $ativado = 0;
                }
                $form->Select_Opcao($resultado[$i]['titulo'],$resultado[$i]['id'],$ativado);
            }
            $form->Select_Fim();
        }
        // POR VARA E COMARCA
        else if ($tipo==4){
            $form = new \Framework\Classes\Form('Direito_Relatorio_Relatorio_Vara_Comarca','Direito/Relatorio/Relatorio_Vara_Comarca/','formajax','full');
            // SELECT COMARCAS
            $resultado = Array();
            $total = $this->_Modelo->Listar(MYSQL_ADVOGADO_COMARCA,'titulo',$resultado);
            $form->Select_Novo('Comarca','selectadv_comarca','selectadv_comarca');
            for($i=0;$i<$total;++$i){
                if ($id2==0){
                    if ($i==0)                       $ativado = 1;
                    else                            $ativado = 0;
                } else {
                    if ($resultado[$i]['id']==$id2)  $ativado = 1;
                    else                            $ativado = 0;
                }
                $form->Select_Opcao($resultado[$i]['titulo'],$resultado[$i]['id'],$ativado);
            }
            $form->Select_Fim();
            // SELECT VARAS
            $resultado = Array();
            $total = $this->_Modelo->Listar(MYSQL_ADVOGADO_VARAS,'titulo',$resultado);
            $form->Select_Novo('Vara','selectadv_varas','selectadv_varas');
            for($i=0;$i<$total;++$i){
                if ($id1==0){
                    if ($i==0)                       $ativado = 1;
                    else                            $ativado = 0;
                } else {
                    if ($resultado[$i]['id']==$id1)  $ativado = 1;
                    else                            $ativado = 0;
                }
                $form->Select_Opcao($resultado[$i]['titulo'],$resultado[$i]['id'],$ativado);
            }
            $form->Select_Fim();
        }
        // SEM ALTERACAO
        if ($tipo==5){
            $this->Relatorio_SemAlt();
        } else {
            // Armazena formulario e add a um bloco de conteudo
            $formulario = $form->retorna_form('Avançar');
            $this->_Visual->Blocar($formulario);
            // Cria uma Janela a esquerda com o Conteudo do Bloco
            $this->_Visual->Bloco_Maior_CriaJanela('Impressão de Relatórios - Passo 2','',60);
            // Altera Titulo da Pagina
            $this->_Visual->Json_Info_Update('Titulo','Impressão de Relatórios - Passo 2');
        }
    }
    /**
     * Audiencia - 3 Passo
     * @param INT $id
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Audiencia($inicialdia = 0, $inicialmes = 0, $inicialano = 0, $finaldia = 0, $finalmes = 0, $finalano = 0, $imprimir = 'false'){
        // Caso nao tenha vindo por GET entao tenta pegar por POST
        if ($inicialdia==0){
            $inicial = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['data_inicial']));
        } else {
            $inicial = $inicialano.'-'.$inicialmes.'-'.$inicialdia;
        }
        if ($finaldia==0){
            $final = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['data_final']));
        } else {
            $final = $finalano.'-'.$finalmes.'-'.$finaldia;
        }
        if (!isset($inicial) || $inicial==0 || $inicial=='' || $inicial=='//') $inicial = 0;
        if (!isset($final)   || $final  ==0 || $final  =='' || $final  =='//') $final = 0;
        // Busca Audiencias e Preenche a variavel $processos
        $processos = Array();
        $i = $this->_Modelo->Relatorio_Audiencia($processos,$inicial,$final);
        if ($imprimir=='false'){
            $this->Impressao(0,data_eua_brasil($inicial),data_eua_brasil($final));
            if ($i!=0 && $inicial!=0 && $final!=0){
                $this->_Visual->Blocar('<a href="#" onclick="window.open(\''.URL_PATH.SISTEMA_MODULO.'/'.SISTEMA_SUB.'/'.SISTEMA_MET.'/'.data_eua_brasil($inicial).'/'.data_eua_brasil($final).'/imprimir/\',\'Janela\',\'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=800,height=550\'); return false;"><img src="'.WEB_URL.'img/icons/imprimir.gif" width="121" height="34"></a>');
                $this->_Visual->Bloco_Maior_CriaJanela(__('Imprimir Dados Acima?'),'',40);
            }
        }
        // Lista Processos
        // Chama a Impressao Generica dos Processos
        $this->Listar_Processos($processos, 'Referentes a Audiencia ', $imprimir);
        // Altera Titulo da Pagina
        if ($imprimir=='false') $this->_Visual->Json_Info_Update('Titulo','Impressão de Relatórios - Passo Final');
    }
    /**
     * Fase - 3 Passo
     * @param INT $id
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Fase($id = 0, $imprimir = 'false'){
        if ($id==0){
            $id = \Framework\App\Conexao::anti_injection($_POST['selectadv_fase']);
        }
        if (!isset($id) || $id==0 || $id=='') $id = 0;
        $processos = Array();
        $i = $this->_Modelo->Relatorio_Fase($processos,$id);
        if ($imprimir=='false'){
            $this->Impressao(1,$id);
            if ($i!=0 && $id!=0){
                $this->_Visual->Blocar('<a href="#" onclick="window.open(\''.URL_PATH.SISTEMA_MODULO.'/'.SISTEMA_SUB.'/'.SISTEMA_MET.'/'.$id.'/imprimir/\',\'Janela\',\'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=800,height=550\'); return false;"><img src="'.WEB_URL.'img/icons/imprimir.gif" width="121" height="34"></a>');
                $this->_Visual->Bloco_Maior_CriaJanela(__('Imprimir Dados Acima?'),'',40);
            }
        }
        // Lista Processos
        $this->Listar_Processos($processos, 'Referentes a Fase ', $imprimir);
        // Altera Titulo da Pagina
        if ($imprimir=='false') $this->_Visual->Json_Info_Update('Titulo','Impressão de Relatórios - Passo Final');
    }
    /**
     * Comarca - 3 Passo
     * @param INT $id
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Comarca($id = 0, $imprimir = 'false'){
        if ($id==0){
            $id = \Framework\App\Conexao::anti_injection($_POST['selectadv_comarca']);
        }
        if (!isset($id) || $id==0 || $id=='') $id = 0;
        $processos = Array();
        $i = $this->_Modelo->Relatorio_Comarca($processos,$id);
        if ($imprimir=='false'){
            $this->Impressao(2,$id);
            if ($i!=0 && $id!=0){
                $this->_Visual->Blocar('<a href="#" onclick="window.open(\''.URL_PATH.SISTEMA_MODULO.'/'.SISTEMA_SUB.'/'.SISTEMA_MET.'/'.$id.'/imprimir/\',\'Janela\',\'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=800,height=550\'); return false;"><img src="'.WEB_URL.'img/icons/imprimir.gif" width="121" height="34"></a>');
                $this->_Visual->Bloco_Maior_CriaJanela(__('Imprimir Dados Acima?'),'',40);
            }
        }
        // Lista Processos
        $this->Listar_Processos($processos, 'Referentes a Comarca ', $imprimir);
        // Altera Titulo da Pagina
        if ($imprimir=='false') $this->_Visual->Json_Info_Update('Titulo','Impressão de Relatórios - Passo Final');
    }
    /**
     * Vara - 3 Passo
     * @param INT $id
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Vara($id = 0, $imprimir = 'false'){
        if ($id==0){
            $id = \Framework\App\Conexao::anti_injection($_POST['selectadv_varas']);
        }
        if (!isset($id) || $id==0 || $id=='') $id = 0;
        $processos = Array();
        $i = $this->_Modelo->Relatorio_Vara($processos,$id);
        if ($imprimir=='false'){
            $this->Impressao(3,$id);
            if ($i!=0 && $id!=0){            
                $this->_Visual->Blocar('<a href="#" onclick="window.open(\''.URL_PATH.SISTEMA_MODULO.'/'.SISTEMA_SUB.'/'.SISTEMA_MET.'/'.$id.'/imprimir/\',\'Janela\',\'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=800,height=550\'); return false;"><img src="'.WEB_URL.'img/icons/imprimir.gif" width="121" height="34"></a>');
                $this->_Visual->Bloco_Maior_CriaJanela(__('Imprimir Dados Acima?'),'',40);
            }
        }
        // Lista Processos
        $this->Listar_Processos($processos, 'Referentes a Vara ', $imprimir);
        // Altera Titulo da Pagina
        if ($imprimir=='false') $this->_Visual->Json_Info_Update('Titulo','Impressão de Relatórios - Passo Final');
    }
    /**
     * Vara e Comarca - 3 Passo
     * @param INT $id
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Vara_Comarca($idvara = 0,$idcomarca = 0, $imprimir = 'false'){
        if ($idvara==0){
            $idvara = \Framework\App\Conexao::anti_injection($_POST['selectadv_varas']);
        }
        if ($idcomarca==0){
            $idcomarca = \Framework\App\Conexao::anti_injection($_POST['selectadv_comarca']);
        }
        if (!isset($idvara)    || $idvara   ==0 || $idvara   =='') $idvara    = 0;
        if (!isset($idcomarca) || $idcomarca==0 || $idcomarca=='') $idcomarca = 0;
        $processos = Array();
        $i = $this->_Modelo->Relatorio_Vara_Comarca($processos,$idvara,$idcomarca);
        if ($imprimir=='false'){
            $this->Impressao(4,$idvara,$idcomarca);
            if ($i!=0 && $idvara!=0 && $idcomarca!=0){
                $this->_Visual->Blocar('<a href="#" onclick="window.open(\''.URL_PATH.SISTEMA_MODULO.'/'.SISTEMA_SUB.'/'.SISTEMA_MET.'/'.$idvara.'/'.$idcomarca.'/imprimir/\',\'Janela\',\'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=800,height=550\'); return false;"><img src="'.WEB_URL.'img/icons/imprimir.gif" width="121" height="34"></a>');
                $this->_Visual->Bloco_Maior_CriaJanela(__('Imprimir Dados Acima?'),'',40);
            }
        }
        // Lista Processos
        $this->Listar_Processos($processos, 'Referentes a Vara e Comarca ', $imprimir);
        // Altera Titulo da Pagina
        if ($imprimir=='false') $this->_Visual->Json_Info_Update('Titulo','Impressão de Relatórios - Passo Final');
    }
    /**
     * Sem Alteração - 3 Passo
     * @param INT $id
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_SemAlt($imprimir = 'false'){
        $processos = Array();
        $i = $this->_Modelo->Relatorio_SemAlt($processos);
        if ($imprimir=='false'){
            if ($i!=0){
                $this->_Visual->Blocar('<a href="#" onclick="window.open(\''.URL_PATH.SISTEMA_MODULO.'/'.SISTEMA_SUB.'/Relatorio_SemAlt/imprimir/\',\'Janela\',\'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=800,height=550\'); return false;"><img src="'.WEB_URL.'img/icons/imprimir.gif" width="121" height="34"></a>');
                $this->_Visual->Bloco_Maior_CriaJanela(__('Imprimir Dados Acima?'),'',40);
            }
            // Imprimi Numeros a Direita
            $this->Meus_Numeros();
        }
        // Lista Processos
        $this->Listar_Processos($processos, 'Sem Alterações ', $imprimir);
        // Altera Titulo da Pagina
        if ($imprimir=='false') $this->_Visual->Json_Info_Update('Titulo','Impressão de Relatórios - Passo Final');
    }
}
?>