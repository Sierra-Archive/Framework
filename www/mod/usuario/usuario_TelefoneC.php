<?php
class usuario_TelefoneControle extends usuario_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_rede_PerfilModelo::Carrega Rede Modelo
    * @uses usuario_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
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
    * @uses usuario_Controle::$acoesPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function Main(){
        return false; 
    }
    static function Endereco_Telefone($true=true){
        $registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(__('Telefone'),'usuario/Telefone/Telefone');
        }else{
            $_Controle->Tema_Endereco(__('Telefone'));
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Telefone($export=false){
        self::Endereco_Telefone(false);
        $i = 0;
        // add botao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Telefone',
                'usuario/Telefone/Telefones_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario/Telefone/Telefones',
            )
        )));
        $telefones = $this->_Modelo->db->Sql_Select('Usuario_Telefone');
        if($telefones!==false && !empty($telefones)){
            if(is_object($telefones)) $telefones = Array(0=>$telefones);
            reset($telefones);
            foreach ($telefones as $indice=>&$valor) {
                $tabela['Pessoa'][$i]           = $valor->persona2;
                $tabela['Numero'][$i]           = $valor->telefone;
                $tabela['Obs'][$i]              = $valor->obs;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Telefone'        ,'usuario/Telefone/Telefones_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Telefone'       ,'usuario/Telefone/Telefones_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Telefone ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Telefones');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Telefone</font></b></center>');
        }
        $titulo = __('Listagem de Telefones').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10);
        
        // Upload de Chamadas
        $this->_Visual->Blocar(
            $this->_Visual->Upload_Janela(
                'usuario',
                'Telefone',
                'Telefone',
                0,
                'og3;mp3;',
                'Arquivos de Audio'
            )
        );
        $this->_Visual->Bloco_Unico_CriaJanela(__('Fazer Upload de Audio de Chamada')  ,'',8);

        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Telefones'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Telefones_Add(){
        self:;Endereco_Telefone();
        // Carrega Config
        $titulo1    = __('Adicionar Telefone');
        $titulo2    = __('Salvar Telefone');
        $formid     = 'form_Sistema_Telefone_Telefones';
        $formbt     = __('Salvar');
        $formlink   = 'usuario/Telefone/Telefones_Add2/';
        $campos = Usuario_Telefone_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Telefones_Add2(){
        $titulo     = __('Telefone adicionada com Sucesso');
        $dao        = 'Usuario_Telefone';
        $funcao     = '$this->Telefone();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Telefone cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Telefones_Edit($id){
        self:;Endereco_Telefone();
        // Carrega Config
        $titulo1    = 'Editar Telefone (#'.$id.')';
        $titulo2    = __('Alteração de Telefone');
        $formid     = 'form_Sistema_TelefoneC_TelefoneEdit';
        $formbt     = __('Alterar Telefone');
        $formlink   = 'usuario/Telefone/Telefones_Edit2/'.$id;
        $editar     = Array('Usuario_Telefone',$id);
        $campos = Usuario_Telefone_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Telefones_Edit2($id){
        $titulo     = __('Telefone editada com Sucesso');
        $dao        = Array('Usuario_Telefone',$id);
        $funcao     = '$this->Telefone();';
        $sucesso1   = __('Telefone Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Telefones_Del($id){
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Telefone', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Telefone deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Telefone();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Telefone deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Telefone_Upload($parent = 0){
        $fileTypes = array(
            // Audio
            'mp3',
            '3gp',
        ); // File extensions
        $dir = 'usuario'.DS.'Chamadas_Nao_Contabilizadas'.DS;
        $ext = $this->Upload($dir,$fileTypes,false);
        $this->layoult_zerar = false;
        if($ext!==false){
            $this->_Visual->Json_Info_Update('Titulo', __('Upload com Sucesso'));
            $this->_Visual->Json_Info_Update('Historico', false);
        }else{
            $this->_Visual->Json_Info_Update('Titulo', __('Erro com Upload'));
            $this->_Visual->Json_Info_Update('Historico', false);
        }
    }
}
?>
