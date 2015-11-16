<?php
namespace Framework\Classes;

class SierraTec_Estatistica {
    
    
    /**
     * Atualiza todas as Estatisticas
     * @param type $tables
     */
    public function Gera_Estatistica(&$tables) {
        // Para cada tabela
        foreach($tables as &$valor) {
            $this->Gera_Estatistica_Tabela($table, $valor);
        }
    }
    /**
     * Funcao Recursiva que Gera Estaticas Localizadas
     * @param type $table
     * @param type $campos
     * #update
     */
    private function Gera_Estatistica_Tabela($table, $campos, $total, $nivel=0, $query_condicao = FALSE) {
        
        // Para cada Campo
        foreach($campos as &$valor) {
            
            // Conta elementos de campo atual distinto
            $resultado = 'qurey';
            
            // Para Cada Resultado faz Estatica com o filho
            foreach($resultado as $Registro) {
                if ($tipo=='int') {
                    $query = $coluna.'='.$resultado;
                } else if ($tipo=='float') {
                    $query = $coluna.'='.$resultado;
                } else if ($tipo=='date') {
                    $query = '('.$coluna.'='.$resultado.' AND '.$coluna.'='.$resultado.')';
                } else {
                    continue;
                }
                    
                if ($query_condicao !== FALSE) {
                    $query = $query_condicao.' AND '.$query;
                }
                
                // Faz Estatisticas do Filho Recursivamente
                $this->Gera_Estatistica_Tabela(
                    $table,
                    array_diff($valor, $campos), //Campos Menos Atual
                    ++$nivel,
                    $query
                );
            }
            
            //Grava Estatistica do FIlho
            
        }
        
    }
}