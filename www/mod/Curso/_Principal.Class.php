<?php
class Curso_Principal implements \Framework\PrincipalInterface
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
     * @uses Curso_Controle::$num_Indicados
     * 
     * @return void 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Home(&$controle, &$Modelo, &$Visual){
        self::Widgets();
        return true;
    }
    static function Widget(&$_Controle){
        return true;
    }     
    /**
     * 
     * @return boolean
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Config(){
        return false;
    }
    
    static function Relatorio($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    static function Estatistica($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    static function Busca(&$controle, &$Modelo, &$Visual,$busca){
        $i = 0;
        // Busca Cursos
        $result = self::Busca_Cursos($controle, $Modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Turmas
        $result = self::Busca_Turmas($controle, $Modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        
        // Retorna
        if(is_int($i) && $i>0){
            return $i;
        }else{
            return false;
        }
    }
    
    /***********************
     * BUSCAS
     */
    static function Busca_Cursos($controle, $Modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
        ));
        $i = 0;
        $cursos = $Modelo->db->Sql_Select('Curso',$where);
        if($cursos===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Curso" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Curso/Curso/Cursos_Add">Adicionar novo Curso</a><div class="space15"></div>');
        if(is_object($cursos)) $cursos = Array(0=>$cursos);
        if($cursos!==false && !empty($cursos)){
            list($tabela,$i) = Curso_CursoControle::Cursos_Tabela($cursos);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{         
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Curso na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Cursos: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Turmas($controle, $Modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
        ));
        $i = 0;
        $albuns = $Modelo->db->Sql_Select('Curso_Turma',$where);
        if($albuns===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Turma" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Curso/Turma/Turmas_Add">Adicionar nova Turma</a><div class="space15"></div>');
        if(is_object($albuns)) $albuns = Array(0=>$albuns);
        if($albuns!==false && !empty($albuns)){
            list($tabela,$i) = Curso_TurmaControle::Turmas_Tabela($albuns);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{        
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Turma de Curso na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Turmas de Cursos: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Widgets(){
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        // Cursos
        $curso_qnt = $Modelo->db->Sql_Contar('Curso');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Cursos', 
            'Curso/Curso/Cursos', 
            'group', 
            $curso_qnt, 
            'block-orange', 
            false, 
            14
        );
        // Turmas
        $turma_qnt = $Modelo->db->Sql_Contar('Curso_Turma');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Turmas', 
            'Curso/Turma/Turmas', 
            'hdd', 
            $turma_qnt, 
            'block-yellow', 
            false, 
            16
        );
    }
    
}
?>