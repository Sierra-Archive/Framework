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
    * @version 0.4.24
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        Agenda_PastaControle::Pastas_Listar(false, $Modelo, $Visual,'Maior');
    }
    static function Config() {
        return false;
    }
    
    static function Relatorio($data_inicio, $data_final, $filtro = false) {
        return false;
    }
    
    static function Estatistica($data_inicio, $data_final, $filtro = false) {
        return false;
    }
    /***********************
     * BUSCAS
     */
    static function Busca(&$controle, &$Modelo, &$Visual, $busca) {
        $i = 0;
        // Busca Pastas
        $result = self::Busca_Pastas($controle, $Modelo, $Visual, $busca);
        if ($result !== false) {
            $i = $i + $result;
        }
        if (is_int($i) && $i>0) {
            return $i;
        } else {
            return false;
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
        if ($pastas === false) return false;
        // Botao Add
        $Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar nova Pasta ao Arquivo de Pastas',
                'Agenda/Pasta/Pastas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Agenda/Pasta/Pastas',
            )
        )));
        // Conexao
        if (is_object($pastas)) $pastas = Array(0=>$pastas);
        if ($pastas !== false && !empty($pastas)) {
            list($table, $i) = Agenda_PastaControle::Pastas_Tabela($pastas);
            $Visual->Show_Tabela_DataTable($table);
        } else { 
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Pasta no Arquivo de Pastas '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Pastas no Arquivo de Pastas: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
}

