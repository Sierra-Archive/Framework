<?php

class noticia_AdminControle extends noticia_Controle
{
    public function __construct(){
        parent::__construct();
    }
    static function Endereco_Noticia($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Noticias';
        $link = 'noticia/Admin/Noticias';
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'noticia/Admin/Noticias');
        return false;
    }
    static function Noticias_Tabela(&$noticia){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($noticia)) $noticia = Array(0=>$noticia);reset($noticia);
        foreach ($noticia as &$valor) {                
            $tabela['Id'][$i]           = '#'.$valor->id;
            $tabela['Categoria'][$i]    = $valor->categoria2;
            $tabela['Foto'][$i]         = '<img src="'.$valor->foto.'" style="max-width:100px;" />';
            $tabela['Titulo'][$i]       = $valor->nome;
            if($valor->status==1 || $valor->status=='1'){
                $texto = 'Ativado';
                $valor->status='1';
            }else{
                $texto = 'Desativado';
                $valor->status='0';
            }
            $tabela['Funções'][$i]      = '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$valor->status     ,Array($texto        ,'noticia/Admin/Status/'.$valor->id.'/'    ,'')).'</span>';
            if($valor->destaque==1){
                $texto = 'Em Destaque';
            }else{
                $texto = 'Não está em destaque';
            }
            $tabela['Funções'][$i]      .= '<span id="destaques'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Destaque'.$valor->destaque   ,Array($texto   ,'noticia/Admin/Destaques/'.$valor->id.'/'    ,'')).'</span>';
            $tabela['Funções'][$i]      .= $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Noticia'        ,'noticia/Admin/Noticias_Edit/'.$valor->id.'/'    ,'')).
                                           $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Noticia'       ,'noticia/Admin/Noticias_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Noticia ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    
    /**
     * Deleta Campos de Propostas 
     * @param type $campos
     * @param type $tema
     */
    static function Campos_Deletar(&$campos){
        // Retira Padroes
        if(!(\Framework\App\Sistema_Funcoes::Perm_Modulos('Musica'))){
             self::DAO_Campos_Retira($campos, 'Artistas');
        }
        
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('noticia_Categoria') === false){
            self::DAO_Campos_Retira($campos, 'categoria');
        }
       
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Noticias($export=false){
        $i = 0;
        self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Noticia',
                'noticia/Admin/Noticias_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'noticia/Admin/Noticias',
            )
        )));
        $noticia = $this->_Modelo->db->Sql_Select('Noticia');
        if(is_object($noticia)) $noticia = Array(0=>$noticia);
        if($noticia!==false && !empty($noticia)){
            list($tabela,$i) = self::Noticias_Tabela($noticia);
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Noticias');
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
                $mensagem = 'Nenhuma Noticia Cadastrada para exportar';
            }else{
                $mensagem = 'Nenhuma Noticia Cadastrada';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem de Noticias ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Noticias'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Noticias_Add(){
        self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Adicionar Noticia';
        $titulo2    = 'Salvar Noticia';
        $formid     = 'formnoticia_Admin_Noticia';
        $formbt     = 'Salvar';
        $formlink   = 'noticia/Admin/Noticias_Add2/';
        $campos = Noticia_DAO::Get_Colunas();
        
        self::Campos_Deletar($campos);

        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Noticias_Add2(){
        $titulo     = 'Noticia Adicionada com Sucesso';
        $dao        = 'Noticia';
        $funcao     = '$this->Noticias();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Noticia cadastrada com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Noticias_Edit($id){
        self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Editar Noticia (#'.$id.')';
        $titulo2    = 'Alteração de Noticia';
        $formid     = 'formnoticia_AdminC_NoticiaEdit';
        $formbt     = 'Alterar Noticia';
        $formlink   = 'noticia/Admin/Noticias_Edit2/'.$id;
        $editar     = Array('Noticia',$id);
        $campos = Noticia_DAO::Get_Colunas();
        
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Noticias_Edit2($id){
        $id = (int) $id;
        $titulo     = 'Noticia Alterada com Sucesso';
        $dao        = Array('Noticia',$id);
        $funcao     = '$this->Noticias();';
        $sucesso1   = 'Noticia Alterada com Sucesso';
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
    public function Noticias_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa noticia e deleta
        $noticia    =  $this->_Modelo->db->Sql_Select('Noticia', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($noticia);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Noticia Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Noticias();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Noticia deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Noticia', Array('id'=>$id),1);
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
                $texto = 'Ativado';
            }else{
                $texto = 'Desativado';
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'noticia/Admin/Status/'.$resultado->id.'/'    ,''))
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
        $resultado = $this->_Modelo->db->Sql_Select('Noticia', Array('id'=>$id),1);
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
                $texto = 'Em destaque';
            }else{
                $texto = 'Não está em destaque';
            }
            $conteudo = array(
                'location' => '#destaques'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Destaque'.$resultado->destaque     ,Array($texto        ,'noticia/Admin/Destaques/'.$resultado->id.'/'    ,''))
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
