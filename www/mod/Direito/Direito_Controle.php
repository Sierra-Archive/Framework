<?php
class Direito_Controle extends \Framework\App\Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    *
    * @uses View::$menu
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function __construct(){
        // construct
        parent::__construct();
    }
    /**
     * Listagem Generica para Todos os Processos
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Listar_Processos(&$processos, $titulo = '', $imprimir = 'false'){
        $i = 0;
        if(!empty($processos)){
            if($imprimir!='false'){
                // Cria Tabela Estatica
                $tabela = new \Framework\Classes\Tabela();
                $tabela->addcabecario(array('Data','Autor / Reu','Comarca / Vara','Fases','Dias em Atraso')); 
            }else{
                // Cria Tabela Dinamica
                $tabela = Array();
            }
            reset($processos);
            foreach ($processos as &$valor) {
                if($imprimir!='false'){
                    $tabela->addcorpo(array(
                        array("nome" => data_hora_eua_brasil($valor['DATA'])), //, "class" => 'tbold tleft'
                        array("nome" => $valor['AUTOR'].' / '.$valor['REU']),
                        array("nome" => $valor['COMARCA'].' / '.$valor['VARA']),
                        array("nome" => $valor['FASE']),
                        array("nome" => $valor['ATRASO'])
                    ));
                }else{
                    $tabela['Data'][$i] = data_hora_eua_brasil($valor['DATA']);
                    $tabela['Autor / Reu'][$i] = $valor['AUTOR'].' / '.$valor['REU'];
                    $tabela['Comarca / Vara'][$i] = $valor['COMARCA'].' / '.$valor['VARA'];
                    $tabela['Fases'][$i] = $valor['FASE'];
                    $tabela['Dias em Atraso'][$i] = $valor['ATRASO'];
                }
                ++$i;
            }
            if($imprimir!='false'){
                $this->_Visual->Blocar($tabela->retornatabela());
                $this->_Visual->Blocar('<br><center><a href="#" onClick="window.print();" ><img width="121" height="34" src="'.WEB_URL.'img/icons/imprimir.gif"></a></center>');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
                
            }
            unset($tabela);
        }else{         
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Processo</font></b></center>');
        }
        $titulo = 'Processos '.$titulo.'('.$i.')';
        if($imprimir=='false'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',50);
            $this->_Visual->Json_Info_Update('Titulo',$titulo); 
        }else{
            $this->_Visual->janelaajax('<style>body {background: #FFFFFF url(none) repeat 0 0;}</style>'.$titulo);
        }
    }
    /**
     * IMPRIME NUMEROS DO SISTEMA A DIREITA DA TELA
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Meus_Numeros(){
        // Chama NUmero de Processos, Reus e Autores e Manda pro VIEW imprimir
        $this->_Visual->Blocar(
                DireitoVisual::Show_TabMeusNumeros(
                    Array(
                        $this->_Modelo->Contar(MYSQL_ADVOGADO_PROCESSOS), // conta processos
                        $this->_Modelo->Contar(MYSQL_ADVOGADO_CONTRARIA), // conta reus
                        $this->_Modelo->Contar(MYSQL_ADVOGADO_AUTORES)    // conta autores
                    )
               )
        );
        // Cria Conteudo sem Titulo a Direita com os Numeros
        $this->_Visual->Bloco_Menor_CriaConteudo();
    }
}
?>