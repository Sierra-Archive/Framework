<?php
class social_PersonaControle extends social_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses social_rede_PerfilModelo::Carrega Rede Modelo
    * @uses social_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses social_Controle::$acoesPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        return false;
    }
    protected static function Endereco_Persona($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Personas','social/Persona/Personas');
        }else{
            $_Controle->Tema_Endereco('Personas');
        }
    }
    protected static function Endereco_Persona_Ver($persona,$true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        self::Endereco_Persona();
        if($true===true){
            $_Controle->Tema_Endereco($persona->nome,'social/Persona/Personas_View/'.$persona->id);
        }else{
            $_Controle->Tema_Endereco($persona->nome);
        }
    }
    protected static function Endereco_Persona_Ver_Ficar($persona,$true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        self::Endereco_Persona_Ver($persona);
        if($true===true){
            $_Controle->Tema_Endereco($persona->nome,'social/Persona/Personas_View/'.$persona->id);
        }else{
            $_Controle->Tema_Endereco($persona->nome);
        }
    }
    protected static function Endereco_Persona_Ver_Ficar_Ver($persona,$ficada,$true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        self::Endereco_Persona_Ver_Ficar($persona);
        if($true===true){
            $_Controle->Tema_Endereco($ficada->nome,'social/Persona/Personas_View/'.$persona->id);
        }else{
            $_Controle->Tema_Endereco($ficada->nome);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas($export=false){
        self::Endereco_Persona(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Pessoa',
                'social/Persona/Personas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'social/Persona/Personas',
            )
        )));
        $personas = $this->_Modelo->db->Sql_Select('Social');
        if($personas!==false && !empty($personas)){
            if(is_object($personas)) $personas = Array(0=>$personas);
            reset($personas);
            foreach ($personas as $indice=>&$valor) {
                    if($valor->id_face!=0){
                        $face = '<a href="http://www.facebook.com/profile.php?id='.$valor->id_face.'" target="_blank" alt="'.$valor->id_face.'"><img src="http://graph.facebook.com/'.$valor->id_face.'/picture"></a>';
                    }else{
                        $face = 'Sem foto';
                    }
                    if($valor->perfil_sexo!=0){
                        $sexo = 'Masculino';
                    }else{
                        $sexo = 'Feminino';
                    }
                $tabela['Foto'][$i]             = $face;
                $tabela['Nome'][$i]             = $valor->nome;
                $tabela['Sexo'][$i]             = $sexo;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Zoom'       ,Array('Visualizar Ficada de Pessoa'        ,'social/Persona/Personas_View/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Pessoa'        ,'social/Persona/Personas_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Pessoa'       ,'social/Persona/Personas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Pessoa ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Social - Pessoas');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Pessoa</font></b></center>');
        }
        $titulo = 'Listagem de Pessoas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Pessoas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Add(){
        self::Endereco_Persona();
        // Carrega Config
        $titulo1    = 'Adicionar Pessoa';
        $titulo2    = 'Salvar Pessoa';
        $formid     = 'SierraForm_social_Persona_Personas';
        $formbt     = 'Salvar';
        $formlink   = 'social/Persona/Personas_Add2/';
        $campos = Social_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Add2(){
        $titulo     = 'Pessoa adicionada com Sucesso';
        $dao        = 'Social';
        $funcao     = '$this->Personas();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Pessoa cadastrada com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Edit($id){
        self::Endereco_Persona();
        // Carrega Config
        $titulo1    = 'Editar Pessoa (#'.$id.')';
        $titulo2    = 'Alteração de Pessoa';
        $formid     = 'SierraForm_social_Persona_Personas';
        $formbt     = 'Alterar Pessoa';
        $formlink   = 'social/Persona/Personas_Edit2/'.$id;
        $editar     = Array('Social',$id);
        $campos = Social_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Edit2($id){
        $titulo     = 'Pessoa editada com Sucesso';
        $dao        = Array('Social',$id);
        $funcao     = '$this->Personas();';
        $sucesso1   = 'Pessoa Alterada com Sucesso.';
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
    public function Personas_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Social', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Pessoa deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Personas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Pessoa deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Personas_View($persona_id = false){
        if($persona_id===false || $persona_id==0 || !isset($persona_id)) throw new \Exception('Persona não informada',404);
        // mostra todas as suas mensagens
        $where = Array(
            'id'    =>  $persona_id,
        );
        $persona = $this->_Modelo->db->Sql_Select('Social',$where, 1);
        self::Endereco_Persona_Ver($persona,false);
        $html  = '<div class="col-6">'; 
        $html .= '<b>Nome:</b> '.$persona->nome.'<br>';  
        $html .= '<b>Sexo:</b> '.$persona->sexo; 
        $html .= '</div>';    
        $titulo = 'Informações da Persona (#'.$persona_id.')';
        $this->_Visual->Blocar('<div class="row">'.$html.'</div>');
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',20);
        
        //Comentarios, Ficou e Acoes
        $this->Personas_Comentario($persona_id,'Esquerda');
        $this->Ficou($persona_id,'Direita');
        social_AcaoControle::Acao_Stat($persona_id,'Esquerda');
        // Titulo
        $this->_Visual->Json_Info_Update('Titulo', __('Visualizar Persona'));

    }
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Comentario($persona_id = false,$tipo='Unico'){
        
        if($persona_id===false){
            $where = Array();
        }else{
            $where = Array('persona'=>$persona_id);
        }
        
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar Comentário de Persona" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'social/Persona/Personas_Comentario_Add/'.$persona_id.'">Adicionar novo comentário nesse Persona</a><div class="space15"></div>');
        $comentario = $this->_Modelo->db->Sql_Select('Social_Comentario',$where);
        if($comentario!==false && !empty($comentario)){
            if(is_object($comentario)) $comentario = Array(0=>$comentario);
            reset($comentario);
            foreach ($comentario as $indice=>&$valor) {
                $tabela['#Id'][$i]          =   '#'.$valor->id;
                $tabela['Comentário'][$i]   =   nl2br($valor->comentario);
                $tabela['Data'][$i]         =   $valor->log_date_add;
                $tabela['Funções'][$i]      =   $this->_Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Comentário de Persona'        ,'social/Persona/Personas_Comentario_Edit/'.$persona_id.'/'.$valor->id.'/'    ,'')).
                                                $this->_Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Comentário de Persona'       ,'social/Persona/Personas_Comentario_Del/'.$persona_id.'/'.$valor->id.'/'     ,'Deseja realmente deletar esse Comentário desse Persona ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela,'', true, false, Array(Array(0,'desc')));
            unset($tabela);
        }else{          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Comentário do Persona</font></b></center>');
        }
        $titulo = 'Comentários do Persona ('.$i.')';
        if($tipo=='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10);
        }else if($tipo=='Esquerda'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',10);
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo,'',10);
        }
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Comentários do Persona'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Comentario_Add($persona_id = false){
        // Proteção E chama Endereço
        if($persona_id===false) throw new \Exception('Persona não informado',404);
        $persona = $this->_Modelo->db->Sql_Select('Social',Array('id'=>$persona_id), 1);
        if($persona===false) throw new \Exception('Persona não existe:'.$persona_id,404);
        $this->Endereco_Persona_Ver($persona);
        // Começo
        $persona_id = (int) $persona_id;
        // Carrega Config
        $titulo1    = 'Adicionar Comentário de Persona';
        $titulo2    = 'Salvar Comentário de Persona';
        $formid     = 'form_Sistema_Admin_Personas_Comentario';
        $formbt     = 'Salvar';
        $formlink   = 'social/Persona/Personas_Comentario_Add2/'.$persona_id;
        $campos = Social_Comentario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'persona');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Comentario_Add2($persona_id = false){
        if($persona_id===false) throw new \Exception('Persona não informado',404);
        $titulo     = 'Comentário do Persona Adicionado com Sucesso';
        $dao        = 'Social_Comentario';
        $funcao     = '$this->Personas_View('.$persona_id.');';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Comentário de Persona cadastrado com sucesso.';
        $alterar    = Array('persona'=>$persona_id);
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Comentario_Edit($persona_id = false,$id = 0){
        if($persona_id===false) throw new \Exception('Persona não informado',404);
        if($id         == 0   ) throw new \Exception('Comentário não informado',404);
        // Proteção E chama Endereço
        $persona = $this->_Modelo->db->Sql_Select('Social',Array('id'=>$persona_id), 1);
        if($persona===false) throw new \Exception('Persona não existe:'.$persona_id,404);
        $this->Endereco_Persona_Ver($persona);
        // Começo
        // Carrega Config
        $titulo1    = 'Editar Comentário do Persona (#'.$id.')';
        $titulo2    = 'Alteração de Comentário do Persona';
        $formid     = 'form_Sistema_AdminC_PersonaEdit';
        $formbt     = 'Alterar Comentário de Persona';
        $formlink   = 'social/Persona/Personas_Comentario_Edit2/'.$persona_id.'/'.$id;
        $editar     = Array('Social_Comentario',$id);
        $campos = Social_Comentario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'persona');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Comentario_Edit2($persona_id = false,$id = 0){
        if($persona_id===false) throw new \Exception('Persona não informado',404);
        if($id         == 0   ) throw new \Exception('Comentário não informado',404);
        $titulo     = 'Comentário de Persona Editado com Sucesso';
        $dao        = Array('Social_Comentario',$id);
        $funcao     = '$this->Personas_View('.$persona_id.');';
        $sucesso1   = 'Comentário de Persona Alterado com Sucesso.';
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array('persona'=>$persona_id);
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Personas_Comentario_Del($persona_id = false,$id = 0){
        if($persona_id===false) throw new \Exception('Persona não informado',404);
        if($id         == 0   ) throw new \Exception('Comentário não informado',404);
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $where = Array('id'=>$id);
        $comentario = $this->_Modelo->db->Sql_Select('Social_Comentario', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($comentario);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Comentário do Persona Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Personas_View($persona_id);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Comentário de Persona deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Ficou($persona_id=false,$tipo='Unico'){
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar Nova Ficada" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'social/Persona/Ficou_Add/'.$persona_id.'">Adicionar Nova Ficada</a><div class="space15"></div>');
        if($persona_id===false){
            self::Endereco_Persona_Ver_Ficar(false);
            $where = Array();
        }else{
            $where = Array(Array('persona1'=>$persona_id,'persona2'=>$persona_id));
        }
        
        $personas = $this->_Modelo->db->Sql_Select('Social_Ficou',$where);
        if($personas!==false && !empty($personas)){
            if(is_object($personas)) $personas = Array(0=>$personas);
            reset($personas);
            foreach ($personas as $indice=>&$valor) {
                if($valor->persona1==$persona_id){
                    $tabela['Nome'][$i]        = $valor->persona22;
                }else if($valor->persona2==$persona_id){
                    $tabela['Nome'][$i]           = $valor->persona12;
                }else{
                    $tabela['Nome de Um'][$i]           = $valor->persona12;
                    $tabela['Nome do Outro'][$i]        = $valor->persona22;
                }
                //$tabela['Data'][$i]             = $valor->data;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Zoom'       ,Array('Visualizar Ficada de Pessoa'        ,'social/Persona/Ficou_View/'.$valor->id.'/'.$persona_id  ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Ficada de Pessoa'        ,'social/Persona/Ficou_Edit/'.$valor->id.'/'.$persona_id      ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Ficada de Pessoa'       ,'social/Persona/Ficou_Del/'.$valor->id.'/'.$persona_id       ,'Deseja realmente deletar essa Ficada de Pessoa ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{          
            $this->_Visual->Blocar('<center><b><p class="text-error">Nenhuma Ficada de Pessoa</p></b></center>');
        }
        $titulo = 'Listagem de Ficada de Pessoas ('.$i.')';
        if($tipo=='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }else if($tipo=='Esquerda'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo);
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo);
        }
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Ficada de Pessoas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Ficou_Add($persona_id=false){
        self::Endereco_Persona();
        // Carrega Config
        $titulo1    = 'Adicionar Ficada de Pessoa';
        $titulo2    = 'Salvar Ficada de Pessoa';
        $formid     = 'SierraForm_social_Persona_Ficou';
        $formbt     = 'Salvar';
        $campos = Social_Ficou_DAO::Get_Colunas();
        if($persona_id!==false){
            self::DAO_Campos_Retira($campos,'persona1');
            $formlink   = 'social/Persona/Ficou_Add2/'.$persona_id;
        }else{  
            $formlink   = 'social/Persona/Ficou_Add2/';
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
    public function Ficou_Add2($persona_id=false){        
        $persona_id = (int) $persona_id;
        $titulo     = 'Ficada de Pessoa adicionada com Sucesso';
        $dao        = 'Social_Ficou';
        if($persona_id===false){
            $funcao     = '$this->Ficou();';
            $alterar    = Array();
        }else{
            $funcao     = '$this->Personas_View('.$persona_id.');';
            $alterar    = Array('persona1'=>$persona_id);
        }
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Ficada de Pessoa cadastrada com sucesso.';
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Ficou_Edit($id,$persona_id=false){
        self::Endereco_Persona();
        // Carrega Config
        $titulo1    = 'Editar Ficada de Pessoa (#'.$id.')';
        $titulo2    = 'Alteração de Ficada de Pessoa';
        $formid     = 'SierraForm_social_Persona_Ficou';
        $formbt     = 'Alterar Pessoa';
        if($persona_id!==false){
            $formlink   = 'social/Persona/Ficou_Edit2/'.$id.'/'.$persona_id;
        }else{  
            $formlink   = 'social/Persona/Ficou_Edit2/'.$id.'/';
        }
        $editar     = Array('Social_Ficou',$id);
        $campos = Social_Ficou_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Ficou_Edit2($id,$persona_id=false){
        $titulo     = 'Ficada de Pessoa editada com Sucesso';
        $dao        = Array('Social_Ficou',$id);
        if($persona_id===false){
            $funcao     = '$this->Ficou();';
        }else{
            $funcao     = '$this->Personas_View('.$persona_id.');';
        }
        $sucesso1   = 'Ficada de Pessoa Alterada com Sucesso.';
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
    public function Ficou_Del($id,$persona_id=false){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Social_Ficou', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Ficada de Pessoa deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        if($persona_id===false){
            $this->Ficou();
        }else{
            $this->Personas_View($persona_id);
        }
        
        $this->_Visual->Json_Info_Update('Titulo', __('Pessoa deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Ficou_View($ficada_id = false, $persona_id = false){
        if($ficada_id===false || $ficada_id==0 || !isset($ficada_id)) throw new \Exception('Ficada não informada',404);
        // mostra todas as suas mensagens
        $where = Array(
            'id'    =>  $ficada_id,
        );
        self::Endereco_Persona_Ver_Ficar_Ver($ficada_id,$persona_id);
        $ficada = $this->_Modelo->db->Sql_Select('Social_Ficou',$where, 1);
        $html  = '<div class="col-sm-12">';  
        $html .= '<b>Nome 1:</b> '.$ficada->persona12.'<br>';  
        $html .= '<b>Nome 2:</b> '.$ficada->persona22.'<br>';  
        $html .= '<b>Observação:</b> '.$ficada->obs; 
        $html .= '</div>';    
        if($persona_id===false){
            $titulo = 'Informações da Ficada (#'.$ficada_id.')';
            $this->Ficou_Comentario($ficada_id);
        }else{
            $where = Array(
                'id'    =>  $persona_id,
            );
            $persona = $this->_Modelo->db->Sql_Select('Social',$where, 1);
            $titulo = 'Informações da Ficada de '.$persona->nome.' (#'.$ficada_id.')';
            $this->Ficou_Comentario($ficada_id,$persona_id);
        }
        $this->_Visual->Blocar('<div class="row">'.$html.'</div>');
        $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',20);
        $this->_Visual->Json_Info_Update('Titulo',$titulo);
    }
    /**
     * Comentarios dos Ficou
     */
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Ficou_Comentario($ficada_id = false, $export = false){
        if($ficada_id===false){
            $where = Array();
        }else{
            $where = Array('ficada'=>$ficada_id);
        }
        
        $i = 0;
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Comentário de Ficada',
                'social/Persona/Ficou_Comentario_Add/'.$ficada_id,
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'social/Persona/Ficou_Comentario/'.$ficada_id,
            )
        )));
        $comentario = $this->_Modelo->db->Sql_Select('Social_Ficou_Comentario',$where);
        if($comentario!==false && !empty($comentario)){
            if(is_object($comentario)) $comentario = Array(0=>$comentario);
            reset($comentario);
            foreach ($comentario as $indice=>&$valor) {
                //$tabela['#Id'][$i]        = '#'.$valor->id;
                $tabela['Comentário'][$i]   =   $valor->comentario;
                $tabela['Data'][$i]         =   $valor->log_date_add;
                $tabela['Funções'][$i]      =   $this->_Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Comentário de Persona'        ,'social/Persona/Ficou_Comentario_Edit/'.$ficada_id.'/'.$valor->id.'/'    ,'')).
                                                $this->_Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Comentário de Persona'       ,'social/Persona/Ficou_Comentario_Del/'.$ficada_id.'/'.$valor->id.'/'     ,'Deseja realmente deletar esse Comentário?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Usuario Social - Ficada (#'.$ficada_id.') Comentários');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Comentário</font></b></center>');
        }
        $titulo = 'Comentários ('.$i.')';
        $this->_Visual->Bloco_Menor_CriaJanela($titulo,'',10);
        
        //Carrega Json
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Ficou_Comentario_Add($ficada_id = false){
        // Proteção E chama Endereço
        if($ficada_id===false) throw new \Exception('Ficada não informada',404);
        $ficada_id = (int) $ficada_id;
        $ficada = $this->_Modelo->db->Sql_Select('Social_Ficou',Array('id'=>$ficada_id), 1);
        if($ficada===false) throw new \Exception('Ficada não existe:'.$ficada_id,404);
        
        self::Endereco_Persona_Ver_Ficar_Ver($ficada);
        // Carrega Config
        $titulo1    = 'Adicionar Comentário de Ficada';
        $titulo2    = 'Salvar Comentário de Ficada';
        $formid     = 'SierraForm_social_Persona_Ficou_Comentario';
        $formbt     = 'Salvar';
        $formlink   = 'social/Persona/Ficou_Comentario_Add2/'.$ficada_id;
        $campos = Social_Ficou_Comentario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'ficada');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Ficou_Comentario_Add2($ficada_id = false){
        if($ficada_id===false) throw new \Exception('Ficada não informada',404);
        $titulo     = 'Comentário do Ficada Adicionada com Sucesso';
        $dao        = 'Social_Ficou_Comentario';
        $funcao     = '$this->Ficou_View('.$ficada_id.');';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Comentário de Ficada cadastrada com sucesso.';
        $alterar    = Array('ficada'=>$ficada_id);
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Ficou_Comentario_Edit($ficada_id = false,$id = 0){
        if($ficada_id===false) throw new \Exception('Ficada não informada',404);
        if($id         == 0   ) throw new \Exception('Comentário não informado',404);
        // Proteção E chama Endereço
        $ficada = $this->_Modelo->db->Sql_Select('Social_Ficou',Array('id'=>$ficada_id), 1);
        if($ficada===false) throw new \Exception('Ficada não existe:'.$ficada_id,404);
        
        self::Endereco_Persona_Ver_Ficar_Ver();
        // Começo
        // Carrega Config
        $titulo1    = 'Editar Comentário de Ficada (#'.$id.')';
        $titulo2    = 'Alteração de Comentário do Ficada';
        $formid     = 'SierraForm_social_Persona_Ficou_Comentario';
        $formbt     = 'Alterar Comentário de Ficada';
        $formlink   = 'social/Persona/Ficou_Comentario_Edit2/'.$persona_id.'/'.$id;
        $editar     = Array('Social_Ficou_Comentario',$id);
        $campos = Social_Ficou_Comentario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'ficada');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Ficou_Comentario_Edit2($ficada_id = false,$id = 0){
        if($ficada_id===false)  throw new \Exception('Ficada não informada',404);
        if($id         == 0   ) throw new \Exception('Comentário não informado',404);
        $titulo     = 'Comentário de Ficada Editada com Sucesso';
        $dao        = Array('Social_Ficou_Comentario',$id);
        $funcao     = '$this->Ficou_View('.$persona_id.');';
        $sucesso1   = 'Comentário de Ficada Alterada com Sucesso.';
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array('ficada'=>$persona_id);
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Ficou_Comentario_Del($ficada_id = false,$id = 0){
        if($ficada_id===false)  throw new \Exception('Ficada não informada',404);
        if($id         == 0   ) throw new \Exception('Comentário não informado',404);
        global $language;
    	$id = (int) $id;
        // Puxa linha e deleta
        $where = Array('id'=>$id);
        $comentario = $this->_Modelo->db->Sql_Select('Social_Ficou_Comentario', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($comentario);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Comentário do Ficada Deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Ficou_View($ficada_id);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Comentário de Ficada deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
