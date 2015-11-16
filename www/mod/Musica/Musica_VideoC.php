<?php
class Musica_VideoControle extends Musica_Controle
{
    public function __construct() {
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
    * @version 0.4.2
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Musica/Video/Videos');
        return FALSE;
    }
    static function Endereco_Video($true= TRUE, $artista = FALSE, $album = FALSE, $musica = FALSE) {
        if ($artista ==='false' || $artista ===0)  $artista    = FALSE;
        if ($album ==='false' || $album ===0)  $album      = FALSE;
        if ($musica ==='false' || $musica ===0) $musica     = FALSE;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($artista === FALSE) {
            $titulo = __('Todos os Videos');
            $link   = 'Musica/Video/Videos';
        } else {
            if ($album !== FALSE) {
                if ($musica !== FALSE) {
                    Musica_MusicaControle::Endereco_Musica(true, $artista, $album);
                    $titulo = $musica->nome;
                    $link   = 'Musica/Video/Videos/'.$artista->id.'/'.$album->id.'/'.$musica->id;
                } else {
                    Musica_AlbumControle::Endereco_Album(true, $artista);
                    $titulo = $album->nome;
                    $link   = 'Musica/Video/Videos/'.$artista->id.'/'.$album->id;
                }
            } else {
                Musica_ArtistaControle::Endereco_Artista();
                $titulo = $artista->nome;
                $link   = 'Musica/Video/Videos/'.$artista->id;
            }
        }
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Videos_Tabela(&$videos, $artista = FALSE, $album = FALSE, $musica = FALSE) {
        if ($artista ==='false' || $artista ===0)  $artista    = FALSE;
        if ($album ==='false' || $album ===0)  $album      = FALSE;
        if ($musica ==='false' || $musica ===0) $musica     = FALSE;
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if (is_object($videos)) $videos = Array(0=>$videos);
        reset($videos);
        foreach ($videos as &$valor) {
            if ($artista !== FALSE && $artista!=0) {
                if ($album !== FALSE && $album!=0) {
                    if ($musica !== FALSE && $musica!=0) {
                        $edit_url   = 'Musica/Video/Videos_Edit/'.$valor->id.'/'.$valor->artista.'/'.$valor->album.'/'.$valor->musica.'/';
                        $del_url    = 'Musica/Video/Videos_Del/'.$valor->id.'/'.$valor->artista.'/'.$valor->album.'/'.$valor->musica.'/';
                    } else {
                        $tabela['Musica'][$i]   = $valor->musica2;
                        $edit_url   = 'Musica/Video/Videos_Edit/'.$valor->id.'/'.$valor->artista.'/'.$valor->album.'/';
                        $del_url    = 'Musica/Video/Videos_Del/'.$valor->id.'/'.$valor->artista.'/'.$valor->album.'/';
                    }
                } else {
                    $tabela['Album'][$i]     = $valor->album2;
                    $tabela['Musica'][$i]   = $valor->musica2;
                    $edit_url   = 'Musica/Video/Videos_Edit/'.$valor->id.'/'.$valor->artista.'/';
                    $del_url    = 'Musica/Video/Videos_Del/'.$valor->id.'/'.$valor->artista.'/';
                }
            } else {
                $tabela['Artista'][$i]   = $valor->artista2;
                $tabela['Album'][$i]     = $valor->album2;
                $tabela['Musica'][$i]   = $valor->musica2;
                $edit_url   = 'Musica/Video/Videos_Edit/'.$valor->id.'/';
                $del_url    = 'Musica/Video/Videos_Del/'.$valor->id.'/';
            }
            if ($valor->foto==='' || $valor->foto === FALSE) {
                $foto = WEB_URL.'img'.US.'icons'.US.'clientes.png';
            } else {
                $foto = $valor->foto;
            }
            $tabela['Foto'][$i]                         = '<img alt="'.__('Foto de Video').' src="'.$foto.'" style="max-width:100px;" />';
            $tabela['Nome do Video'][$i]                = $valor->nome;
            $tabela['Data Registrado no Sistema'][$i]   = $valor->log_date_add;
            $status                                     = $valor->status;
            $destaque                                     = $valor->destaque;
            if ($status!=1) {
                $status = 0;
                $texto = __('Desativado');
            } else {
                $status = 1;
                $texto = __('Ativado');
            }
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Visualizar Video'    ,'Musica/Video/Videos_Ver/'.$valor->id    , '', 'youtube', 'inverse')).
                                            '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$status     ,Array($texto        ,'Musica/Video/Status/'.$valor->id.'/'    , '')).'</span>';
            if ($destaque==1) {
                $destaque = 1;
                $texto = __('Em Destaque');
            } else {
                $destaque = 0;
                $texto = __('Não está em destaque');
            }
            $tabela['Funções'][$i]      .= '<span id="destaques'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Destaque'.$destaque   ,Array($texto   ,'Musica/Video/Destaques/'.$valor->id.'/'    , '')).'</span>'.            
                                            $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Video'        , $edit_url    , '')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Video'       , $del_url     ,'Deseja realmente deletar essa Video ?'));
            ++$i;
        }
        return Array($tabela, $i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Videos($artista = FALSE, $album = FALSE, $musica = FALSE, $export = FALSE) {
        if ($artista ==='false' || $artista ===0)  $artista    = FALSE;
        if ($album ==='false' || $album ===0)  $album      = FALSE;
        if ($musica ==='false' || $musica ===0)  $musica     = FALSE;
        if ($artista !== FALSE) {
            $artista = (int) $artista;
            if ($artista==0) {
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array(),1,'id DESC');
                if ($artista_registro === FALSE) {
                    return _Sistema_erroControle::Erro_Fluxo('Não existe nenhuma artista:',404);
                }
                $artista = $artista_registro->id;
            } else {
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array('id'=>$artista),1);
                if ($artista_registro === FALSE) {
                    return _Sistema_erroControle::Erro_Fluxo('Esse Artista não existe:',404);
                }
            }
            $where = Array(
                'artista'   => $artista,
            );
            // Albuns
            if ($album !== FALSE) {
                $album = (int) $album;
                if ($album==0) {
                    $album_registro = $this->_Modelo->db->Sql_Select('Musica_Album',Array(),1,'id DESC');
                    if ($album_registro === FALSE) {
                        return _Sistema_erroControle::Erro_Fluxo('Não existe nenhuma artista:',404);
                    }
                    $album = $album_registro->id;
                } else {
                    $album_registro = $this->_Modelo->db->Sql_Select('Musica_Album',Array('id'=>$artista),1);
                    if ($album_registro === FALSE) {
                        return _Sistema_erroControle::Erro_Fluxo('Esse Artista não existe:',404);
                    }
                }
                $where['album'] = $album;
                // Musicas
                if ($musica !== FALSE) {
                    $musica = (int) $musica;
                    if ($musica==0) {
                        $musica_registro = $this->_Modelo->db->Sql_Select('Musica',Array(),1,'id DESC');
                        if ($musica_registro === FALSE) {
                            return _Sistema_erroControle::Erro_Fluxo('Não existe nenhuma artista:',404);
                        }
                        $musica = $musica_registro->id;
                    } else {
                        $musica_registro = $this->_Modelo->db->Sql_Select('Musica',Array('id'=>$musica),1);
                        if ($musica_registro === FALSE) {
                            return _Sistema_erroControle::Erro_Fluxo('Esse Artista não existe:',404);
                        }
                    }
                    $where['musica'] = $musica;
                    $titulo_add = 'Adicionar novo Video a musica '.$musica_registro->nome;
                    $url_add = '/'.$artista.'/'.$album.'/'.$musica;
                    $erro = __('Nenhum Video dessa Musica');
                    $titulo = 'Listagem de Videos: '.$artista_registro->nome;
                    self::Endereco_Video(FALSE, $artista_registro, $album_registro, $musica_registro);
                } else {
                    $titulo_add = 'Adicionar novo Video ao album '.$album_registro->nome;
                    $url_add = '/'.$artista.'/'.$album.'/false';
                    $erro = __('Nenhum Video desse Album');
                    $titulo = 'Listagem de Videos: '.$artista_registro->nome;
                    self::Endereco_Video(FALSE, $artista_registro, $album_registro, FALSE);
                }
            } else {
                $titulo_add = 'Adicionar novo Video a '.$artista_registro->nome;
                $url_add = '/'.$artista.'/false/false';
                $erro = __('Nenhum Video nesse Artista');
                $titulo = 'Listagem de Videos: '.$artista_registro->nome;
                self::Endereco_Video(FALSE, $artista_registro, FALSE, FALSE);
            }
        } else {
            $titulo_add = __('Adicionar novo Video');
            $url_add = '/false/false/false';
            $erro = __('Nenhum Video de nenhum Artista');
            $titulo = __('Listagem de Videos em Todos os Artistas');
            $where = Array();
            self::Endereco_Video(FALSE, FALSE, FALSE, FALSE);
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
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Musica/Video/Videos'.$url_add,
            )
        )));
        $videos = $this->_Modelo->db->Sql_Select('Musica_Video', $where);
        if ($videos !== FALSE && !empty($videos)) {
            list($tabela, $i) = self::Videos_Tabela($videos, $artista, $album, $musica);
            $titulo = $titulo.' ('.$i.')';
            if ($export !== FALSE) {
                self::Export_Todos($export, $tabela, $titulo);
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    FALSE,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        } else {     
            $titulo = $titulo.' ('.$i.')';
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$erro.'</font></b></center>');
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', $titulo);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Videos_Add($artista = FALSE, $album = FALSE, $musica = FALSE) {
        if ($artista ==='false' || $artista ===0)  $artista    = FALSE;
        if ($album ==='false' || $album ===0)  $album      = FALSE;
        if ($musica ==='false' || $musica ===0) $musica     = FALSE;
        // Carrega Config
        $formid     = 'form_Sistema_Admin_Videos';
        $formbt     = __('Salvar');
        $campos     = Musica_Video_DAO::Get_Colunas();
        if ($artista === FALSE) {
            $formlink   = 'Musica/Video/Videos_Add2';
            $titulo1    = __('Adicionar Video');
            $titulo2    = __('Salvar Video');
            self::Endereco_Video(true, FALSE);
        } else {
            $artista = (int) $artista;
            if ($artista==0) {
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array(),1,'id DESC');
                if ($artista_registro === FALSE) {
                    return _Sistema_erroControle::Erro_Fluxo('Não existe nenhuma artista:',404);
                }
                $artista = $artista_registro->id;
            } else {
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array('id'=>$artista),1);
                if ($artista_registro === FALSE) {
                    return _Sistema_erroControle::Erro_Fluxo('Esse Artista não existe:',404);
                }
            }
            self::DAO_Campos_Retira($campos,'artista');
            if ($album !== FALSE) {
                $album = (int) $album;
                if ($album==0) {
                    $album_registro = $this->_Modelo->db->Sql_Select('Musica_Album',Array(),1,'id DESC');
                    if ($album_registro === FALSE) {
                        return _Sistema_erroControle::Erro_Fluxo('Não existe nenhum album:',404);
                    }
                    $album = $album_registro->id;
                } else {
                    $album_registro = $this->_Modelo->db->Sql_Select('Musica_Album',Array('id'=>$album),1);
                    if ($album_registro === FALSE) {
                        return _Sistema_erroControle::Erro_Fluxo('Esse Album não existe:',404);
                    }
                }
                self::DAO_Campos_Retira($campos,'album');
                if ($musica !== FALSE) {
                    self::DAO_Campos_Retira($campos,'musica');
                    $musica = (int) $musica;
                    if ($musica==0) {
                        $musica_registro = $this->_Modelo->db->Sql_Select('Musica',Array(),1,'id DESC');
                        if ($musica_registro === FALSE) {
                            return _Sistema_erroControle::Erro_Fluxo('Não existe nenhuma musica:',404);
                        }
                        $musica = $musica_registro->id;
                    } else {
                        $musica_registro = $this->_Modelo->db->Sql_Select('Musica',Array('id'=>$musica),1);
                        if ($musica_registro === FALSE) {
                            return _Sistema_erroControle::Erro_Fluxo('Esse Musica não existe:',404);
                        }
                    }
                    $formlink   = 'Musica/Video/Videos_Add2/'.$artista.'/'.$album.'/'.$musica;
                    $titulo1    = 'Adicionar Video: '.$musica_registro->nome ;
                    $titulo2    = 'Salvar Video: '.$musica_registro->nome ;
                    self::Endereco_Video(true, $artista_registro);
                } else {
                    $formlink   = 'Musica/Video/Videos_Add2/'.$artista.'/'.$album;
                    $titulo1    = 'Adicionar Video: '.$album_registro->nome ;
                    $titulo2    = 'Salvar Video: '.$album_registro->nome ;
                    self::Endereco_Video(true, $artista_registro);
                }
            } else {
                $formlink   = 'Musica/Video/Videos_Add2/'.$artista;
                $titulo1    = 'Adicionar Video ao Artista: '.$artista_registro->nome ;
                $titulo2    = 'Salvar Video ao Artista: '.$artista_registro->nome ;
                self::Endereco_Video(true, $artista_registro);
            }
        }
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Videos_Add2($artista = FALSE, $album = FALSE, $musica = FALSE) {
        if ($artista ==='false' || $artista ===0)  $artista    = FALSE;
        if ($album ==='false' || $album ===0)  $album      = FALSE;
        if ($musica ==='false' || $musica ===0) $musica     = FALSE;
        $titulo     = __('Video Adicionada com Sucesso');
        $dao        = 'Musica_Video';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Video cadastrada com sucesso.');
        if ($artista !== FALSE) {
            $artista = (int) $artista;
            $alterar    = Array('artista'=>$artista);
            if ($album !== FALSE) {
                $album = (int) $album;
                $alterar['album'] = $album;
                if ($musica !== FALSE) {
                    $musica = (int) $musica;
                    $alterar['musica'] = $musica;
                    $funcao     = '$this->Videos('.$artista.', '.$album.', '.$musica.');';
                } else {
                    $funcao     = '$this->Videos('.$artista.', '.$album.');';
                }
            } else {
                $funcao     = '$this->Videos('.$artista.');';
            }
        } else {
            $funcao     = '$this->Videos();';
            $alterar    = Array();
        }
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);
    }
    
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Videos_Edit($id, $artista = FALSE, $album = FALSE, $musica = FALSE) {
        if ($artista ==='false' || $artista ===0)  $artista    = FALSE;
        if ($album ==='false' || $album ===0)  $album      = FALSE;
        if ($musica ==='false' || $musica ===0) $musica     = FALSE;
        if ($id === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Video não existe:'. $id,404);
        }
        $id         = (int) $id;
        if ($artista !== FALSE) {
            $artista    = (int) $artista;
        }
        // Carrega Config
        $formid     = 'form_Sistema_AdminC_VideoEdit';
        $formbt     = __('Alterar Video');
        $campos = Musica_Video_DAO::Get_Colunas();
        
        
        if ($artista === FALSE) {
            $formlink   = 'Musica/Video/Videos_Edit2/'.$id;
            $titulo1    = 'Editar Video (#'.$id.')';
            $titulo2    = 'Alteração de Video (#'.$id.')';
            self::Endereco_Video(true, FALSE);
        } else {
            $artista = (int) $artista;
            if ($artista==0) {
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array(),1,'id DESC');
                if ($artista_registro === FALSE) {
                    return _Sistema_erroControle::Erro_Fluxo('Não existe nenhuma artista:',404);
                }
                $artista = $artista_registro->id;
            } else {
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array('id'=>$artista),1);
                if ($artista_registro === FALSE) {
                    return _Sistema_erroControle::Erro_Fluxo('Esse Artista não existe:',404);
                }
            }
            self::DAO_Campos_Retira($campos,'artista');
            if ($album !== FALSE) {
                $album = (int) $album;
                self::DAO_Campos_Retira($campos,'album');
                if ($musica !== FALSE) {
                    $musica = (int) $musica;
                    $formlink   = 'Musica/Video/Videos_Edit2/'.$id.'/'.$artista.'/'.$album.'/'.$musica;
                    $titulo1    = 'Editar Video (#'.$id.'): '.$artista_registro->nome ;
                    $titulo2    = 'Alteração de Video (#'.$id.'): '.$artista_registro->nome ;
                    self::Endereco_Video(true, $artista_registro);
                } else {
                    $formlink   = 'Musica/Video/Videos_Edit2/'.$id.'/'.$artista.'/'.$album;
                    $titulo1    = 'Editar Video (#'.$id.'): '.$album_registro->nome ;
                    $titulo2    = 'Alteração de Video (#'.$id.'): '.$album_registro->nome ;
                    self::Endereco_Video(true, $artista_registro);
                }
            } else {
                $formlink   = 'Musica/Video/Videos_Edit2/'.$id.'/'.$artista;
                $titulo1    = 'Editar Video (#'.$id.') ao Artista: '.$artista_registro->nome ;
                $titulo2    = 'Alteração de Video ao Artista (#'.$id.'): '.$artista_registro->nome ;
                self::Endereco_Video(true, $artista_registro);
            }
        }
        $editar     = Array('Musica_Video', $id);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Videos_Edit2($id, $artista = FALSE, $album = FALSE, $musica = FALSE) {
        if ($artista ==='false' || $artista ===0)  $artista    = FALSE;
        if ($album ==='false' || $album ===0)  $album      = FALSE;
        if ($musica ==='false' || $musica ===0) $musica     = FALSE;
        if ($id === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Video não existe:'. $id,404);
        }
        $id         = (int) $id;
        $titulo     = __('Video Editado com Sucesso');
        $dao        = Array('Musica_Video', $id);
        if ($artista !== FALSE) {
            $artista = (int) $artista;
            $alterar    = Array('artista'=>$artista);
            if ($album !== FALSE) {
                $album = (int) $album;
                $alterar['album'] = $album;
                if ($musica !== FALSE) {
                    $musica = (int) $musica;
                    $alterar['musica'] = $musica;
                    $funcao     = '$this->Videos('.$artista.', '.$album.', '.$musica.');';
                } else {
                    $funcao     = '$this->Videos('.$artista.', '.$album.');';
                }
            } else {
                $funcao     = '$this->Videos('.$artista.');';
            }
        } else {
            $funcao     = '$this->Videos(0,0,0);';
            $alterar    = Array();
        }
        $sucesso1   = __('Video Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Videos_Del($id = FALSE, $artista = FALSE, $album = FALSE, $musica = FALSE) {
        if ($artista ==='false' || $artista ===0)  $artista    = FALSE;
        if ($album ==='false' || $album ===0)  $album      = FALSE;
        if ($musica ==='false' || $musica ===0) $musica     = FALSE;
        
        if ($id === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Video não existe:'. $id,404);
        }
        // Antiinjection
    	$id = (int) $id;
        if ($artista !== FALSE) {
            $artista    = (int) $artista;
            $where = Array('artista'=>$artista,'id'=>$id);
            if ($album !== FALSE) {
                $album    = (int) $album;
                $where['album'] = $album;
                if ($musica !== FALSE) {
                    $musica    = (int) $musica;
                    $where['musica'] = $musica;
                }
            }
        } else {
            $where = Array('id'=>$id);
        }
        // Puxa video e deleta
        $video = $this->_Modelo->db->Sql_Select('Musica_Video', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($video);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Video deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        // Recupera Videos
        if ($artista !== FALSE) {
            if ($album !== FALSE) {
                if ($musica !== FALSE) {
                    $this->Videos($artista, $album, $musica);
                } else {
                    $this->Videos($artista, $album);
                }
            } else {
                $this->Videos($artista);
            }
        } else {
            $this->Videos();
        }
        
        $this->_Visual->Json_Info_Update('Titulo', __('Video deletado com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', FALSE);
    }
    public function Videos_Ver($video = FALSE) {
        if ($video === FALSE) {
            return FALSE;
        }
        $video = (int) $video;
        $where = Array('id'=>$video);
        $video = $this->_Modelo->db->Sql_Select('Musica_Video', $where);
        if ($video === FALSE) {
            return FALSE;
        }
        $html = '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$video->youtube.'" frameborder="0" allowfullscreen></iframe>';
        $conteudo = array(
            'id' => 'popup',
            'title' => $video->musica2.' - '.$video->nome,
            'botoes' => array(
                array(
                    'text' => __('Fechar Janela'),
                    'clique' => '$( this ).dialog( "close" );'
                )
            ),
            'html' => $html
        );
        $this->_Visual->Json_IncluiTipo('Popup', $conteudo);
        $this->_Visual->Json_Info_Update('Historico', FALSE);
    }
    public function Status($id = FALSE) {
        if ($id === FALSE) {
            return FALSE;
        }
        $resultado = $this->_Modelo->db->Sql_Select('Musica_Video', Array('id'=>$id),1);
        if ($resultado === FALSE || !is_object($resultado)) {
            return FALSE;
        }
        if ($resultado->status=='1') {
            $resultado->status='0';
        } else {
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if ($sucesso) {
            if ($resultado->status==1) {
                $texto = __('Ativado');
            } else {
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Musica/Video/Status/'.$resultado->id.'/'    , ''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    public function Destaques($id = FALSE) {
        if ($id === FALSE) {
            return FALSE;
        }
        $resultado = $this->_Modelo->db->Sql_Select('Musica_Video', Array('id'=>$id),1);
        if (!is_object($resultado)) {
            return FALSE;
        }
        if ($resultado->destaque==1 || $resultado->destaque=='1') {
            $resultado->destaque='0';
        } else {
            $resultado->destaque='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if ($sucesso) {
            if ($resultado->destaque==1) {
                $texto = __('Em destaque');
            } else {
                $texto = __('Não está em destaque');
            }
            $conteudo = array(
                'location' => '#destaques'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Destaque'.$resultado->destaque     ,Array($texto        ,'Musica/Video/Destaques/'.$resultado->id.'/'    , ''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Destaque Alterado')); 
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
