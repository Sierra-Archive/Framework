<?php
class social_AcaoControle extends social_Controle
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
    protected static function Endereco_Acao($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco('Açoes','social/Acao/Acoes');
        }else{
            $_Controle->Tema_Endereco('Açoes');
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Acao($persona_id=false,$export=false){
        self::Acao_Stat($persona_id,'Unico',$export=false);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Ações'));
    }
    public static function Acao_Stat($persona_id=false,$tipo='Unico',$export=false){
        $registro = \Framework\App\Registro::getInstacia();
        $Modelo = $registro->_Modelo;
        $Visual = $registro->_Visual;
        $i = 0;
        if($persona_id==0) $persona_id = false;
        if($persona_id===false){
            self::Endereco_Acao(false);
            $where = Array();
        }else{
            $where = Array(Array('vitima'=>$persona_id,'alvo'=>$persona_id));
        }
        
        // add botao
        if($persona_id===false){
            $extra = '/0';
        }else{
            $extra = '/'.$persona_id;
        }
        $Visual->Blocar($Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Ação',
                'social/Acao/Acoes_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'social/Acao/Acao'.$extra,
            )
        )));
        $acoes = $Modelo->db->Sql_Select('Social_Acao',$where);
        if($acoes!==false && !empty($acoes)){
            if(is_object($acoes)) $acoes = Array(0=>$acoes);
            reset($acoes);
            foreach ($acoes as $indice=>&$valor) {
                $tabela['Data'][$i]             = $valor->data;
                $tabela['Vitima'][$i]           = $valor->vitima2;
                $tabela['Alvo'][$i]             = $valor->alvo2;
                $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Ação'        ,'social/Acao/Acoes_Edit/'.$valor->id.'/'.$persona_id    ,'')).
                                                  $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Ação'       ,'social/Acao/Acoes_Del/'.$valor->id.'/'.$persona_id     ,'Deseja realmente deletar essa Ação ?'));
                ++$i;
            }
            $titulo = 'Listagem de Ações ('.$i.')';
            if($export!==false){
                self::Export_Todos($export,$tabela, $titulo);
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
        $titulo = 'Listagem de Ações ('.$i.')'; 
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Ação</font></b></center>');
        }
        if($tipo=='Unico'){
            $Visual->Bloco_Unico_CriaJanela($titulo);
        }else if($tipo=='Esquerda'){
            $Visual->Bloco_Maior_CriaJanela($titulo);
        }else{
            $Visual->Bloco_Menor_CriaJanela($titulo);
        }
        
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Acoes_Add($persona_id=false){
        // Carrega Config
        $titulo1    = __('Adicionar Ação');
        $titulo2    = __('Salvar Ação');
        $formid     = 'form_Sistema_Acao_Acoes';
        $formbt     = __('Salvar');
        $formlink   = 'social/Acao/Acoes_Add2/';
        $campos = Social_Acao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Acoes_Add2($persona_id=false){
        $titulo     = __('Ação adicionada com Sucesso');
        $dao        = 'Social_Acao';
        $funcao     = '$this->Acao('.$persona_id.');';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Ação cadastrado com sucesso.');
       if($artista===false){
            $funcao     = '$this->Acao(0);';
            $alterar    = Array();
        }else{
            $persona_id = (int) $persona_id;
            $alterar    = Array('alvo'=>$persona_id);
            $funcao     = '$this->Acao('.$persona_id.');';
        }
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Acoes_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar Ação (#'.$id.')';
        $titulo2    = __('Alteração de Ação');
        $formid     = 'form_Sistema_AcaoC_AçãoEdit';
        $formbt     = __('Alterar Ação');
        $formlink   = 'social/Acao/Acoes_Edit2/'.$id;
        $editar     = Array('Social_Acao',$id);
        $campos = Social_Acao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Acoes_Edit2($id){
        $titulo     = __('Ação editado com Sucesso');
        $dao        = Array('Social_Acao',$id);
        $funcao     = '$this->Acao();';
        $sucesso1   = __('Ação Alterado com Sucesso.');
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
    public function Acoes_Del($id,$persona_id=false){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Social_Acao', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Ação deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Acao($persona_id);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Ação deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
