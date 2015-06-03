<?php
class Musica_VideoControle extends Musica_Controle
{
    public function __construct(){
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses video_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Musica/Video/Videos');
        return false;
    }
    static function Endereco_Video($true=true,$artista=false,$album=false,$musica=false){
        if($artista ==='false' || $artista ===0)  $artista    = false;
        if($album ==='false' || $album ===0)  $album      = false;
        if($musica ==='false' || $musica ===0) $musica     = false;
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($artista===false){
            $titulo = 'Todos os Videos';
            $link   = 'Musica/Video/Videos';
        }else{
            if($album!==false){
                if($musica!==false){
                    Musica_MusicaControle::Endereco_Musica(true, $artista, $album);
                    $titulo = $musica->nome;
                    $link   = 'Musica/Video/Videos/'.$artista->id.'/'.$album->id.'/'.$musica->id;
                }else{
                    Musica_AlbumControle::Endereco_Album(true, $artista);
                    $titulo = $album->nome;
                    $link   = 'Musica/Video/Videos/'.$artista->id.'/'.$album->id;
                }
            }else{
                Musica_ArtistaControle::Endereco_Artista();
                $titulo = $artista->nome;
                $link   = 'Musica/Video/Videos/'.$artista->id;
            }
        }
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Videos_Tabela(&$videos,$artista=false,$album=false,$musica=false){
        if($artista ==='false' || $artista ===0)  $artista    = false;
        if($album ==='false' || $album ===0)  $album      = false;
        if($musica ==='false' || $musica ===0) $musica     = false;
        $registro   = \Framework\App\Registro::getInstacia();
        $Modelo     = &$registro->_Modelo;
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($videos)) $videos = Array(0=>$videos);
        reset($videos);
        foreach ($videos as &$valor) {
            if($artista!==false && $artista!=0){
                if($album!==false && $album!=0){
                    if($musica!==false && $musica!=0){
                        $edit_url   = 'Musica/Video/Videos_Edit/'.$valor->id.'/'.$valor->artista.'/'.$valor->album.'/'.$valor->musica.'/';
                        $del_url    = 'Musica/Video/Videos_Del/'.$valor->id.'/'.$valor->artista.'/'.$valor->album.'/'.$valor->musica.'/';
                    }else{
                        $tabela['Musica'][$i]   = $valor->musica2;
                        $edit_url   = 'Musica/Video/Videos_Edit/'.$valor->id.'/'.$valor->artista.'/'.$valor->album.'/';
                        $del_url    = 'Musica/Video/Videos_Del/'.$valor->id.'/'.$valor->artista.'/'.$valor->album.'/';
                    }
                }else{
                    $tabela['Album'][$i]     = $valor->album2;
                    $tabela['Musica'][$i]   = $valor->musica2;
                    $edit_url   = 'Musica/Video/Videos_Edit/'.$valor->id.'/'.$valor->artista.'/';
                    $del_url    = 'Musica/Video/Videos_Del/'.$valor->id.'/'.$valor->artista.'/';
                }
            }else{
                $tabela['Artista'][$i]   = $valor->artista2;
                $tabela['Album'][$i]     = $valor->album2;
                $tabela['Musica'][$i]   = $valor->musica2;
                $edit_url   = 'Musica/Video/Videos_Edit/'.$valor->id.'/';
                $del_url    = 'Musica/Video/Videos_Del/'.$valor->id.'/';
            }
            if($valor->foto==='' || $valor->foto===false){
                $foto = WEB_URL.'img'.US.'icons'.US.'clientes.png';
            }else{
                $foto = $valor->foto;
            }
            $tabela['Foto'][$i]                         = '<img src="'.$foto.'" style="max-width:100px;" />';
            $tabela['Nome do Video'][$i]                = $valor->nome;
            $tabela['Data Registrado no Sistema'][$i]   = $valor->log_date_add;
            $status                                     = $valor->status;
            $destaque                                     = $valor->destaque;
            if($status!=1){
                $status = 0;
                $texto = 'Desativado';
            }else{
                $status = 1;
                $texto = 'Ativado';
            }
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Visualizar Video'    ,'Musica/Video/Videos_Ver/'.$valor->id    ,'','youtube','inverse')).
                                            '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$status     ,Array($texto        ,'Musica/Video/Status/'.$valor->id.'/'    ,'')).'</span>';
            if($destaque==1){
                $destaque = 1;
                $texto = 'Em Destaque';
            }else{
                $destaque = 0;
                $texto = 'Não está em destaque';
            }
            $tabela['Funções'][$i]      .= '<span id="destaques'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Destaque'.$destaque   ,Array($texto   ,'Musica/Video/Destaques/'.$valor->id.'/'    ,'')).'</span>'.            
                                            $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Video'        ,$edit_url    ,'')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Video'       ,$del_url     ,'Deseja realmente deletar essa Video ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Videos($artista=false,$album=false,$musica=false,$export=false){
        if($artista ==='false' || $artista ===0)  $artista    = false;
        if($album ==='false' || $album ===0)  $album      = false;
        if($musica ==='false' || $musica ===0)  $musica     = false;
        if($artista!==false){
            $artista = (int) $artista;
            if($artista==0){
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array(),1,'id DESC');
                if($artista_registro===false){
                    throw new \Exception('Não existe nenhuma artista:', 404);
                }
                $artista = $artista_registro->id;
            }else{
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array('id'=>$artista),1);
                if($artista_registro===false){
                    throw new \Exception('Esse Artista não existe:', 404);
                }
            }
            $where = Array(
                'artista'   => $artista,
            );
            // Albuns
            if($album!==false){
                $album = (int) $album;
                if($album==0){
                    $album_registro = $this->_Modelo->db->Sql_Select('Musica_Album',Array(),1,'id DESC');
                    if($album_registro===false){
                        throw new \Exception('Não existe nenhuma artista:', 404);
                    }
                    $album = $album_registro->id;
                }else{
                    $album_registro = $this->_Modelo->db->Sql_Select('Musica_Album',Array('id'=>$artista),1);
                    if($album_registro===false){
                        throw new \Exception('Esse Artista não existe:', 404);
                    }
                }
                $where['album'] = $album;
                // Musicas
                if($musica!==false){
                    $musica = (int) $musica;
                    if($musica==0){
                        $musica_registro = $this->_Modelo->db->Sql_Select('Musica',Array(),1,'id DESC');
                        if($musica_registro===false){
                            throw new \Exception('Não existe nenhuma artista:', 404);
                        }
                        $musica = $musica_registro->id;
                    }else{
                        $musica_registro = $this->_Modelo->db->Sql_Select('Musica',Array('id'=>$musica),1);
                        if($musica_registro===false){
                            throw new \Exception('Esse Artista não existe:', 404);
                        }
                    }
                    $where['musica'] = $musica;
                    $titulo_add = 'Adicionar novo Video a musica '.$musica_registro->nome;
                    $url_add = '/'.$artista.'/'.$album.'/'.$musica;
                    $erro = 'Nenhum Video dessa Musica';
                    $titulo = 'Listagem de Videos: '.$artista_registro->nome;
                    self::Endereco_Video(false, $artista_registro, $album_registro, $musica_registro);
                }else{
                    $titulo_add = 'Adicionar novo Video ao album '.$album_registro->nome;
                    $url_add = '/'.$artista.'/'.$album.'/false';
                    $erro = 'Nenhum Video desse Album';
                    $titulo = 'Listagem de Videos: '.$artista_registro->nome;
                    self::Endereco_Video(false, $artista_registro, $album_registro, false);
                }
            }else{
                $titulo_add = 'Adicionar novo Video a '.$artista_registro->nome;
                $url_add = '/'.$artista.'/false/false';
                $erro = 'Nenhum Video nesse Artista';
                $titulo = 'Listagem de Videos: '.$artista_registro->nome;
                self::Endereco_Video(false, $artista_registro, false, false);
            }
        }else{
            $titulo_add = 'Adicionar novo Video';
            $url_add = '/false/false/false';
            $erro = 'Nenhum Video de nenhum Artista';
            $titulo = 'Listagem de Videos em Todos os Artistas';
            $where = Array();
            self::Endereco_Video(false, false, false, false);
        }
        $add_url = 'Musica/Video/Videos_Add'.$url_add;
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                $titulo_add,
                $add_url,
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Musica/Video/Videos'.$url_add,
            )
        )));
        $videos = $this->_Modelo->db->Sql_Select('Musica_Video',$where);
        if($videos!==false && !empty($videos)){
            list($tabela,$i) = self::Videos_Tabela($videos,$artista,$album,$musica);
            $titulo = $titulo.' ('.$i.')';
            if($export!==false){
                self::Export_Todos($export,$tabela, $titulo);
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{     
            $titulo = $titulo.' ('.$i.')';
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$erro.'</font></b></center>');
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo',$titulo);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Videos_Add($artista = false,$album=false,$musica=false){
        if($artista ==='false' || $artista ===0)  $artista    = false;
        if($album ==='false' || $album ===0)  $album      = false;
        if($musica ==='false' || $musica ===0) $musica     = false;
        // Carrega Config
        $formid     = 'form_Sistema_Admin_Videos';
        $formbt     = 'Salvar';
        $campos     = Musica_Video_DAO::Get_Colunas();
        if($artista===false){
            $formlink   = 'Musica/Video/Videos_Add2';
            $titulo1    = 'Adicionar Video';
            $titulo2    = 'Salvar Video';
            self::Endereco_Video(true, false);
        }else{
            $artista = (int) $artista;
            if($artista==0){
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array(),1,'id DESC');
                if($artista_registro===false){
                    throw new \Exception('Não existe nenhuma artista:', 404);
                }
                $artista = $artista_registro->id;
            }else{
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array('id'=>$artista),1);
                if($artista_registro===false){
                    throw new \Exception('Esse Artista não existe:', 404);
                }
            }
            self::DAO_Campos_Retira($campos,'artista');
            if($album!==false){
                $album = (int) $album;
                if($album==0){
                    $album_registro = $this->_Modelo->db->Sql_Select('Musica_Album',Array(),1,'id DESC');
                    if($album_registro===false){
                        throw new \Exception('Não existe nenhum album:', 404);
                    }
                    $album = $album_registro->id;
                }else{
                    $album_registro = $this->_Modelo->db->Sql_Select('Musica_Album',Array('id'=>$album),1);
                    if($album_registro===false){
                        throw new \Exception('Esse Album não existe:', 404);
                    }
                }
                self::DAO_Campos_Retira($campos,'album');
                if($musica!==false){
                    self::DAO_Campos_Retira($campos,'musica');
                    $musica = (int) $musica;
                    if($musica==0){
                        $musica_registro = $this->_Modelo->db->Sql_Select('Musica',Array(),1,'id DESC');
                        if($musica_registro===false){
                            throw new \Exception('Não existe nenhuma musica:', 404);
                        }
                        $musica = $musica_registro->id;
                    }else{
                        $musica_registro = $this->_Modelo->db->Sql_Select('Musica',Array('id'=>$musica),1);
                        if($musica_registro===false){
                            throw new \Exception('Esse Musica não existe:', 404);
                        }
                    }
                    $formlink   = 'Musica/Video/Videos_Add2/'.$artista.'/'.$album.'/'.$musica;
                    $titulo1    = 'Adicionar Video: '.$musica_registro->nome ;
                    $titulo2    = 'Salvar Video: '.$musica_registro->nome ;
                    self::Endereco_Video(true, $artista_registro);
                }else{
                    $formlink   = 'Musica/Video/Videos_Add2/'.$artista.'/'.$album;
                    $titulo1    = 'Adicionar Video: '.$album_registro->nome ;
                    $titulo2    = 'Salvar Video: '.$album_registro->nome ;
                    self::Endereco_Video(true, $artista_registro);
                }
            }else{
                $formlink   = 'Musica/Video/Videos_Add2/'.$artista;
                $titulo1    = 'Adicionar Video ao Artista: '.$artista_registro->nome ;
                $titulo2    = 'Salvar Video ao Artista: '.$artista_registro->nome ;
                self::Endereco_Video(true, $artista_registro);
            }
        }
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Videos_Add2($artista=false,$album=false,$musica=false){
        if($artista ==='false' || $artista ===0)  $artista    = false;
        if($album ==='false' || $album ===0)  $album      = false;
        if($musica ==='false' || $musica ===0) $musica     = false;
        $titulo     = 'Video Adicionada com Sucesso';
        $dao        = 'Musica_Video';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Video cadastrada com sucesso.';
        if($artista!==false){
            $artista = (int) $artista;
            $alterar    = Array('artista'=>$artista);
            if($album!==false){
                $album = (int) $album;
                $alterar['album'] = $album;
                if($musica!==false){
                    $musica = (int) $musica;
                    $alterar['musica'] = $musica;
                    $funcao     = '$this->Videos('.$artista.','.$album.','.$musica.');';
                }else{
                    $funcao     = '$this->Videos('.$artista.','.$album.');';
                }
            }else{
                $funcao     = '$this->Videos('.$artista.');';
            }
        }else{
            $funcao     = '$this->Videos();';
            $alterar    = Array();
        }
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Videos_Edit($id,$artista = false,$album=false,$musica=false){
        if($artista ==='false' || $artista ===0)  $artista    = false;
        if($album ==='false' || $album ===0)  $album      = false;
        if($musica ==='false' || $musica ===0) $musica     = false;
        if($id===false){
            throw new \Exception('Video não existe:'. $id, 404);
        }
        $id         = (int) $id;
        if($artista!==false){
            $artista    = (int) $artista;
        }
        // Carrega Config
        $formid     = 'form_Sistema_AdminC_VideoEdit';
        $formbt     = 'Alterar Video';
        $campos = Musica_Video_DAO::Get_Colunas();
        
        
        if($artista===false){
            $formlink   = 'Musica/Video/Videos_Edit2/'.$id;
            $titulo1    = 'Editar Video (#'.$id.')';
            $titulo2    = 'Alteração de Video (#'.$id.')';
            self::Endereco_Video(true, false);
        }else{
            $artista = (int) $artista;
            if($artista==0){
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array(),1,'id DESC');
                if($artista_registro===false){
                    throw new \Exception('Não existe nenhuma artista:', 404);
                }
                $artista = $artista_registro->id;
            }else{
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array('id'=>$artista),1);
                if($artista_registro===false){
                    throw new \Exception('Esse Artista não existe:', 404);
                }
            }
            self::DAO_Campos_Retira($campos,'artista');
            if($album!==false){
                $album = (int) $album;
                self::DAO_Campos_Retira($campos,'album');
                if($musica!==false){
                    $musica = (int) $musica;
                    $formlink   = 'Musica/Video/Videos_Edit2/'.$id.'/'.$artista.'/'.$album.'/'.$musica;
                    $titulo1    = 'Editar Video (#'.$id.'): '.$artista_registro->nome ;
                    $titulo2    = 'Alteração de Video (#'.$id.'): '.$artista_registro->nome ;
                    self::Endereco_Video(true, $artista_registro);
                }else{
                    $formlink   = 'Musica/Video/Videos_Edit2/'.$id.'/'.$artista.'/'.$album;
                    $titulo1    = 'Editar Video (#'.$id.'): '.$album_registro->nome ;
                    $titulo2    = 'Alteração de Video (#'.$id.'): '.$album_registro->nome ;
                    self::Endereco_Video(true, $artista_registro);
                }
            }else{
                $formlink   = 'Musica/Video/Videos_Edit2/'.$id.'/'.$artista;
                $titulo1    = 'Editar Video (#'.$id.') ao Artista: '.$artista_registro->nome ;
                $titulo2    = 'Alteração de Video ao Artista (#'.$id.'): '.$artista_registro->nome ;
                self::Endereco_Video(true, $artista_registro);
            }
        }
        $editar     = Array('Musica_Video',$id);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Videos_Edit2($id,$artista = false,$album=false,$musica=false){
        if($artista ==='false' || $artista ===0)  $artista    = false;
        if($album ==='false' || $album ===0)  $album      = false;
        if($musica ==='false' || $musica ===0) $musica     = false;
        if($id===false){
            throw new \Exception('Video não existe:'. $id, 404);
        }
        $id         = (int) $id;
        $titulo     = 'Video Editado com Sucesso';
        $dao        = Array('Musica_Video',$id);
        if($artista!==false){
            $artista = (int) $artista;
            $alterar    = Array('artista'=>$artista);
            if($album!==false){
                $album = (int) $album;
                $alterar['album'] = $album;
                if($musica!==false){
                    $musica = (int) $musica;
                    $alterar['musica'] = $musica;
                    $funcao     = '$this->Videos('.$artista.','.$album.','.$musica.');';
                }else{
                    $funcao     = '$this->Videos('.$artista.','.$album.');';
                }
            }else{
                $funcao     = '$this->Videos('.$artista.');';
            }
        }else{
            $funcao     = '$this->Videos(0,0,0);';
            $alterar    = Array();
        }
        $sucesso1   = 'Video Alterado com Sucesso.';
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Videos_Del($id = false,$artista=false,$album=false,$musica=false){
        if($artista ==='false' || $artista ===0)  $artista    = false;
        if($album ==='false' || $album ===0)  $album      = false;
        if($musica ==='false' || $musica ===0) $musica     = false;
        global $language;
        if($id===false){
            throw new \Exception('Video não existe:'. $id, 404);
        }
        // Antiinjection
    	$id = (int) $id;
        if($artista!==false){
            $artista    = (int) $artista;
            $where = Array('artista'=>$artista,'id'=>$id);
            if($album!==false){
                $album    = (int) $album;
                $where['album'] = $album;
                if($musica!==false){
                    $musica    = (int) $musica;
                    $where['musica'] = $musica;
                }
            }
        }else{
            $where = Array('id'=>$id);
        }
        // Puxa video e deleta
        $video = $this->_Modelo->db->Sql_Select('Musica_Video', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($video);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Video deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Recupera Videos
        if($artista!==false){
            if($album!==false){
                if($musica!==false){
                    $this->Videos($artista,$album,$musica);
                }else{
                    $this->Videos($artista,$album);
                }
            }else{
                $this->Videos($artista);
            }
        }else{
            $this->Videos();
        }
        
        $this->_Visual->Json_Info_Update('Titulo', __('Video deletado com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    public function Videos_Ver($video=false){
        if($video===false){
            throw new \Exception('Video não existe:'. $video, 404);
        }
        $video = (int) $video;
        $where = Array('id'=>$video);
        $video = $this->_Modelo->db->Sql_Select('Musica_Video', $where);
        $html = '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$video->youtube.'" frameborder="0" allowfullscreen></iframe>';
        $conteudo = array(
            'id' => 'popup',
            'title' => $video->musica2.' - '.$video->nome,
            'botoes' => array(
                array(
                    'text' => 'Fechar Janela',
                    'clique' => '$( this ).dialog( "close" );'
                )
            ),
            'html' => $html
        );
        $this->_Visual->Json_IncluiTipo('Popup',$conteudo);
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    public function Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Musica_Video', Array('id'=>$id),1);
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        if($resultado->status=='1'){
            $resultado->status='0';
        }else{
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            if($resultado->status==1){
                $texto = 'Ativado';
            }else{
                $texto = 'Desativado';
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Musica/Video/Status/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Destaques($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Musica_Video', Array('id'=>$id),1);
        if(!is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        if($resultado->destaque==1 || $resultado->destaque=='1'){
            $resultado->destaque='0';
        }else{
            $resultado->destaque='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            if($resultado->destaque==1){
                $texto = 'Em destaque';
            }else{
                $texto = 'Não está em destaque';
            }
            $conteudo = array(
                'location' => '#destaques'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Destaque'.$resultado->destaque     ,Array($texto        ,'Musica/Video/Destaques/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Destaque Alterado')); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
