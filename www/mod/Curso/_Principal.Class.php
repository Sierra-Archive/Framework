<?php
class Curso_Principal implements PrincipalInterface
{
    /**
     * Função Home para o modulo mensagem aparecer na pagina HOME
     * 
     * @name Home
     * @access public
     * @static
     * 
     * @param Class &$controle Classe Controle Atual passada por Ponteiro
     * @param Class &$modelo Modelo Passado por Ponteiro
     * @param Class &$Visual Visual Passado por Ponteiro
     *
     * @uses Curso_Controle::$num_Indicados
     * 
     * @return void 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    static function Home(&$controle, &$modelo, &$Visual){
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
     * @version 2.0
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
    
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        $i = 0;
        // Busca Cursos
        $result = self::Busca_Cursos($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Turmas
        $result = self::Busca_Turmas($controle, $modelo, $Visual, $busca);
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
    static function Busca_Cursos($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
        ));
        $i = 0;
        $cursos = $modelo->db->Sql_Select('Curso',$where);
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
    static function Busca_Turmas($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
        ));
        $i = 0;
        $albuns = $modelo->db->Sql_Select('Curso_Turma',$where);
        if($albuns===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Turma" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Curso/Turma/Turmas_Add">Adicionar novo Turma</a><div class="space15"></div>');
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
     * @version 2.0
     */
    public static function Widgets(){
        $Registro = &\Framework\App\Registro::getInstacia();
        $modelo = $Registro->_Modelo;
        $Visual = $Registro->_Visual;
        // Cursos
        $where = Array();
        $curso = $modelo->db->Sql_Select('Curso',$where);
        if(is_object($curso)) $curso = Array(0=>$curso);
        if($curso!==false && !empty($curso)){
            reset($curso);
            $curso_qnt = count($curso);
        }else{
            $curso_qnt = 0;
        }
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
        $where = Array();
        $album = $modelo->db->Sql_Select('Curso_Turma',$where);
        if(is_object($album)) $album = Array(0=>$album);
        if($album!==false && !empty($album)){
            reset($album);
            $album_qnt = count($album);
        }else{
            $album_qnt = 0;
        }
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Turmas', 
            'Curso/Turma/Turmas', 
            'hdd', 
            $album_qnt, 
            'block-yellow', 
            false, 
            16
        );
    }
    
}
?>