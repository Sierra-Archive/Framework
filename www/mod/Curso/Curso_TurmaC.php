<?php
class Curso_TurmaControle extends Curso_Controle
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
    * @version 3.1.1
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Curso/Turma/Turmas');
        return false;
    }
    static function Endereco_Turma($true=true,$curso=false){
        if($curso==='false') $curso = false;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if($curso===false){
            $titulo = __('Todas as Turmas');
            $link   = 'Curso/Turma/Turmas';
        }else{
            Curso_CursoControle::Endereco_Curso();
            $titulo = $curso->nome;
            $link   = 'Curso/Turma/Turmas/'.$curso->id;
        }
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Turma_Ver($true=true,$turma,$curso=false){
        if($turma==='false') $turma = false;
        if($curso==='false') $curso = false;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        self::Endereco_Turma(true,$curso);
        $titulo = 'Visualizar Turma: '.$turma->nome;
        if($curso===false){
            $link   = 'Curso/Turma/Turmas_Ver/'.$turma->id;
        }else{
            $link   = 'Curso/Turma/Turmas_Ver/'.$turma->id.'/'.$curso->id;
        }
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Aberta($true=true,$curso=false){
        if($curso==='false') $curso = false;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if($curso===false){
            $titulo = __('Todas as Turmas');
            $link   = 'Curso/Turma/Abertas';
        }else{
            Curso_CursoControle::Endereco_Curso();
            $titulo = $curso->nome;
            $link   = 'Curso/Turma/Abertas/'.$curso->id;
        }
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Turmas_Tabela(&$turmas,$curso=false){
        if($curso==='false') $curso = false;
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($turmas)) $turmas = Array(0=>$turmas);
        reset($turmas);
        foreach ($turmas as &$valor) {
            if($curso===false || $curso==0){
                
                $tabela['Curso'][$i]   = $valor->curso2;
                $ver_url    = 'Curso/Turma/Turmas_Ver/'.$valor->id.'/';
                $edit_url   = 'Curso/Turma/Turmas_Edit/'.$valor->id.'/';
                $del_url    = 'Curso/Turma/Turmas_Del/'.$valor->id.'/';
            }else{
                $ver_url    = 'Curso/Turma/Turmas_Ver/'.$valor->id.'/'.$valor->curso.'/';
                $edit_url   = 'Curso/Turma/Turmas_Edit/'.$valor->id.'/'.$valor->curso.'/';
                $del_url    = 'Curso/Turma/Turmas_Del/'.$valor->id.'/'.$valor->curso.'/';
            }
            $tabela['Nome'][$i]             = $valor->nome;
            $tabela['Vagas'][$i]            = $valor->qnt;
            $tabela['Inicio'][$i]           = $valor->inicio;
            $tabela['Fim'][$i]              = $valor->fim;
            $tabela['Data Registrada no Sistema'][$i]  = $valor->log_date_add;
            $status                                 = $valor->status;
            if($status!=1){
                $status = 0;
                $texto = __('Desativado');
            }else{
                $status = 1;
                $texto = __('Ativado');
            }
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Visualizar' ,Array('Ver Turma'        ,$ver_url    ,'')).
                                              '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$status     ,Array($texto        ,'Curso/Turma/Status/'.$valor->id.'/'    ,'')).'</span>'.
                                              $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Turma'        ,$edit_url    ,'')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Turma'       ,$del_url     ,'Deseja realmente deletar esse Turma ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    static function Abertas_Tabela(&$turmas,$curso=false,$inscrever=true){
        if($curso==='false') $curso = false;
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($turmas)) $turmas = Array(0=>$turmas);
        reset($turmas);
        foreach ($turmas as &$valor) {
            if($curso===false || $curso==0){
                
                $tabela['Curso'][$i]   = $valor->curso2;
                $inscricao_url    = 'Curso/Turma/Inscricao_Fazer/'.$valor->id.'/';
            }else{
                $inscricao_url    = 'Curso/Turma/Inscricao_Fazer/'.$valor->id.'/'.$valor->curso.'/';
            }
            $tabela['Nome'][$i]             = $valor->nome;
            $tabela['Vagas'][$i]            = $valor->qnt;
            $tabela['Inicio'][$i]           = $valor->inicio;
            $tabela['Fim'][$i]              = $valor->fim;
            if($inscrever) $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Personalizado'     ,
                    Array('Se Inscrever'        ,$inscricao_url    ,'','hdd','success'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    static function Inscricoes_Tabela(&$inscricoes){
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($inscricoes)) $inscricoes = Array(0=>$inscricoes);
        reset($inscricoes);
        foreach ($inscricoes as &$valor) {
            $tabela['Curso'][$i]            = $valor->curso2;
            $tabela['Turma'][$i]            = $valor->turma2;
            $tabela['Aluno'][$i]           = $valor->usuario2;
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Turmas($curso=false,$export=false){
        if($curso ==='false' || $curso ===0)  $curso    = false;
        if($curso!==false){
            $curso = (int) $curso;
            if($curso==0){
                $curso_registro = $this->_Modelo->db->Sql_Select('Curso','',1,'id DESC');
                if($curso_registro===false){
                    throw new \Exception('Não existe nenhum curso:', 404);
                }
                $curso = $curso_registro->id;
            }else{
                $curso_registro = $this->_Modelo->db->Sql_Select('Curso','Cu.id='.$curso.'',1);
                if($curso_registro===false){
                    throw new \Exception('Esse Curso não existe:', 404);
                }
            }
            $where = '{sigla}curso='.$curso.'';
            self::Endereco_Turma(false, $curso_registro);
        }else{
            $where = false;
            self::Endereco_Turma(false, false);
        }
        $i = 0;
        if($curso!==false){
            $titulo_add = 'Adicionar nova Turma ao Curso: '.$curso_registro->nome;
            $url_add = '/'.$curso;
            $add_url = 'Curso/Turma/Turmas_Add/'.$curso;
        }else{
            $titulo_add = __('Adicionar nova Turma');
            $url_add = '/false';
            $add_url    = 'Curso/Turma/Turmas_Add';
        }
        $add_url = 'Curso/Turma/Turmas_Add'.$url_add;
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
                'Link'      => 'Curso/Turma/Turmas'.$url_add,
            )
        )));
        $turmas = $this->_Modelo->db->Sql_Select('Curso_Turma',$where);
        if($curso!==false){
            $titulo = 'Listagem de Turmas: '.$curso_registro->nome;
        }else{
            $titulo = __('Listagem de Turmas em Todos os Cursos');
        }
        if($turmas!==false && !empty($turmas)){
            list($tabela,$i) = self::Turmas_Tabela($turmas,$curso);
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
            if($curso!==false){
                $erro = __('Nenhuma Turma nesse Curso');
            }else{
                $erro = __('Nenhuma Turma nos Cursos');
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
     * @version 3.1.1
     */
    public function Abertas($curso=false,$export=false){
        if($curso ==='false' || $curso ===0)  $curso    = false;
        if($curso!==false){
            $curso = (int) $curso;
            if($curso==0){
                $curso_registro = $this->_Modelo->db->Sql_Select('Curso',Array(),1,'id DESC');
                if($curso_registro===false){
                    throw new \Exception('Não existe nenhum curso:', 404);
                }
                $curso = $curso_registro->id;
            }else{
                $curso_registro = $this->_Modelo->db->Sql_Select('Curso',Array('id'=>$curso),1);
                if($curso_registro===false){
                    throw new \Exception('Esse Curso não existe:', 404);
                }
            }
            $where = '{sigla}qnt>0 AND {sigla}curso='.$curso.' AND {sigla}inicio>=\''.APP_DATA.'\'';
            self::Endereco_Aberta(false, $curso_registro);
        }else{
            $where = '{sigla}qnt>0 AND {sigla}inicio>=\''.APP_DATA.'\'';
            self::Endereco_Aberta(false, false);
        }
        $i = 0;
        if($curso!==false){
            $url_add = '/'.$curso;
        }else{
            $url_add = '/false';
        }
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Curso/Turma/Turmas'.$url_add,
            )
        )));
        $turmas = $this->_Modelo->db->Sql_Select('Curso_Turma',$where);
        if($curso!==false){
            $titulo = 'Listagem de Turmas: '.$curso_registro->nome;
        }else{
            $titulo = __('Listagem de Turmas em Todos os Cursos');
        }
        if($turmas!==false && !empty($turmas)){
            list($tabela,$i) = self::Abertas_Tabela($turmas,$curso);
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
            if($curso!==false){
                $erro = __('Nenhuma Turma com inscrição aberta nesse Curso');
            }else{
                $erro = __('Nenhuma Turma com inscrição aberta');
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
     * @version 3.1.1
     */
    public function Turmas_Add($curso = false){
        if($curso==='false') $curso = false;
        // Carrega Config
        $formid     = 'form_Sistema_Admin_Turmas';
        $formbt     = __('Salvar');
        $campos     = Curso_Turma_DAO::Get_Colunas();
        if($curso===false){
            $formlink   = 'Curso/Turma/Turmas_Add2';
            $titulo1    = __('Adicionar Turma');
            $titulo2    = __('Salvar Turma');
            self::Endereco_Turma(true, false);
        }else{
            $curso = (int) $curso;
            if($curso==0){
                $curso_registro = $this->_Modelo->db->Sql_Select('Curso',Array(),1,'id DESC');
                if($curso_registro===false){
                    throw new \Exception('Não existe nenhuma curso:', 404);
                }
                $curso = $curso_registro->id;
            }else{
                $curso_registro = $this->_Modelo->db->Sql_Select('Curso',Array('id'=>$curso),1);
                if($curso_registro===false){
                    throw new \Exception('Esse Curso não existe:', 404);
                }
            }
            $formlink   = 'Curso/Turma/Turmas_Add2/'.$curso;
            self::DAO_Campos_Retira($campos,'curso');
            $titulo1    = 'Adicionar Turma de '.$curso_registro->nome ;
            $titulo2    = 'Salvar Turma de '.$curso_registro->nome ;
            self::Endereco_Turma(true, $curso_registro);
        }
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * Retorno de Add Turma
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Turmas_Add2($curso=false){
        if($curso==='false') $curso = false;
        $titulo     = __('Turma Adicionada com Sucesso');
        $dao        = 'Curso_Turma';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Turma cadastrada com sucesso.');
        if($curso===false){
            $funcao     = '$this->Turmas(0);';
            $alterar    = Array();
        }else{
            $curso = (int) $curso;
            $alterar    = Array('curso'=>$curso);
            $funcao     = '$this->Turmas('.$curso.');';
        }
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Turmas_Ver($id,$curso = false,$export=false){
        if($curso==='false') $curso = false;
        if($id===false){
            throw new \Exception('Turma não existe:'. $id, 404);
        }
        $id         = (int) $id;
        
        // Carrega Turma
        $turma_registro = $this->_Modelo->db->Sql_Select('Curso_Turma','{sigla}id=\''.$id.'\'',1);
        if($turma_registro===false){
            throw new \Exception('Essa Turma não existe:', 404);
        }
        
        // Carrega Curso
        if($curso!==false){
            $curso    = (int) $curso;
            // Carrega Turma
            $curso_registro = $this->_Modelo->db->Sql_Select('Curso','{sigla}id=\''.$id.'\'',1);
            if($curso_registro===false){
                throw new \Exception('Esse Curso não existe:', 404);
            }
            self::Endereco_Turma_Ver(false,$turma_registro,$curso_registro);
        }else{
            self::Endereco_Turma_Ver(false,$turma_registro,false);
        }
        $inscricoes = $this->_Modelo->db->Sql_Select('Curso_Turma_Inscricao','{sigla}turma=\''.$id.'\'');
        $titulo = 'Visualização da Turma: '.$turma_registro->nome;
        $i = 0;
        if($inscricoes!==false && !empty($inscricoes)){
            list($tabela,$i) = self::Inscricoes_Tabela($inscricoes);
            $titulo = $titulo.' ('.$i.')';
            if($export!==false){
                self::Export_Todos($export,$tabela, $titulo);
            }else{
                $html = $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    false,        // true -> Add ao Bloco, false => Retorna html
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
            $erro = __('Nenhuma Inscrição nessa Turma');     
            $html = '<center><b><font color="#FF0000" size="5">'.$erro.'</font></b></center>';
        }
        
        
        // Identifica tipo e cria conteudo
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Propostas_Biblioteca')===true && \Framework\App\Sistema_Funcoes::Perm_Modulos('biblioteca')===true){

            $this->_Visual->Bloco_Customizavel(Array(
                Array(
                    'span'      =>      5,
                    'conteudo'  =>  Array(Array(
                        'div_ext'   =>      false,
                        'title_id'  =>      false,
                        'title'     =>      $titulo.' #'.$turma_registro->id,
                        'html'      =>      $html,
                    ),),
                ),
                Array(
                    'span'      =>      7,
                    'conteudo'  =>  Array(Array(
                        'div_ext'   =>      false,
                        'title_id'  =>      false,
                        'title'     =>      'Pasta da '.$titulo.' #'.$turma_registro->id.' na Biblioteca',
                        'html'      =>      '<span id="Curso_Turma_'.$turma_registro->id.'">'.biblioteca_BibliotecaControle::Biblioteca_Dinamica('Curso_Turma',$turma_registro->id,'Curso_Turma_'.$turma_registro->id).'</span>',
                    )),
                )
            ));
        }else{
            $this->_Visual->Blocar($html);
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }
        
        
        
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo',$titulo);
        
        
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Turmas_Edit($id,$curso = false){
        if($curso==='false') $curso = false;
        if($id===false){
            throw new \Exception('Turma não existe:'. $id, 404);
        }
        $id         = (int) $id;
        if($curso!==false){
            $curso    = (int) $curso;
        }
        // Carrega Config
        $titulo1    = 'Editar Turma (#'.$id.')';
        $titulo2    = __('Alteração de Turma');
        $formid     = 'form_Sistema_AdminC_TurmaEdit';
        $formbt     = __('Alterar Turma');
        $campos = Curso_Turma_DAO::Get_Colunas();
        if($curso!==false){
            $curso_registro = $this->_Modelo->db->Sql_Select('Curso',Array('id'=>$curso),1);
            if($curso_registro===false){
                throw new \Exception('Esse Curso não existe:', 404);
            }
            $formlink   = 'Curso/Turma/Turmas_Edit2/'.$id.'/'.$curso;
            self::DAO_Campos_Retira($campos,'curso');
            self::Endereco_Turma(true, $curso_registro);
        }else{
            $formlink   = 'Curso/Turma/Turmas_Edit2/'.$id;
            self::Endereco_Turma(true, false);
        }
        $editar     = Array('Curso_Turma',$id);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * Retorno de Editar Turma
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Turmas_Edit2($id,$curso = false){
        if($curso==='false') $curso = false;
        if($id===false){
            throw new \Exception('Turma não existe:'. $id, 404);
        }
        $id         = (int) $id;
        if($curso!==false){
            $curso    = (int) $curso;
        }
        $titulo     = __('Turma Editada com Sucesso');
        $dao        = Array('Curso_Turma',$id);
        if($curso!==false){
            $funcao     = '$this->Turmas('.$curso.');';
        }else{
            $funcao     = '$this->Turmas();';
        }
        $sucesso1   = __('Turma Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * Deletar Turma
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Turmas_Del($id = false,$curso=false){
        if($curso==='false') $curso = false;
        if($id===false){
            throw new \Exception('Turma não existe:'. $id, 404);
        }
        // Antiinjection
    	$id = (int) $id;
        if($curso!==false){
            $curso    = (int) $curso;
            $where = Array('curso'=>$curso,'id'=>$id);
        }else{
            $where = Array('id'=>$id);
        }
        // Puxa album e deleta
        $album = $this->_Modelo->db->Sql_Select('Curso_Turma', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($album);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Turma deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Recupera Turmas
        if($curso!==false){
            $this->Turmas($curso);
        }else{
            $this->Turmas();
        }
        
        $this->_Visual->Json_Info_Update('Titulo', __('Turma deletada com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    public function Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Curso_Turma', Array('id'=>$id),1);
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
                $texto = __('Ativado');
            }else{
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Curso/Turma/Status/'.$resultado->id.'/'    ,''))
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
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    protected static function Campos_Deletar_Inscricao(&$campos){
        self::DAO_Campos_Retira($campos, 'usuario');
        self::DAO_Campos_Retira($campos, 'valor');
        self::DAO_Campos_Retira($campos, 'pago');
        self::DAO_Campos_Retira($campos, 'curso');
        self::DAO_Campos_Retira($campos, 'turma');
    }
    public function Inscricao_Fazer($id,$curso = false){
        if($curso==='false') $curso = false;
        if($id===false){
            throw new \Exception('Turma não existe:'. $id, 404);
        }
        $id         = (int) $id;
        
        $this->_Visual->Blocar('Ao Continuar Você Concorda com os temos abaixo:<br><br>Regras sobe Cancelamento e Transferência de Curso:
            <br><br>


    Cancelamento de inscrição em até 60 (sessenta) dias de antecedência ao curso: o aluno poderá transferir a sua inscrição para outra data disponível, somente.<br>
    Cancelamento de inscrição entre 60(sessenta) e 30(trinta) dias de antecedência ao curso: o aluno poderá transferir sua inscrição para outra data disponível ou cancelar participação com 25% (vinte e cinco) de multa.<br>
    Cancelamento de inscrição entre 30(trinta) e 15(quinze) dias de antecedência ao curso: o aluno poderá transferir sua inscrição para outra data disponível ou cancelar participação com 50% (vinte e cinco) de multa.<br>
    Cancelamento de inscrição em até 15 dias de antecedência ao curso: o aluno perderá o direito à inscrição, sem ressarcimento.');
        
        if($curso!==false){
            $curso    = (int) $curso;
            self::Endereco_Aberta(true, $curso);
            $turma_registro = $this->_Modelo->db->Sql_Select('Curso_Turma',Array('id'=>$curso),1);
            if($turma_registro===false){
                throw new \Exception('Essa Turma não existe nesse Curso:', 404);
            }
            $formlink   = 'Curso/Turma/Inscricao_Fazer2/'.$id;
        }else{
            self::Endereco_Aberta(true, false);
            $turma_registro = $this->_Modelo->db->Sql_Select('Curso_Turma',false,1);
            if($turma_registro===false){
                throw new \Exception('Essa Turma não existe:', 404);
            }
            $formlink   = 'Curso/Turma/Inscricao_Fazer2/'.$id;
        }
        
        // Verifica Vagas
        if($turma_registro->qnt<=0){
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Sem Vagas'),
                "mgs_secundaria"    => 'Não possui mais vagas nessa Turma! :('
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);
            $this->layoult_zerar = false; 
            return false;
        }
        
        // Inscricao Verifica se ja tem
        $usuarioid  = $this->_Acl->Usuario_GetID();
        $insc_registro = $this->_Modelo->db->Sql_Select('Curso_Turma_Inscricao','{sigla}usuario=\''.$usuarioid.'\' && {sigla}turma=\''.$turma_registro->curso.'\'',1);
        if($insc_registro!==false){
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => 'Você já está matriculado nessa turma! :('
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);
            $this->layoult_zerar = false; 
            return false;
        }
        
        
         // Carrega Config
        $titulo1    = __('Confirmar Inscrição');
        $titulo2    = __('Confirmar Inscrição');
        $formid     = 'form_Curso_Turma_Incricao_Fazer';
        $formbt     = __('Confirmar Inscrição');
        $campos = Curso_Turma_Inscricao_DAO::Get_Colunas();
        self::Campos_Deletar_Inscricao($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    
        
    }
    public function Inscricao_Fazer2($id,$curso = false){
        if($curso==='false') $curso = false;
        if($id===false){
            throw new \Exception('Turma não existe:'. $id, 404);
        }
        $id         = (int) $id;
        $usuarioid  = $this->_Acl->Usuario_GetID();
        $usuarionome  = $this->_Acl->Usuario_GetNome();
        $usuarioemail  = $this->_Acl->Usuario_GetEmail();
        
        // Carrega Turma
        $turma_registro = $this->_Modelo->db->Sql_Select('Curso_Turma','{sigla}id=\''.$id.'\'',1);
        if($turma_registro===false){
            throw new \Exception('Essa Turma não existe:', 404);
        }
        
        if($curso!==false){
            $curso    = (int) $curso;
            self::Endereco_Aberta(true, $curso);
        }else{
            self::Endereco_Aberta(true, false);
        }
        $curso_registro = $this->_Modelo->db->Sql_Select('Curso','{sigla}id=\''.$turma_registro->curso.'\'',1);
        if($curso_registro===false){
            throw new \Exception('Esse Curso não existe', 404);
        }
        
        
        
        // Inscricao Verifica se ja tem
        $insc_registro = $this->_Modelo->db->Sql_Select('Curso_Turma_Inscricao','{sigla}usuario=\''.$usuarioid.'\' && {sigla}turma=\''.$turma_registro->id.'\'',1);
        if($insc_registro!==false){
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => 'Você já está matriculado nessa turma! :('
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);
            $this->layoult_zerar = false; 
            return false;
        }
        
        
        
        // Verifica Vagas
        if($turma_registro->qnt<=0){
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Sem Vagas'),
                "mgs_secundaria"    => 'Não possui mais vagas nessa Turma! :('
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);
            $this->layoult_zerar = false; 
            return false;
        }
        
        
        
        $titulo     = __('Inscrição Confirmada com Sucesso');
        $dao        = 'Curso_Turma_Inscricao';
        $funcao     = false;
        $sucesso1   = __('Inscrição bem sucedida');
        $sucesso2   = __('Inscrição Confirmada com Sucesso');
        $alterar    = Array('usuario'=>$usuarioid,'valor'=>$curso_registro->valor,'curso'=>$turma_registro->curso,'turma'=>$turma_registro->id);
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        if($sucesso===true){
            $motivo = 'Curso';
            $identificador  = $this->_Modelo->db->Sql_Select('Curso_Turma_Inscricao', false,1,'id DESC');
            $identificador  = $identificador->id;
            
            // Diminui Vagas da Turma e Salva
            $turma_registro->qnt = $turma_registro->qnt-1;
            $this->_Modelo->db->Sql_Update($turma_registro);

            /*
             * TRABALHA PARCELAS DO FINANCEIRO
             */
            // Passa tudo pra Contas a Receber
            Financeiro_PagamentoControle::Condicao_GerarPagamento(
                \anti_injection($_POST["condicao_pagar"]),    // Condição de Pagamento
                $motivo,                                      // Motivo
                $identificador,                               // MotivoID
                'Usuario',                                    // Entrada_Motivo
                $usuarioid,                                   // Entrada_MotivoID
                'Servidor',                                   // Saida_Motivo
                SRV_NAME_SQL,                                 // Saida_MotivoID
                $curso_registro->valor,             // Valor
                APP_DATA_BR // Data Inicial
                //(int) $_POST["categoria"]                     // Categoria
            );
            
            // Envia Email pro Sistema
            $texto =    'Nova Inscrição na Turma: '.$turma_registro->nome.'<br>'.
                        'Id do Aluno: #'.$usuarioid.'<br>';
                        'Nome do Aluno: '.$usuarionome.'<br>';
                        'Email do Aluno: '.$usuarioemail.'<br>';
            self::Enviar_Email($texto, $sucesso2);
            // Envia Email pro Usuario
            $texto =    'Nova Inscrição na Turma '.$turma_registro->nome.' confirmada com sucesso.<br>'.
                        'Valor da Inscrição: '.$curso_registro->valor.'<br>'.
                        '<a target="_BLANK" href="'.SISTEMA_URL.SISTEMA_DIR.'Financeiro/Usuario/Pagar">Clique para Acessar a área de pagamento.</a><br>';
            self::Enviar_Email($texto, $sucesso2,$usuarioemail,$usuarionome);
        }
        
        
        \Framework\App\Sistema_Funcoes::Redirect('Financeiro/Usuario/Pagar');
        
        //$this->Abertas($curso);
    }
    public function Inscricao_Mover($inscricao,$turma,$curso = false){
        if($curso==='false') $curso = false;
        if($id===false){
            throw new \Exception('Turma não existe:'. $id, 404);
        }
        $id         = (int) $id;
        if($curso!==false){
            $curso    = (int) $curso;
            self::Endereco_Aberta(true, $curso);
        }else{
            self::Endereco_Aberta(true, false);
        }
        
    }
    public function Inscricao_Mover2($inscricao,$turma,$curso = false){
        if($curso==='false') $curso = false;
        if($id===false){
            throw new \Exception('Turma não existe:'. $id, 404);
        }
        $id         = (int) $id;
        if($curso!==false){
            $curso    = (int) $curso;
        }
        
    }
}
?>
