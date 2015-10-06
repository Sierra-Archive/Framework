<?php
class Locomocao_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo financeiro aparecer na pagina HOME
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$Modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses \Framework\App\Controle::$usuario
    * @uses Locomocao_Controle::$num_Indicados
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$Modelo, &$Visual){
        //$dados = Locomocao_Controle::Retorna_Distancia('Av. Paulista, 925 - Paraiso Brazil, São Paulo, Brasil','Av. Brg. Luís Antônio, 400 - República, São Paulo, Brasil');
        
        $html = 'Conteudo';
        
        // Bloca Conteudo
        $Visual->Blocar($html);   
        $Visual->Bloco_Menor_CriaJanela(__('Em Andamento'),'',80);
        // Bloca Conteudo
        $Visual->Blocar($html);   
        $Visual->Bloco_Menor_CriaJanela(__('Disponiveis na Rua'),'',80);
    }
    static function Busca(&$controle, &$Modelo, &$Visual,$busca){
        return false;
    }
    static function Config(){
        return false;
    }
    
    static function Relatorio($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    static function Estatistica($data_inicio,$data_final,$filtro=false){
        return false;
    }
}
?>