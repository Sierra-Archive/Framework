<?php

class Desenvolvimento_SenhaControle extends Desenvolvimento_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        parent::__construct();
    }
    protected function Endereco_Senha($true=true){
        if($true===true){
            $this->Tema_Endereco(__('Senhas'),'Desenvolvimento/Senha/Senhas');
        }else{
            $this->Tema_Endereco(__('Senhas'));
        }
    }
    protected function Endereco_Senha_Todas($true=true){
        if($true===true){
            $this->Tema_Endereco(__('Todas as Senhas'),'Desenvolvimento/Senha/Senhas_Todas');
        }else{
            $this->Tema_Endereco(__('Todas as Senhas'));
        }
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        return false;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas($export=false){
        $this->Endereco_Senha(false);
        $i = 0;
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque');
        
        // EM uso
        $tabela = Array(
            'Id','Categoria','Url','Login','Senha'
        );
        if($perm_destaque)  $tabela[] = __('Destaque');
        if($perm_status)    $tabela[] = __('Status');
        $tabela[] = __('Adicionada em');
        $tabela[] = __('Funções');
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Desenvolvimento/Senha/Senhas');
        
        
        $titulo = __('Listagem de Senhas');  //(<span id="DataTable_Contador">0</span>)
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,Array("link"=>"Desenvolvimento/Senha/Senhas_Add",'icon'=>'add','nome'=>'Adicionar Senha'));
        
        // Antigas
        $tabela = Array(
            'Id','Categoria','Url','Login','Senha'
        );
        if($perm_destaque)  $tabela[] = __('Destaque');
        if($perm_status)    $tabela[] = __('Status');
        $tabela[] = __('Adicionada em');
        $tabela[] = __('Funções');
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Desenvolvimento/Senha/Senhas_Antigas');
        $titulo = __('Listagem de Senhas Antigas');  //(<span id="DataTable_Contador">0</span>)
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Senhas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Add(){
        $this->Endereco_Senha();
        // Carrega Config
        $titulo1    = __('Adicionar Senha');
        $titulo2    = __('Salvar Senha');
        $formid     = 'form_Sistema_Admin_Senhas';
        $formbt     = __('Salvar');
        $formlink   = 'Desenvolvimento/Senha/Senhas_Add2/';
        $campos = Desenvolvimento_Senha_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Add2(){
        $titulo     = __('Senha Adicionada com Sucesso');
        $dao        = 'Desenvolvimento_Senha';
        $funcao     = '$this->Senhas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Senha cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Edit($id){
        $this->Endereco_Senha();
        // Carrega Config
        $titulo1    = 'Editar Senha (#'.$id.')';
        $titulo2    = __('Alteração de Senha');
        $formid     = 'form_Sistema_AdminC_SenhaEdit';
        $formbt     = __('Alterar Senha');
        $formlink   = 'Desenvolvimento/Senha/Senhas_Edit2/'.$id;
        $editar     = Array('Desenvolvimento_Senha',$id);
        $campos = Desenvolvimento_Senha_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Edit2($id){
        $titulo     = __('Senha Editada com Sucesso');
        $dao        = Array('Desenvolvimento_Senha',$id);
        $funcao     = '$this->Senhas();';
        $sucesso1   = __('Senha Alterada com Sucesso.');
        $sucesso2   = __('Senha teve a alteração bem sucedida');
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
    public function Senhas_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa senha e deleta
        $senha = $this->_Modelo->db->Sql_Select('Desenvolvimento_Senha', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($senha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Senha Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Senhas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Senha deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    
    
    /**
     * 
     * @param type $id
     * @throws Exception
     */
    public function Status($id=false){
        
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $id = (int) $id;
        $resultado = $this->_Modelo->db->Sql_Select('Desenvolvimento_Senha', Array('id'=>$id),1);
        
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        
        // troca Resutlado
        if($resultado->status=='1'){
            $resultado->status='2'; // De Aprovada para Recusada
        }else if($resultado->status=='2'){ // de Aprovada em Execução para Finalizada
            $resultado->status='3';
        }else if($resultado->status=='3'){ // de Finalizada em Execução para Aprovada
            $resultado->status='4';
        }else if($resultado->status=='4'){ // De Recusada para Pendente
            $resultado->status='0';
        }else{
            $resultado->status='1';
        }
            
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Sucesso'),
                "mgs_secundaria"    => __('Status Alterado com Sucesso.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            
            // Conteudo
            $conteudo = array(
                'location' => '.status'.$resultado->id,
                'js' => '',
                'html' =>  self::Statuslabel($resultado)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $objeto
     * @param type $link
     * @return string
     */
    public static function Statuslabel($objeto,$link=true){
        $status = $objeto->status;
        $id = $objeto->id;
        if($status=='0'){
            $tipo = 'important';
            $nometipo = __('Ultrapassada');
        }
        else{
            $tipo = 'success';
            $nometipo = __('Em Uso');
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true && \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status')!==false){
            $html = '<a href="'.URL_PATH.'Desenvolvimento/Senha/Status/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Status?">'.$html.'</a>';
        }
        return $html;
    }
    /**
     * 
     * @param type $id
     * @throws Exception
     */
    public function Destaque($id=false){
        
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $id = (int) $id;
        $resultado = $this->_Modelo->db->Sql_Select('Desenvolvimento_Senha', Array('id'=>$id),1);
        
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        
        // troca Resutlado
        if($resultado->destaque=='1'){
            $resultado->destaque='0'; // De Aprovada para Recusada
        }else{
            $resultado->destaque='1';
        }
            
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Sucesso'),
                "mgs_secundaria"    => __('Destaque Alterado com Sucesso.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $conteudo = array(
                'location' => '.destaque'.$resultado->id,
                'js' => '',
                'html' =>  self::Destaquelabel($resultado)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $objeto
     * @param type $link
     * @return string
     */
    public static function Destaquelabel($objeto,$link=true){
        $destaque = $objeto->destaque;
        $id = $objeto->id;
        if($destaque=='0'){
            $tipo = 'important';
            $nometipo = __('Não Destaque');
        }else{
            $tipo = 'success';
            $nometipo = __('Destaque');
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true && \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque')!==false){
            $html = '<a href="'.URL_PATH.'Desenvolvimento/Senha/Destaque/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Destaque?">'.$html.'</a>';
        }
        return $html;
    }
    static function Senhas_Todas_Tabela($Senhas_Todas){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($Senhas_Todas)) $Senhas_Todas = Array(0=>$Senhas_Todas);
        reset($Senhas_Todas);
        foreach ($Senhas_Todas as $indice=>&$valor) {
            $tabela['#Id'][$i]          =   '#'.$valor->id;
            $tabela['Categoria'][$i]    =   $valor->categoria2;
            $tabela['Url'][$i]          =   $valor->url;
            $tabela['Login'][$i]        =   $valor->login;
            $tabela['Senha'][$i]        =   $valor->senha;
            $tabela['Destaque'][$i]     = '<span class="destaque'.$valor->id.'">'.self::Destaquelabel($valor).'</span>';
            $tabela['Status'][$i]       = '<span class="status'.$valor->id.'">'.self::Statuslabel($valor).'</span>';
            $tabela['Adicionada em'][$i]=   $valor->log_date_add;
            $tabela['Funções'][$i]      =   $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Senha'        ,'Desenvolvimento/Senha/Senhas_Todas_Edit/'.$valor->id.'/'    ,'')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Senha'       ,'Desenvolvimento/Senha/Senhas_Todas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Senha ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Todas($export=false){
        $this->Endereco_Senha_Todas(false);
        $i = 0;
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque');
        
        // Usadas
        $tabela = Array(
            'Id','Responsável','Categoria','Url','Login','Senha'
        );
        if($perm_destaque)  $tabela[] = __('Destaque');
        if($perm_status)    $tabela[] = __('Status');
        $tabela[] = __('Adicionada em');
        $tabela[] = __('Funções');
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Desenvolvimento/Senha/Senhas_Todas');
        
        $titulo = __('Listagem de Todas as Senhas');  //(<span id="DataTable_Contador">0</span>)
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,Array("link"=>"Desenvolvimento/Senha/Senhas_Todas_Add",'icon'=>'add','nome'=>'Adicionar Senha'));
        
        // Antigas
        $tabela = Array(
            'Id','Responsável','Categoria','Url','Login','Senha'
        );
        if($perm_destaque)  $tabela[] = __('Destaque');
        if($perm_status)    $tabela[] = __('Status');
        $tabela[] = __('Adicionada em');
        $tabela[] = __('Funções');
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Desenvolvimento/Senha/Senhas_Todas_Antigas');
        $titulo = __('Listagem de Senhas Antigas');  //(<span id="DataTable_Contador">0</span>)
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Todas as Senhas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Todas_Add(){
        $this->Endereco_Senha_Todas();
        // Carrega Config
        $titulo1    = __('Adicionar Senha');
        $titulo2    = __('Salvar Senha');
        $formid     = 'form_Sistema_Admin_Senhas_Todas';
        $formbt     = __('Salvar');
        $formlink   = 'Desenvolvimento/Senha/Senhas_Todas_Add2/';
        $campos = Desenvolvimento_Senha_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Todas_Add2(){
        $titulo     = __('Senha Adicionada com Sucesso');
        $dao        = 'Desenvolvimento_Senha';
        $funcao     = '$this->Senhas_Todas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Senha cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Todas_Edit($id){
        $this->Endereco_Senha_Todas();
        // Carrega Config
        $titulo1    = 'Editar Senha (#'.$id.')';
        $titulo2    = __('Alteração de Senha');
        $formid     = 'form_Sistema_AdminC_SenhaEdit';
        $formbt     = __('Alterar Senha');
        $formlink   = 'Desenvolvimento/Senha/Senhas_Todas_Edit2/'.$id;
        $editar     = Array('Desenvolvimento_Senha',$id);
        $campos = Desenvolvimento_Senha_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Todas_Edit2($id){
        $titulo     = __('Senha Editada com Sucesso');
        $dao        = Array('Desenvolvimento_Senha',$id);
        $funcao     = '$this->Senhas_Todas();';
        $sucesso1   = __('Senha Alterada com Sucesso.');
        $sucesso2   = __('Senha teve a alteração bem sucedida');
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
    public function Senhas_Todas_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa senha e deleta
        $senha = $this->_Modelo->db->Sql_Select('Desenvolvimento_Senha', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($senha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Senha Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Senhas_Todas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Senha deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    
    
    /**
     * 
     * @param type $id
     * @throws Exception
     */
    public function Status_Todas($id=false){
        
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $id = (int) $id;
        $resultado = $this->_Modelo->db->Sql_Select('Desenvolvimento_Senha', Array('id'=>$id),1);
        
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        
        // troca Resutlado
        if($resultado->status=='1'){
            $resultado->status='2'; // De Aprovada para Recusada
        }else if($resultado->status=='2'){ // de Aprovada em Execução para Finalizada
            $resultado->status='3';
        }else if($resultado->status=='3'){ // de Finalizada em Execução para Aprovada
            $resultado->status='4';
        }else if($resultado->status=='4'){ // De Recusada para Pendente
            $resultado->status='0';
        }else{
            $resultado->status='1';
        }
            
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Sucesso'),
                "mgs_secundaria"    => __('Status Alterado com Sucesso.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $conteudo = array(
                'location' => '.status'.$resultado->id,
                'js' => '',
                'html' =>  self::Statuslabel_Todas($resultado)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $objeto
     * @param type $link
     * @return string
     */
    public static function Statuslabel_Todas($objeto,$link=true){
        $status = $objeto->status;
        $id = $objeto->id;
        if($status=='0'){
            $tipo = 'important';
            $nometipo = __('Ultrapassada');
        }
        else{
            $tipo = 'success';
            $nometipo = __('Em Uso');
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true && \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Status')!==false){
            $html = '<a href="'.URL_PATH.'Desenvolvimento/Senha/Status_Todas/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Status?">'.$html.'</a>';
        }
        return $html;
    }
    /**
     * 
     * @param type $id
     * @throws Exception
     */
    public function Destaque_Todas($id=false){
        
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $id = (int) $id;
        $resultado = $this->_Modelo->db->Sql_Select('Desenvolvimento_Senha', Array('id'=>$id),1);
        
        if($resultado===false || !is_object($resultado)){
            throw new \Exception('Esse registro não existe:'. $raiz, 404);
        }
        
        // troca Resutlado
        if($resultado->destaque=='1'){
            $resultado->destaque='0'; // De Aprovada para Recusada
        }else{
            $resultado->destaque='1';
        }
            
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Sucesso'),
                "mgs_secundaria"    => __('Destaque Alterado com Sucesso.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $conteudo = array(
                'location' => '.destaque'.$resultado->id,
                'js' => '',
                'html' =>  self::Destaquelabel_Todas($resultado)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $objeto
     * @param type $link
     * @return string
     */
    public static function Destaquelabel_Todas($objeto,$link=true){
        $destaque = $objeto->destaque;
        $id = $objeto->id;
        if($destaque=='0'){
            $tipo = 'important';
            $nometipo = __('Não Destaque');
        }else{
            $tipo = 'success';
            $nometipo = __('Destaque');
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true && \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Desenvolvimento/Senha/Destaque')!==false){
            $html = '<a href="'.URL_PATH.'Desenvolvimento/Senha/Destaque_Todas/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Destaque?">'.$html.'</a>';
        }
        return $html;
    }
    
}
?>
  