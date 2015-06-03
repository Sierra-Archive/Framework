<?php
class Musica_AlbumControle extends Musica_Controle
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
    * @uses album_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Musica/Album/Albuns');
        return false;
    }
    static function Endereco_Album($true=true,$artista=false){
        if($artista==='false') $artista = false;
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($artista===false){
            $titulo = 'Todos os Albuns';
            $link   = 'Musica/Album/Albuns';
        }else{
            Musica_ArtistaControle::Endereco_Artista();
            $titulo = $artista->nome;
            $link   = 'Musica/Album/Albuns/'.$artista->id;
        }
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Albuns_Tabela(&$albuns,$artista=false){
        if($artista==='false') $artista = false;
        $registro   = \Framework\App\Registro::getInstacia();
        $Modelo     = &$registro->_Modelo;
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($albuns)) $albuns = Array(0=>$albuns);
        reset($albuns);
        foreach ($albuns as &$valor) {
            if($artista===false || $artista==0){
                
                $tabela['Artista'][$i]   = $valor->artista2;
                $edit_url   = 'Musica/Album/Albuns_Edit/'.$valor->id.'/';
                $del_url    = 'Musica/Album/Albuns_Del/'.$valor->id.'/';
            }else{
                $edit_url   = 'Musica/Album/Albuns_Edit/'.$valor->id.'/'.$valor->artista.'/';
                $del_url    = 'Musica/Album/Albuns_Del/'.$valor->id.'/'.$valor->artista.'/';
            }
            if($valor->foto==='' || $valor->foto===false){
                $foto = WEB_URL.'img'.US.'icons'.US.'clientes.png';
            }else{
                $foto = $valor->foto;
            }
            $tabela['Foto'][$i]             = '<img src="'.$foto.'" style="max-width:100px;" />';
            $tabela['Nome'][$i]             = $valor->nome;
            $tabela['Lançamento'][$i]       = $valor->lancamento;
            $tabela['Data Registrada no Sistema'][$i]  = $valor->log_date_add;
            $status                                 = $valor->status;
            if($status!=1){
                $status = 0;
                $texto = 'Desativado';
            }else{
                $status = 1;
                $texto = 'Ativado';
            }
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar Musicas do Album'    ,'Musica/Musica/Musicas/'.$valor->artista.'/'.$valor->id.'/'    ,'')).
                                              '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$status     ,Array($texto        ,'Musica/Album/Status/'.$valor->id.'/'    ,'')).'</span>'.
                                              $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Album'        ,$edit_url    ,'')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Album'       ,$del_url     ,'Deseja realmente deletar esse Album ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Albuns($artista=false,$export=false){
        if($artista ==='false' || $artista ===0)  $artista    = false;
        if($artista!==false){
            $artista = (int) $artista;
            if($artista==0){
                $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array(),1,'id DESC');
                if($artista_registro===false){
                    throw new \Exception('Não existe nenhum artista:', 404);
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
            self::Endereco_Album(false, $artista_registro);
        }else{
            $where = Array();
            self::Endereco_Album(false, false);
        }
        $i = 0;
        if($artista!==false){
            $titulo_add = 'Adicionar novo Album ao Artista: '.$artista_registro->nome;
            $url_add = '/'.$artista;
            $add_url = 'Musica/Album/Albuns_Add/'.$artista;
        }else{
            $titulo_add = 'Adicionar novo Album';
            $url_add = '/false';
            $add_url    = 'Musica/Album/Albuns_Add';
        }
        $add_url = 'Musica/Album/Albuns_Add'.$url_add;
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
                'Link'      => 'Musica/Album/Albuns'.$url_add,
            )
        )));
        $albuns = $this->_Modelo->db->Sql_Select('Musica_Album',$where);
        if($artista!==false){
            $titulo = 'Listagem de Albuns: '.$artista_registro->nome;
        }else{
            $titulo = 'Listagem de Albuns em Todos os Artistas';
        }
        if($albuns!==false && !empty($albuns)){
            list($tabela,$i) = self::Albuns_Tabela($albuns,$artista);
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
            if($artista!==false){
                $erro = 'Nenhuma Album nesse Artista';
            }else{
                $erro = 'Nenhuma Album nos Artistas';
            }         
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
    public function Albuns_Add($artista = false){
        if($artista==='false') $artista = false;
        // Carrega Config
        $formid     = 'form_Sistema_Admin_Albuns';
        $formbt     = 'Salvar';
        $campos     = Musica_Album_DAO::Get_Colunas();
        if($artista===false){
            $formlink   = 'Musica/Album/Albuns_Add2';
            $titulo1    = 'Adicionar Album';
            $titulo2    = 'Salvar Album';
            self::Endereco_Album(true, false);
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
            $formlink   = 'Musica/Album/Albuns_Add2/'.$artista;
            self::DAO_Campos_Retira($campos,'artista');
            $titulo1    = 'Adicionar Album de '.$artista_registro->nome ;
            $titulo2    = 'Salvar Album de '.$artista_registro->nome ;
            self::Endereco_Album(true, $artista_registro);
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
    public function Albuns_Add2($artista=false){
        if($artista==='false') $artista = false;
        $titulo     = 'Album Adicionada com Sucesso';
        $dao        = 'Musica_Album';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Album cadastrada com sucesso.';
        if($artista===false){
            $funcao     = '$this->Albuns(0);';
            $alterar    = Array();
        }else{
            $artista = (int) $artista;
            $alterar    = Array('artista'=>$artista);
            $funcao     = '$this->Albuns('.$artista.');';
        }
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Albuns_Edit($id,$artista = false){
        if($artista==='false') $artista = false;
        if($id===false){
            throw new \Exception('Album não existe:'. $id, 404);
        }
        $id         = (int) $id;
        if($artista!==false){
            $artista    = (int) $artista;
        }
        // Carrega Config
        $titulo1    = 'Editar Album (#'.$id.')';
        $titulo2    = 'Alteração de Album';
        $formid     = 'form_Sistema_AdminC_AlbumEdit';
        $formbt     = 'Alterar Album';
        $campos = Musica_Album_DAO::Get_Colunas();
        if($artista!==false){
            $artista_registro = $this->_Modelo->db->Sql_Select('Musica_Album_Artista',Array('id'=>$artista),1);
            if($artista_registro===false){
                throw new \Exception('Esse Artista não existe:', 404);
            }
            $formlink   = 'Musica/Album/Albuns_Edit2/'.$id.'/'.$artista;
            self::DAO_Campos_Retira($campos,'artista');
            self::Endereco_Album(true, $artista_registro);
        }else{
            $formlink   = 'Musica/Album/Albuns_Edit2/'.$id;
            self::Endereco_Album(true, false);
        }
        $editar     = Array('Musica_Album',$id);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Albuns_Edit2($id,$artista = false){
        if($artista==='false') $artista = false;
        if($id===false){
            throw new \Exception('Album não existe:'. $id, 404);
        }
        $id         = (int) $id;
        if($artista!==false){
            $artista    = (int) $artista;
        }
        $titulo     = 'Album Editada com Sucesso';
        $dao        = Array('Musica_Album',$id);
        if($artista!==false){
            $funcao     = '$this->Albuns('.$artista.');';
        }else{
            $funcao     = '$this->Albuns();';
        }
        $sucesso1   = 'Album Alterada com Sucesso.';
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
    public function Albuns_Del($id = false,$artista=false){
        if($artista==='false') $artista = false;
        global $language;
        if($id===false){
            throw new \Exception('Album não existe:'. $id, 404);
        }
        // Antiinjection
    	$id = (int) $id;
        if($artista!==false){
            $artista    = (int) $artista;
            $where = Array('artista'=>$artista,'id'=>$id);
        }else{
            $where = Array('id'=>$id);
        }
        // Puxa album e deleta
        $album = $this->_Modelo->db->Sql_Select('Musica_Album', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($album);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Album deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Recupera Albuns
        if($artista!==false){
            $this->Albuns($artista);
        }else{
            $this->Albuns();
        }
        
        $this->_Visual->Json_Info_Update('Titulo', __('Album deletada com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    public function Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Musica_Album', Array('id'=>$id),1);
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
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Musica/Album/Status/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
