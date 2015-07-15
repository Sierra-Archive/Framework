<?php

class _Sistema_FilialControle extends _Sistema_Controle
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Main(){
        return false;
    }
    public function FilialWidgets(){
        // Filial
        $filial = $this->_Modelo->db->Sql_Select('Sistema_Filial',Array());
        if(is_object($filial)) $filial = Array(0=>$filial);
        if($filial!==false && !empty($filial)){reset($filial);$filial_qnt = count($filial);}else{$filial = 0;}
        
        // Exibir
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Filiais', 
            '_Sistema/Filial/Filiais', 
            'tag', 
            $filial_qnt, 
            'block-green', 
            false, 
            10
        );
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Filiais($tipobloco='Unico'){
        $this->Endereco_Filial(false);
        
        $tabela_colunas[] = __('Id');
        $tabela_colunas[] = __('Nome');
        $tabela_colunas[] = __('Bairro');
        $tabela_colunas[] = __('Endereço');
        $tabela_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'_Sistema/Filial/Filiais');

        $titulo = __('Listagem de Filiais').' (<span id="DataTable_Contador">0</span>)';
        if($tipobloco==='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,Array("link"=>"_Sistema/Filial/Filiais_Add",'icon'=>'add','nome'=>__('Adicionar Filial')));
        }else if($tipobloco==='Maior'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',10,Array("link"=>"_Sistema/Filial/Filiais_Add",'icon'=>'add','nome'=>__('Adicionar Filial')));
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo,'',10,Array("link"=>"_Sistema/Filial/Filiais_Add",'icon'=>'add','nome'=>__('Adicionar Filial')));
        }
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Filiais'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Filiais_Add(){
        $this->Endereco_Filial();
        // Carrega Filial
        $titulo1    = __('Adicionar Filial');
        $titulo2    = __('Salvar Filial');
        $formid     = 'form_Sistema_Filial_Filial';
        $formbt     = __('Salvar');
        $formlink   = '_Sistema/Filial/Filiais_Add2/';
        $campos = Sistema_Filial_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Filiais_Add2(){
        $titulo     = __('Filial Adicionada com Sucesso');
        $dao        = 'Sistema_Filial';
        $funcao     = '$this->Filiais();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Filial cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Filiais_Edit($id){
        $this->Endereco_Filial();
        // Carrega Filial
        $titulo1    = __('Editar Filial').' (#'.$id.')';
        $titulo2    = __('Alteração de Filial');
        $formid     = 'form_Sistema_FilialC_FilialEdit';
        $formbt     = __('Alterar Filial');
        $formlink   = '_Sistema/Filial/Filiais_Edit2/'.$id;
        $editar     = Array('Sistema_Filial',$id);
        $campos = Sistema_Filial_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Filiais_Edit2($id){
        $id = (int) $id;
        $titulo     = __('Filial Alterada com Sucesso');
        $dao        = Array('Sistema_Filial',$id);
        $funcao     = '$this->Filiais();';
        $sucesso1   = __('Filial Alterada com Sucesso');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Filiais_Del($id){
        
        $id         = \anti_injection($id);
        
        // Puxa filial e deleta
        $filial    =  $this->_Modelo->db->Sql_Select('Sistema_Filial', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($filial);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Filial Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Filiais();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Filial deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * Administra as Filiais Publicas
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    function Endereco_Filial($true=true){
        $titulo = __('Filiais do Sistema');
        $link = '_Sistema/Filial/Filiais';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
            $this->Tema_Endereco($titulo);
        }
    }
}
?>
