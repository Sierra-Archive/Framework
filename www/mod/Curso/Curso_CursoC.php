<?php
class Curso_CursoControle extends Curso_Controle
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
    * @uses curso_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Curso/Curso/Cursos');
        return false;
    }
    static function Endereco_Curso($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Cursos','Curso/Curso/Cursos');
        }else{
            $_Controle->Tema_Endereco('Cursos');
        }
    }
    static function Cursos_Tabela(&$cursos){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        
        $tabela = Array();
        $i = 0;
        if(is_object($cursos)) $cursos = Array(0=>$cursos);
        reset($cursos);
        foreach ($cursos as &$valor) {
            $tabela['Nome do Curso'][$i]            =   $valor->nome;
            
            $tabela['Custo'][$i]                    =   $valor->valor;
            $tabela['Data Cadastrada'][$i]          =   $valor->log_date_add;
            $status                                 = $valor->status;
            if($status!=1){
                $status = 0;
                $texto = 'Desativado';
            }else{
                $status = 1;
                $texto = 'Ativado';
            }
            $tabela['Status'][$i]                   = '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$status     ,Array($texto        ,'Curso/Curso/Status/'.$valor->id.'/'    ,'')).'</span>';
            $tabela['Funções'][$i]                  =   $Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar Turmas do Curso'    ,'Curso/Turma/Turmas/'.$valor->id.'/'    ,'')).
                                                        $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Curso'        ,'Curso/Curso/Cursos_Edit/'.$valor->id.'/'    ,'')).
                                                        $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Curso'       ,'Curso/Curso/Cursos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Curso ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cursos($export=false){
        self::Endereco_Curso(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Curso',
                'Curso/Curso/Cursos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Curso/Curso/Cursos',
            )
        )));
        $cursos = $this->_Modelo->db->Sql_Select('Curso');
        if($cursos!==false && !empty($cursos)){
            list($tabela,$i) = self::Cursos_Tabela($cursos);
            
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Cursos');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Curso</font></b></center>');
        }
        $titulo = 'Listagem de Cursos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Cursos');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cursos_Add(){
        self::Endereco_Curso();
        // Carrega Config
        $titulo1    = 'Adicionar Curso';
        $titulo2    = 'Salvar Curso';
        $formid     = 'form_Sistema_Admin_Cursos';
        $formbt     = 'Salvar';
        $formlink   = 'Curso/Curso/Cursos_Add2/';
        $campos = Curso_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cursos_Add2(){
        $titulo     = 'Curso Adicionado com Sucesso';
        $dao        = 'Curso';
        $funcao     = '$this->Cursos();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Curso cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cursos_Edit($id){
        self::Endereco_Curso();
        // Carrega Config
        $titulo1    = 'Editar Curso (#'.$id.')';
        $titulo2    = 'Alteração de Curso';
        $formid     = 'form_Sistema_AdminC_CursoEdit';
        $formbt     = 'Alterar Curso';
        $formlink   = 'Curso/Curso/Cursos_Edit2/'.$id;
        $editar     = Array('Curso',$id);
        $campos = Curso_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cursos_Edit2($id){
        $titulo     = 'Curso Editado com Sucesso';
        $dao        = Array('Curso',$id);
        $funcao     = '$this->Cursos();';
        $sucesso1   = 'Curso Alterado com Sucesso.';
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
    public function Cursos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa curso e deleta
        $curso = $this->_Modelo->db->Sql_Select('Curso', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($curso);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Curso deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Cursos();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Curso deletado com Sucesso');
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    public function Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Curso', Array('id'=>$id),1);
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
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Curso/Curso/Status/'.$resultado->id.'/'    ,''))
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
