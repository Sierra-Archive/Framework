<?php
class usuario_veiculo_aluguel_ListarControle extends usuario_veiculo_aluguel_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_veiculo_aluguel_ListarModelo Carrega usuario_veiculo_aluguel Modelo
    * @uses usuario_veiculo_aluguel_ListarVisual Carrega usuario_veiculo_aluguel Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct(){
        // construct
        parent::__construct();
    }
    /**
    * Função Main, Principal
    * 
    * @name Main
    * @access public
    * 
    * @uses usuario_veiculo_aluguel_ListarModelo::$retorna_aluguel
    * @uses \Framework\App\Visual::$Show_Tabela_DataTable
    * @uses \Framework\App\Visual::$Bloco_Maior_CriaTitulo
    * @uses \Framework\App\Visual::$bloco_maior_criaconteudo
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main(){
        $aluguel = Array();
        $this->_Modelo->retorna_aluguel($aluguel);
        if(!empty($aluguel)){
            reset($aluguel);
            $i = 0;
            foreach ($aluguel as $indice=>&$valor) {
                $tabela['Pedido'][$i] = '#'.$aluguel[$indice]['id'];
                $tabela['Veiculo'][$i] = $aluguel[$indice]['veiculo'];
                $tabela['Data Inicial'][$i] = date_replace($aluguel[$indice]['data_inicial'], "d/m/Y");
                $tabela['Data Final'][$i] = date_replace($aluguel[$indice]['data_final'], "d/m/Y");
                $tabela['Valor'][$i] = 'R$ '.number_format($aluguel[$indice]['valor'], 2, ',', '.');
                if($aluguel[$indice]['pago']==1){
                    $tabela['Status'][$i] = __('Confirmado');
                }else{
                    $tabela['Status'][$i] = '<font color="#FF0000">Pendente</font>';
                }
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            $this->_Visual->Bloco_Maior_CriaJanela('Todos os Alugueis ('.$i.')');
            unset($tabela);
        }else{        
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Infelizmente você nunca fez um aluguel com a gente.</font></b></center>');
            $this->_Visual->Bloco_Maior_CriaJanela('Todos os Alugueis (0)');
        }
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Aluguel'));
    }
}
?>