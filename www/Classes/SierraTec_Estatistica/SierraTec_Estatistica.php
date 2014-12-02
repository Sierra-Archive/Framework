<?php
namespace Framework\Classes;

class SierraTec_Estatistica {
    
    
    /**
     * Atualiza todas as Estatisticas
     * @param type $tabelas
     */
    public function Gera_Estatistica(&$tabelas){
        // Para cada tabela
        foreach($tabelas as &$valor){
            $this->Gera_Estatistica_Tabela($tabela,$valor);
        }
    }
    /**
     * Funcao Recursiva que Gera Estaticas Localizadas
     * @param type $tabela
     * @param type $campos
     * #update
     */
    private function Gera_Estatistica_Tabela($tabela,$campos,$total, $nivel=0, $query_condicao=false){
        
        // Para cada Campo
        foreach($campos as &$valor){
            
            // Conta elementos de campo atual distinto
            $resultado = 'qurey';
            
            // Para Cada Resultado faz Estatica com o filho
            foreach($resultado as $registro){
                if($tipo=='int'){
                    $query = $coluna.'='.$resultado;
                }else if($tipo=='float'){
                    $query = $coluna.'='.$resultado;
                }else if($tipo=='date'){
                    $query = '('.$coluna.'='.$resultado.' AND '.$coluna.'='.$resultado.')';
                }else{
                    continue;
                }
                    
                if($query_condicao!==false){
                    $query = $query_condicao.' AND '.$query;
                }
                
                // Faz Estatisticas do Filho Recursivamente
                $this->Gera_Estatistica_Tabela(
                    $tabela,
                    array_diff($valor, $campos), //Campos Menos Atual
                    ++$nivel,
                    $query
                );
            }
            
            //Grava Estatistica do FIlho
            
        }
        
    }
}