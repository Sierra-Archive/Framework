<?php

class Locomocao_EntregaControle extends Locomocao_Controle
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
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entregas(){
        $this->Endereco_Entrega_Entrega(false);
        
        $tabela_colunas[] = __('Chave');
        $tabela_colunas[] = __('Descrição');
        $tabela_colunas[] = __('Valor');
        $tabela_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'Locomocao/Entrega/Entregas');

        $titulo = __('Listagem de Entregas').' (<span id="DataTable_Contador">0</span>)';
        if($export==='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10);
        }else if($export==='Maior'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',10);
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo,'',10);
        }
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Entregaistrar Entregas'));
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entregas_Edit($id){
        $this->Endereco_Entrega_Entrega();
        // Carrega Entrega
        $titulo1    = __('Editar Entrega').' (#'.$id.')';
        $titulo2    = __('Alteração de Entrega');
        $formid     = 'formLocomocao_EntregaC_EntregaEdit';
        $formbt     = __('Alterar Entrega');
        $formlink   = 'Locomocao/Entrega/Entregas_Edit2/'.$id;
        $editar     = Array('Locomocao_Entrega',$id);
        $campos = Locomocao_Entrega_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entregas_Edit2($id){
        $id = (int) $id;
        $titulo     = __('Entrega Alterada com Sucesso');
        $dao        = Array('Locomocao_Entrega',$id);
        $funcao     = '$this->Entregas();';
        $sucesso1   = __('Entrega Alterada com Sucesso');
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
    public function Entregas_Del($id){
        
        
    	$id = (int) $id;
        // Puxa menu e deleta
        $menu    =  $this->_Modelo->db->Sql_Select('Locomocao_Entrega', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($menu);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Entrega Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Entregas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Entrega deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $id
     * @throws \Exception
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Entrega_Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Locomocao_Entrega', Array('id'=>$id),1);
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        if($resultado->status==1 || $resultado->status=='1'){
            $resultado->status='0';
        }else{
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            if($resultado->status==1 || $resultado->status=='1'){
                $texto = __('Ativado');
            }else{
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Locomocao/Entrega/Entrega_Status/'.$resultado->id.'/'    ,''))
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
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    function Endereco_Entrega($true=true){
        $titulo = __('Administração Geral');
        $link = 'Locomocao/Entrega/Main';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
            $this->Tema_Endereco($titulo);
        }
    }
    /**
     * Entregaura as Entregas Publicas
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    function Endereco_Entrega_Entrega($true=true){
        self::Endereco_Entrega();
        $titulo = __('Permissões do Sistema');
        $link = 'Locomocao/Entrega/Permissoes';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
            $this->Tema_Endereco($titulo);
        }
    }
}
?>
