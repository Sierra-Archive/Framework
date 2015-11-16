<?php
class usuario_rede_Controle extends \Framework\App\Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    *
    * @uses \Framework\App\Visual::$menu
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
        // construct
        parent::__construct();
    } 
    /**
    * Carrega Numero de Indicados
    * 
    * @name num_Indicados
    * @access public
    * @static
    * 
    * @param Class $Modelo Carrega Class Modelo
    * @param Class $Visual Carrega Class Visual
    * @param int $usuario id do usuario
    *
    * @uses usuario_rede_Modelo::$Retorna_num_Indicados
    * @uses usuario_rede_Visual::$Show_TabRedeIndicados
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function num_Indicados(&$Modelo, &$Visual, $usuario) {
        $valores = usuario_rede_Modelo::Retorna_num_Indicados($Modelo, $usuario);
        $Visual->Blocar(usuario_rede_Visual::Show_TabRedeIndicados($valores));   
        $Visual->Bloco_Menor_CriaConteudo(20);
        
        // Cria Grafico De Primarios SEcundarios terciarios
        $graficos[0]['titulo'] = __('Medidor de Indicados');
        $graficos[0]['alt'] = 400;
        $graficos[0]['larg'] = 500;
        $graficos[0]['headers'] = array('Nome', 'Valor');
        $graficos[0]['itens'][] = array('Primarios',$valores['primario']);
        $graficos[0]['itens'][] = array('Secundarios',$valores['secundario']);
        $graficos[0]['itens'][] = array('Terciarios',$valores['terciario']);
        
        // Cria Grafico niveis
        $graficos[1]['titulo'] = __('Medidor de planos');
        $graficos[1]['alt'] = 400;
        $graficos[1]['larg'] = 400;
        $graficos[1]['headers'] = array('Nome', 'Valor');
        foreach($valores['associado'] as $indice=>&$valor) {
            $grupo = \Framework\App\Registro::getInstacia()->_Conexao->Sql_Select('Sistema_Grupo', '{sigla}id=\''.$indice.'\'');
            $graficos[1]['itens'][] = array($grupo->nome,$valor);
        }
        unset($valores); // LIMPA MEM�RIA
        // Cria conteudo html no layoult e add numa noja janela
        $Visual->Blocar($Visual->grafico_gerar($graficos));
        $Visual->Bloco_Unico_CriaJanela(__('Gráficos'));
    }
    static function Ranking_listar(&$Modelo, &$Visual) {
        $ranking = Array();
        usuario_rede_Modelo::Ranking_primarios($ranking,$Modelo);
        if (!empty($ranking)) {
            reset($ranking);
            $i = 0;
            foreach ($ranking as $indice=>&$valor) {
                $tabela['Associado'][$i] = ($i+1).'º '.$ranking[$indice]['nome'];
                $tabela['Primarios'][$i] = str_pad($ranking[$indice]['PRIMARIO'], 5, "0", STR_PAD_LEFT).' %';
                ++$i;
            }
            $Visual->Show_Tabela_DataTable($tabela);
            $Visual->Bloco_Maior_CriaJanela(__('Ranking'),'',10);
            unset($tabela);
        }
    }
}
?>