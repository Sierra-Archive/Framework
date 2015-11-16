<?php
class Agenda_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$Modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses agenda_compromissoControle::$compromisso_formcadastro
    * @uses agenda_compromissoControle::$proximoscompromissos
    * @uses agenda_compromissoControle::$anteriorescompromissos
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        Agenda_PastaControle::Pastas_Listar(FALSE, $Modelo, $Visual,'Maior');
    }
    static function Config() {
        return FALSE;
    }
    
    static function Relatorio($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    
    static function Estatistica($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    /***********************
     * BUSCAS
     */
    static function Busca(&$controle, &$Modelo, &$Visual, $busca) {
        $i = 0;
        // Busca Pastas
        $result = self::Busca_Pastas($controle, $Modelo, $Visual, $busca);
        if ($result !== FALSE) {
            $i = $i + $result;
        }
        if (is_int($i) && $i>0) {
            return $i;
        } else {
            return FALSE;
        }
    }
    static function Busca_Pastas($controle, $Modelo, $Visual, $busca) {
        $where = Array(Array(
          'num'                     => '%'.$busca.'%',
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%'
        ));
        $i = 0;
        $pastas = $Modelo->db->Sql_Select('Usuario_Agenda_Pasta', $where);
        if ($pastas === FALSE) return FALSE;
        // Botao Add
        $Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar nova Pasta ao Arquivo de Pastas',
                'Agenda/Pasta/Pastas_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Agenda/Pasta/Pastas',
            )
        )));
        // Conexao
        if (is_object($pastas)) $pastas = Array(0=>$pastas);
        if ($pastas !== FALSE && !empty($pastas)) {
            list($tabela, $i) = Agenda_PastaControle::Pastas_Tabela($pastas);
            $Visual->Show_Tabela_DataTable($tabela);
        } else { 
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Pasta no Arquivo de Pastas '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Pastas no Arquivo de Pastas: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
}
?>
