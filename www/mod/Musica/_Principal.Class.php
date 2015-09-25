<?php
class Musica_Principal implements \Framework\PrincipalInterface
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
     * @uses Musica_Controle::$num_Indicados
     * 
     * @return void 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Home(&$controle, &$modelo, &$Visual){
        self::Widgets();
        return true;
    }
    static function Widget(&$_Controle){
        $_Controle->Widget_Add('Superior',
        '<li class="dropdown mtop5">'.
            '<a class="dropdown-toggle element lajax" acao="" data-placement="bottom" data-toggle="tooltip" href="'.URL_PATH.'Musica/Musica/Musicas_Add" data-original-title="Nova Musica">'.
                '<i class="fa fa-music"></i>'.
            '</a>'.
        '</li>');
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
    
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        $i = 0;
        // Busca Musicas
        $result = self::Busca_Artistas($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Albuns
        $result = self::Busca_Albuns($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Musicas
        $result = self::Busca_Musicas($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Videos
        $result = self::Busca_Videos($controle, $modelo, $Visual, $busca);
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
    static function Busca_Artistas($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
        ));
        $i = 0;
        $artistas = $Modelo->db->Sql_Select('Musica_Album_Artista',$where);
        if($artistas===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Artista" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Musica/Artista/Artistas_Add">Adicionar novo Artista</a><div class="space15"></div>');
        if(is_object($artistas)) $artistas = Array(0=>$artistas);
        if($artistas!==false && !empty($artistas)){
            list($tabela,$i) = Musica_ArtistaControle::Artistas_Tabela($artistas);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{         
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Artista na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Artistas: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Albuns($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
        ));
        $i = 0;
        $albuns = $Modelo->db->Sql_Select('Musica_Album',$where);
        if($albuns===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Album" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Musica/Album/Albuns_Add">Adicionar novo Album</a><div class="space15"></div>');
        if(is_object($albuns)) $albuns = Array(0=>$albuns);
        if($albuns!==false && !empty($albuns)){
            list($tabela,$i) = Musica_AlbumControle::Albuns_Tabela($albuns);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{        
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Album de Artista na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Albuns de Artistas: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Musicas($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
        ));
        $i = 0;
        $albuns = $Modelo->db->Sql_Select('Musica',$where);
        if($albuns===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Musica" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Musica/Musica/Musicas_Add">Adicionar nova Musica</a><div class="space15"></div>');
        if(is_object($albuns)) $albuns = Array(0=>$albuns);
        if($albuns!==false && !empty($albuns)){
            list($tabela,$i) = Musica_AlbumControle::Albuns_Tabela($albuns);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{      
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Musica de Artista na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Musicas de Artistas: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Videos($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'obs'                     => '%'.$busca.'%',
        ));
        $i = 0;
        $albuns = $Modelo->db->Sql_Select('Musica_Video',$where);
        if($albuns===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Video" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'Musica/Video/Videos_Add">Adicionar novo Video</a><div class="space15"></div>');
        if(is_object($albuns)) $albuns = Array(0=>$albuns);
        if($albuns!==false && !empty($albuns)){
            list($tabela,$i) = Musica_AlbumControle::Albuns_Tabela($albuns);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{           
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Video de Artista na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Videos de Artistas: '.$busca.' ('.$i.')';
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
        // Artistas
        $artista_qnt = $Modelo->db->Sql_Contar('Musica_Album_Artista');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Artistas', 
            'Musica/Artista/Artistas', 
            'group', 
            $artista_qnt, 
            'block-orange', 
            false, 
            14
        );
        // Albuns
        $album_qnt = $Modelo->db->Sql_Contar('Musica_Album');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Albuns', 
            'Musica/Album/Albuns', 
            'hdd', 
            $album_qnt, 
            'block-yellow', 
            false, 
            16
        );
        // Musicas
        $musica_qnt = $Modelo->db->Sql_Contar('Musica');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Musicas', 
            'Musica/Musica/Musicas', 
            'music', 
            $musica_qnt, 
            'block-grey', 
            false, 
            18
        );
        // Videos
        $video_qnt = $Modelo->db->Sql_Contar('Musica_Video');
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Videos', 
            'Musica/Video/Videos', 
            'facetime-video', 
            $video_qnt, 
            'light-green', 
            true, 
            20
        );
    }
    
}
?>