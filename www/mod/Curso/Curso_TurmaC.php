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
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Curso/Turma/Turmas');
        return false;
    }
    static function Endereco_Turma($true=true,$curso=false){
        if($curso==='false') $curso = false;
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($curso===false){
            $titulo = 'Todos os Turmas';
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
    static function Turmas_Tabela(&$albuns,$curso=false){
        if($curso==='false') $curso = false;
        $registro   = \Framework\App\Registro::getInstacia();
        $Modelo     = &$registro->_Modelo;
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($albuns)) $albuns = Array(0=>$albuns);
        reset($albuns);
        foreach ($albuns as &$valor) {
            if($curso===false || $curso==0){
                
                $tabela['Curso'][$i]   = $valor->curso2;
                $edit_url   = 'Curso/Turma/Turmas_Edit/'.$valor->id.'/';
                $del_url    = 'Curso/Turma/Turmas_Del/'.$valor->id.'/';
            }else{
                $edit_url   = 'Curso/Turma/Turmas_Edit/'.$valor->id.'/'.$valor->curso.'/';
                $del_url    = 'Curso/Turma/Turmas_Del/'.$valor->id.'/'.$valor->curso.'/';
            }
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
            $tabela['Funções'][$i]          = '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$status     ,Array($texto        ,'Curso/Turma/Status/'.$valor->id.'/'    ,'')).'</span>'.
                                              $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Turma'        ,$edit_url    ,'')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Turma'       ,$del_url     ,'Deseja realmente deletar esse Turma ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Turmas($curso=false,$export=false){
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
            $where = Array(
                'curso'   => $curso,
            );
            self::Endereco_Turma(false, $curso_registro);
        }else{
            $where = Array();
            self::Endereco_Turma(false, false);
        }
        $i = 0;
        if($curso!==false){
            $titulo_add = 'Adicionar novo Turma ao Curso: '.$curso_registro->nome;
            $url_add = '/'.$curso;
            $add_url = 'Curso/Turma/Turmas_Add/'.$curso;
        }else{
            $titulo_add = 'Adicionar novo Turma';
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
        $albuns = $this->_Modelo->db->Sql_Select('Curso_Turma',$where);
        if($curso!==false){
            $titulo = 'Listagem de Turmas: '.$curso_registro->nome;
        }else{
            $titulo = 'Listagem de Turmas em Todos os Cursos';
        }
        if($albuns!==false && !empty($albuns)){
            list($tabela,$i) = self::Turmas_Tabela($albuns,$curso);
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
                $erro = 'Nenhuma Turma nesse Curso';
            }else{
                $erro = 'Nenhuma Turma nos Cursos';
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
    public function Turmas_Add($curso = false){
        if($curso==='false') $curso = false;
        // Carrega Config
        $formid     = 'form_Sistema_Admin_Turmas';
        $formbt     = 'Salvar';
        $campos     = Curso_Turma_DAO::Get_Colunas();
        if($curso===false){
            $formlink   = 'Curso/Turma/Turmas_Add2';
            $titulo1    = 'Adicionar Turma';
            $titulo2    = 'Salvar Turma';
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
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Turmas_Add2($curso=false){
        if($curso==='false') $curso = false;
        $titulo     = 'Turma Adicionada com Sucesso';
        $dao        = 'Curso_Turma';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Turma cadastrada com sucesso.';
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
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
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
        $titulo2    = 'Alteração de Turma';
        $formid     = 'form_Sistema_AdminC_TurmaEdit';
        $formbt     = 'Alterar Turma';
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
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
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
        $titulo     = 'Turma Editada com Sucesso';
        $dao        = Array('Curso_Turma',$id);
        if($curso!==false){
            $funcao     = '$this->Turmas('.$curso.');';
        }else{
            $funcao     = '$this->Turmas();';
        }
        $sucesso1   = 'Turma Alterada com Sucesso.';
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
    public function Turmas_Del($id = false,$curso=false){
        if($curso==='false') $curso = false;
        global $language;
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
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Turma deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Recupera Turmas
        if($curso!==false){
            $this->Turmas($curso);
        }else{
            $this->Turmas();
        }
        
        $this->_Visual->Json_Info_Update('Titulo', 'Turma deletada com Sucesso');
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
                $texto = 'Ativado';
            }else{
                $texto = 'Desativado';
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Curso/Turma/Status/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo','Status Alterado'); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo','Erro'); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
