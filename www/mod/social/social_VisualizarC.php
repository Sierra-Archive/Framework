<?php
/**
 * #update antigo
 */
class social_VisualizarControle extends social_Controle
{

    public function __construct() {
        parent::__construct();
    }
    // PAGINA DE UMA PERSONA S�
    public function Main($id) {
        $personaid = (int) $id;
        $tipos = array();
        $tipo = array();
        $tipon = array();
        $persona = $this->_Modelo->retorna_persona($personaid);
        if (!empty($persona)) {
            $this->_Visual->exibe_persona($persona);
            $this->_Visual->Bloco_Maior_CriaJanela($persona['nome'] .' - Informaçees');
        }
        $this->_Modelo->retorna_acoes($personaid, $acoes);
        $i = 0;
        if (!empty($acoes)) {
            usort($acoes, "ordenar");
            reset($acoes);
            foreach ($acoes as $indice=>&$valor) {
                $table[__('Data')][$i] = $acoes[$indice]['data'];
                $table[__('Tipo')][$i] = $acoes[$indice]['tiponome'];
                $table['Observa��o'][$i] = $acoes[$indice]['obs'];

                // se variavel nao existe ele cria
                if (!isset($tipo[$acoes[$indice]['tipo']])) $tipo[$acoes[$indice]['tipo']] = 0;
                if (!isset($tipos[$acoes[$indice]['tipo']])) $tipos[$acoes[$indice]['tipo']] = 0;

                // verifica os tipso e add
                if ($acoes[$indice]['positivo']==1) {
                    $tipos[$acoes[$indice]['tipo']] = $tipos[$acoes[$indice]['tipo']] + $acoes[$indice]['gravidade'];
                    $table[__('Pontos')][$i] = '+ '.$acoes[$indice]['gravidade'];
                } else {
                    $tipos[$acoes[$indice]['tipo']] = $tipos[$acoes[$indice]['tipo']] - $acoes[$indice]['gravidade'];
                    $table[__('Pontos')][$i] = '- '.$acoes[$indice]['gravidade'];
                }
                $tipon[$acoes[$indice]['tipo']] = $acoes[$indice]['tiponome'];
                ++$tipo[$acoes[$indice]['tipo']];
                ++$i;
            }
        }
        $this->_Visual->exibetipos($tipo, $tipos, $tipon);
        $this->_Visual->Show_Tabela_DataTable($table);
        $this->_Visual->Bloco_Maior_CriaJanela($persona['nome'] .' - Ações');
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Start('Usuario_social - '.$persona['nome']);
    }
}
?>