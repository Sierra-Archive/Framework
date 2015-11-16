<?php
class Enquete_Principal implements \Framework\PrincipalInterface
{
    /**
     * Função Home para o modulo mensagem aparecer na pagina HOME
     * 
     * @name Home
     * @access public
     * @static
     * 
     * @param Class &$controle Classe Controle Atual passada por Ponteiro
     * @param Class &$Modelo Modelo Passado por Ponteiro
     * @param Class &$Visual Visual Passado por Ponteiro
     *
     * @uses Enquete_Controle::$num_Indicados
     * 
     * @return void 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Home(&$controle, &$Modelo, &$Visual) {
        self::Widgets();
        Enquete_ShowControle::Show();
        return TRUE;
    }
    /**
     * 
     * @return boolean
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Config() {
        return FALSE;
    }
    
    static function Relatorio($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    
    static function Estatistica($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Widgets() {
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        // Enquetes
        $enquete_qnt = $Modelo->db->Sql_Contar('Enquete');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Enquetes', 
            'Enquete/Enquete/Enquetes', 
            'comments-alt', 
            $enquete_qnt, 
            'block-red', 
            FALSE, 
            260
        );
    }
    
    
    /***********************
     * BUSCAS
     */
    static function Busca(&$controle, &$Modelo, &$Visual, $busca) {
        $i = 0;
        // Busca Enquetes
        $result = self::Busca_Enquetes($controle, $Modelo, $Visual, $busca);
        if ($result !== FALSE) {
            $i = $i + $result;
        }
        // Busca Respostas
        $result = self::Busca_Respostas($controle, $Modelo, $Visual, $busca);
        if ($result !== FALSE) {
            $i = $i + $result;
        }
        // Retorna
        if (is_int($i) && $i>0) {
            return $i;
        } else {
            return FALSE;
        }
    }
    static function Busca_Enquetes($controle, $Modelo, $Visual, $busca) {
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%'
        ));
        $i = 0;
        $enquetes = $Modelo->db->Sql_Select('Enquete', $where);
        if ($enquetes === FALSE) return FALSE;
        // add botao
        $Visual->Blocar($Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Enquete',
                'Enquete/Enquete/Enquetes_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Enquete/Enquete/Enquetes',
            )
        )));
        if (is_object($enquetes)) $enquetes = Array(0=>$enquetes);
        if ($enquetes !== FALSE && !empty($enquetes)) {
            list($table, $i) = Enquete_EnqueteControle::Enquetes_Tabela($enquetes);
            $Visual->Show_Tabela_DataTable($table);
        } else {     
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Enquete na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Enquetes: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Respostas($controle, $Modelo, $Visual, $busca) {
        $where = Array(
          'nome'                    => '%'.$busca.'%'
        );
        $i = 0;
        $enquetes = $Modelo->db->Sql_Select('Enquete_Resposta', $where);
        if ($enquetes === FALSE) return FALSE;
        // add botao
        $Visual->Blocar($Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Resposta de Enquete',
                'Enquete/Resposta/Respostas_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Enquete/Resposta/Respostas',
            )
        )));
        if (is_object($enquetes)) $enquetes = Array(0=>$enquetes);
        if ($enquetes !== FALSE && !empty($enquetes)) {
            list($table, $i) = Enquete_RespostaControle::Respostas_Tabela($enquetes);
            $Visual->Show_Tabela_DataTable($table);
        } else {  
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Resposta de Enquete na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Respostas de Enquetes: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
}
