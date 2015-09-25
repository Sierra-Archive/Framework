<?php
class locais_locaisControle extends locais_Controle
{

    public function __construct(){
        parent::__construct();
    }
    public function Main(){
        return false;   
    }
    static function Endereco_Local($true=true){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(__('Locais'),'locais/locais/Locais');
        }else{
            $_Controle->Tema_Endereco(__('Locais'));
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Locais($export=false){
        self::Endereco_Local(false);
        $i = 0;
        // Add BOtao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Local',
                'locais/locais/Locais_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'locais/locais/Locais',
            )
        )));
        // Query
        $setores = $this->_Modelo->db->Sql_Select('Local');
        if($setores!==false && !empty($setores)){
            if(is_object($setores)) $setores = Array(0=>$setores);
            reset($setores);
            foreach ($setores as $indice=>&$valor) {
                $tabela['Tipo de Local'][$i]             = $valor->categoria2;
                $tabela['Nome'][$i]             = $valor->nome;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Local'        ,'locais/locais/Locais_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Local'       ,'locais/locais/Locais_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Local ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Locais');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Local</font></b></center>');
        }
        $titulo = __('Listagem de Locais').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Locais'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Locais_Add(){
        self::Endereco_Local(true);
        // Carrega Config
        $titulo1    = __('Adicionar Local');
        $titulo2    = __('Salvar Local');
        $formid     = 'form_Sistema_Admin_Locais';
        $formbt     = __('Salvar');
        $formlink   = 'locais/locais/Locais_Add2/';
        $campos = Local_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Locais_Add2(){
        $titulo     = __('Local Adicionado com Sucesso');
        $dao        = 'Local';
        $funcao     = '$this->Locais();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Local cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Locais_Edit($id){
        self::Endereco_Local(true);
        // Carrega Config
        $titulo1    = 'Editar Local (#'.$id.')';
        $titulo2    = __('Alteração de Local');
        $formid     = 'form_Sistema_AdminC_LocalEdit';
        $formbt     = __('Alterar Local');
        $formlink   = 'locais/locais/Locais_Edit2/'.$id;
        $editar     = Array('Local',$id);
        $campos = Local_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Locais_Edit2($id){
        $titulo     = __('Local Editado com Sucesso');
        $dao        = Array('Local',$id);
        $funcao     = '$this->Locais();';
        $sucesso1   = __('Local Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Locais_Del($id){
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Local', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Local deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Locais();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Local deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
