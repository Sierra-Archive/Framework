<?php
class usuario_social_CaracteristicaControle extends usuario_social_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_social_rede_PerfilModelo::Carrega Rede Modelo
    * @uses usuario_social_rede_PerfilVisual::Carrega Rede Visual
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
    * @uses usuario_social_Controle::$acoesPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        return false; 
    }
    static function Endereco_Caracteristica($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Caracteristicas','usuario_social/Caracteristica/Caracteristica');
        }else{
            $_Controle->Tema_Endereco('Caracteristicas');
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caracteristica($export=false){
        self::Endereco_Caracteristica(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Caracteristica',
                'usuario_social/Caracteristica/Caracteristicas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario_social/Caracteristica/Caracteristicas',
            )
        )));
        $caracteristicas = $this->_Modelo->db->Sql_Select('Usuario_Social_Caracteristica');
        if($caracteristicas!==false && !empty($caracteristicas)){
            if(is_object($caracteristicas)) $caracteristicas = Array(0=>$caracteristicas);
            reset($caracteristicas);
            foreach ($caracteristicas as $indice=>&$valor) {
                $tabela['Nome'][$i]            = $valor->nome;
                $tabela['Descriçao'][$i]        = $valor->descricao;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Caracteristica'        ,'usuario_social/Caracteristica/Caracteristicas_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Caracteristica'       ,'usuario_social/Caracteristica/Caracteristicas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Caracteristica ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Caracteristicas');
            }else{
                $Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    true,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Caracteristica</font></b></center>');
        }
        $titulo = 'Listagem de Caracteristicas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Caracteristicas');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caracteristicas_Add(){
        self::Endereco_Caracteristica(true);
        // Carrega Config
        $titulo1    = 'Adicionar Caracteristica';
        $titulo2    = 'Salvar Caracteristica';
        $formid     = 'form_Sistema_Caracteristica_Caracteristicas';
        $formbt     = 'Salvar';
        $formlink   = 'usuario_social/Caracteristica/Caracteristicas_Add2/';
        $campos = Usuario_Social_Caracteristica_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caracteristicas_Add2(){
        $titulo     = 'Caracteristica adicionada com Sucesso';
        $dao        = 'Usuario_Social_Caracteristica';
        $funcao     = '$this->Caracteristica();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Caracteristica cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caracteristicas_Edit($id){
        self::Endereco_Caracteristica(true);
        // Carrega Config
        $titulo1    = 'Editar Caracteristica (#'.$id.')';
        $titulo2    = 'Alteração de Caracteristica';
        $formid     = 'form_Sistema_CaracteristicaC_CaracteristicaEdit';
        $formbt     = 'Alterar Caracteristica';
        $formlink   = 'usuario_social/Caracteristica/Caracteristicas_Edit2/'.$id;
        $editar     = Array('Usuario_Social_Caracteristica',$id);
        $campos = Usuario_Social_Caracteristica_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Caracteristicas_Edit2($id){
        $titulo     = 'Caracteristica editada com Sucesso';
        $dao        = Array('Usuario_Social_Caracteristica',$id);
        $funcao     = '$this->Caracteristica();';
        $sucesso1   = 'Caracteristica Alterado com Sucesso.';
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
    public function Caracteristicas_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Social_Caracteristica', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletada',
                "mgs_secundaria" => 'Caracteristica deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Caracteristica();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Caracteristica deletada com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
