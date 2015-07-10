<?php

class Transporte_EstradaControle extends Transporte_Controle
{
    public function __construct(){
        parent::__construct();
    }
    static function Endereco_Noticia($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = __('Estradas');
        $link = 'Transporte/Estrada/Estradas';
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Transporte/Estrada/Estradas');
        return false;
    }
    static function Estradas_Tabela(&$estrada){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($estrada)) $estrada = Array(0=>$estrada);reset($estrada);
        $perm_status = $registro->_Acl->Get_Permissao_Url('Transporte/Estrada/Status');
        $perm_destaque = $registro->_Acl->Get_Permissao_Url('Transporte/Estrada/Destaques');
        $perm_editar = $registro->_Acl->Get_Permissao_Url('Transporte/Estrada/Estradas_Edit');
        $perm_del = $registro->_Acl->Get_Permissao_Url('Transporte/Estrada/Estradas_Del');
        foreach ($estrada as &$valor) {                
            $tabela['Id'][$i]           = '#'.$valor->id;
            $tabela['Foto'][$i]         = '<img src="'.$valor->foto.'" style="max-width:100px;" />';
            $tabela['Estrada'][$i]       = $valor->nome;
            if($valor->status==1 || $valor->status=='1'){
                $texto = __('Ativado');
                $valor->status='1';
            }else{
                $texto = __('Desativado');
                $valor->status='0';
            }
            $tabela['Funções'][$i]      = '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$valor->status     ,Array($texto        ,'Transporte/Estrada/Status/'.$valor->id.'/'    ,''),$perm_status).'</span>';
            if($valor->destaque==1){
                $texto = __('Em Destaque');
            }else{
                $texto = __('Não está em destaque');
            }
            $tabela['Funções'][$i]      .= '<span id="destaques'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Destaque'.$valor->destaque   ,Array($texto   ,'Transporte/Estrada/Destaques/'.$valor->id.'/'    ,''),$perm_destaques).'</span>';
            $tabela['Funções'][$i]      .= $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Dica de Estrada'        ,'Transporte/Estrada/Estradas_Edit/'.$valor->id.'/'    ,''),$perm_editar).
                                           $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Dica de Estrada'       ,'Transporte/Estrada/Estradas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Dica de Estrada ?'),$perm_del);
            ++$i;
        }
        return Array($tabela,$i);
    }
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Estradas($export=false){
        $i = 0;
        self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Dica de Estrada',
                'Transporte/Estrada/Estradas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Estrada/Estradas',
            )
        )));
        $estrada = $this->_Modelo->db->Sql_Select('Transporte_Estrada');
        if(is_object($estrada)) $estrada = Array(0=>$estrada);
        if($estrada!==false && !empty($estrada)){
            list($tabela,$i) = self::Estradas_Tabela($estrada);
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Dicas de Estradas');
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
            if($export!==false){
                $mensagem = __('Nenhuma Dica de Estrada Cadastrada para exportar');
            }else{
                $mensagem = __('Nenhuma Dica de Estrada Cadastrada');
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Dicas de Estradas').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Estradaistrar Estradas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Estradas_Add(){
        self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = __('Adicionar Dica de Estrada');
        $titulo2    = __('Salvar Dica de Estrada');
        $formid     = 'formTransporte_Estrada_Noticia';
        $formbt     = __('Salvar');
        $formlink   = 'Transporte/Estrada/Estradas_Add2/';
        $campos = Transporte_Estrada_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Estradas_Add2(){
        $titulo     = __('Dica de Estrada Adicionada com Sucesso');
        $dao        = 'Transporte_Estrada';
        $funcao     = '$this->Estradas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Dica de Estrada cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Estradas_Edit($id){
        self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Editar Dica de Estrada (#'.$id.')';
        $titulo2    = __('Alteração de Dica de Estrada');
        $formid     = 'formTransporte_EstradaC_NoticiaEdit';
        $formbt     = __('Alterar Dica de Estrada');
        $formlink   = 'Transporte/Estrada/Estradas_Edit2/'.$id;
        $editar     = Array('Transporte_Estrada',$id);
        $campos = Transporte_Estrada_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Estradas_Edit2($id){
        $id = (int) $id;
        $titulo     = __('Dica de Estrada Alterada com Sucesso');
        $dao        = Array('Transporte_Estrada',$id);
        $funcao     = '$this->Estradas();';
        $sucesso1   = __('Dica de Estrada Alterada com Sucesso');
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
    public function Estradas_Del($id){
        
        
    	$id = (int) $id;
        // Puxa Transporte e deleta
        $estrada    =  $this->_Modelo->db->Sql_Select('Transporte_Estrada', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($estrada);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Dica de Estrada Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Estradas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Dica de Estrada deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Estrada', Array('id'=>$id),1);
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
            if($resultado->status==1){
                $texto = __('Ativado');
            }else{
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Transporte/Estrada/Status/'.$resultado->id.'/'    ,''))
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
    public function Destaques($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Estrada', Array('id'=>$id),1);
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        if($resultado->destaque==1 || $resultado->destaque=='1'){
            $resultado->destaque='0';
        }else{
            $resultado->destaque='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            if($resultado->destaque==1){
                $texto = __('Em destaque');
            }else{
                $texto = __('Não está em destaque');
            }
            $conteudo = array(
                'location' => '#destaques'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Destaque'.$resultado->destaque     ,Array($texto        ,'Transporte/Estrada/Destaques/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Destaque Alterado')); 
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
