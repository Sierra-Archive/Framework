<?php
class Musica_ArtistaControle extends Musica_Controle
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
    * @uses artista_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Musica/Artista/Artistas');
        return false;
    }
    static function Endereco_Artista($true=true){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(__('Artistas'),'Musica/Artista/Artistas');
        }else{
            $_Controle->Tema_Endereco(__('Artistas'));
        }
    }
    static function Artistas_Tabela(&$artistas){
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        
        $tabela = Array();
        $i = 0;
        if(is_object($artistas)) $artistas = Array(0=>$artistas);
        reset($artistas);
        foreach ($artistas as &$valor) {
            $tabela['Nome do Artista'][$i]          =   $valor->nome;
            
            if($valor->foto==='' || $valor->foto===false){
                $foto = WEB_URL.'img'.US.'icons'.US.'clientes.png';
            }else{
                $foto = $valor->foto;
            }
            $tabela['Foto'][$i]                     = '<img src="'.$foto.'" style="max-width:100px;" />';
            $tabela['Data Cadastrada'][$i]          =   $valor->log_date_add;
            $status                                 = $valor->status;
            if($status!=1){
                $status = 0;
                $texto = __('Desativado');
            }else{
                $status = 1;
                $texto = __('Ativado');
            }
            $tabela['Status'][$i]                   = '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$status     ,Array($texto        ,'Musica/Artista/Status/'.$valor->id.'/'    ,'')).'</span>';
            $tabela['Funções'][$i]                  =   $Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar Albuns do Artista'    ,'Musica/Album/Albuns/'.$valor->id.'/'    ,'')).
                                                        $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Artista'        ,'Musica/Artista/Artistas_Edit/'.$valor->id.'/'    ,'')).
                                                        $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Artista'       ,'Musica/Artista/Artistas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Artista ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Artistas($export=false){
        self::Endereco_Artista(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Artista',
                'Musica/Artista/Artistas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Musica/Artista/Artistas',
            )
        )));
        $artistas = $this->_Modelo->db->Sql_Select('Musica_Album_Artista');
        if($artistas!==false && !empty($artistas)){
            list($tabela,$i) = self::Artistas_Tabela($artistas);
            
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Artistas');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Artista</font></b></center>');
        }
        $titulo = __('Listagem de Artistas').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Artistas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Artistas_Add(){
        self::Endereco_Artista();
        // Carrega Config
        $titulo1    = __('Adicionar Artista');
        $titulo2    = __('Salvar Artista');
        $formid     = 'form_Sistema_Admin_Artistas';
        $formbt     = __('Salvar');
        $formlink   = 'Musica/Artista/Artistas_Add2/';
        $campos = Musica_Album_Artista_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Artistas_Add2(){
        $titulo     = __('Artista Adicionado com Sucesso');
        $dao        = 'Musica_Album_Artista';
        $funcao     = '$this->Artistas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Artista cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Artistas_Edit($id){
        self::Endereco_Artista();
        // Carrega Config
        $titulo1    = 'Editar Artista (#'.$id.')';
        $titulo2    = __('Alteração de Artista');
        $formid     = 'form_Sistema_AdminC_ArtistaEdit';
        $formbt     = __('Alterar Artista');
        $formlink   = 'Musica/Artista/Artistas_Edit2/'.$id;
        $editar     = Array('Musica_Album_Artista',$id);
        $campos = Musica_Album_Artista_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Artistas_Edit2($id){
        $titulo     = __('Artista Editado com Sucesso');
        $dao        = Array('Musica_Album_Artista',$id);
        $funcao     = '$this->Artistas();';
        $sucesso1   = __('Artista Alterado com Sucesso.');
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
    public function Artistas_Del($id){
        
        
    	$id = (int) $id;
        // Puxa artista e deleta
        $artista = $this->_Modelo->db->Sql_Select('Musica_Album_Artista', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($artista);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Artista deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Artistas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Artista deletado com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    public function Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Musica_Album_Artista', Array('id'=>$id),1);
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
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Musica/Artista/Status/'.$resultado->id.'/'    ,''))
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
}
?>
