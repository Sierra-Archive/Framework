<?php

class Seguranca_SenhaControle extends Seguranca_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Seguranca_ListarModelo Carrega Seguranca Modelo
    * @uses Seguranca_ListarVisual Carrega Seguranca Visual
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
            $this->Tema_Endereco('Senhas','Seguranca/Senha/Senhas');
        }else{
            $this->Tema_Endereco('Senhas');
        }
    }
    protected function Endereco_Senha_Todas($true=true){
        if($true===true){
            $this->Tema_Endereco('Todas as Senhas','Seguranca/Senha/Senhas_Todas');
        }else{
            $this->Tema_Endereco('Todas as Senhas');
        }
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses Seguranca_Controle::$SegurancaPerfil
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
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque');
        
        // EM uso
        $tabela = Array(
            'Id','Categoria','Url','Login','Senha'
        );
        if($perm_destaque)  $tabela[] = 'Destaque';
        if($perm_status)    $tabela[] = 'Status';
        $tabela[] = 'Adicionada em';
        $tabela[] = 'Funções';
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Seguranca/Senha/Senhas');
        
        
        $titulo = 'Listagem de Senhas';  //(<span id="DataTable_Contador">Carregando...</span>)
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,Array("link"=>"Seguranca/Senha/Senhas_Add",'icon'=>'add','nome'=>'Adicionar Senha'));
        
        // Antigas
        $tabela = Array(
            'Id','Categoria','Url','Login','Senha'
        );
        if($perm_destaque)  $tabela[] = 'Destaque';
        if($perm_status)    $tabela[] = 'Status';
        $tabela[] = 'Adicionada em';
        $tabela[] = 'Funções';
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Seguranca/Senha/Senhas_Antigas');
        $titulo = 'Listagem de Senhas Antigas';  //(<span id="DataTable_Contador">Carregando...</span>)
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Senhas');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Add(){
        $this->Endereco_Senha();
        // Carrega Config
        $titulo1    = 'Adicionar Senha';
        $titulo2    = 'Salvar Senha';
        $formid     = 'form_Sistema_Admin_Senhas';
        $formbt     = 'Salvar';
        $formlink   = 'Seguranca/Senha/Senhas_Add2/';
        $campos = Seguranca_Senha_DAO::Get_Colunas();
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
        $titulo     = 'Senha Adicionada com Sucesso';
        $dao        = 'Seguranca_Senha';
        $funcao     = '$this->Senhas();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Senha cadastrada com sucesso.';
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
        $titulo2    = 'Alteração de Senha';
        $formid     = 'form_Sistema_AdminC_SenhaEdit';
        $formbt     = 'Alterar Senha';
        $formlink   = 'Seguranca/Senha/Senhas_Edit2/'.$id;
        $editar     = Array('Seguranca_Senha',$id);
        $campos = Seguranca_Senha_DAO::Get_Colunas();
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
        $titulo     = 'Senha Editada com Sucesso';
        $dao        = Array('Seguranca_Senha',$id);
        $funcao     = '$this->Senhas();';
        $sucesso1   = 'Senha Alterada com Sucesso.';
        $sucesso2   = 'Senha teve a alteração bem sucedida';
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
        $senha = $this->_Modelo->db->Sql_Select('Seguranca_Senha', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($senha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Senha Deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Senhas();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Senha deletada com Sucesso');  
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
        $resultado = $this->_Modelo->db->Sql_Select('Seguranca_Senha', Array('id'=>$id),1);
        
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
                "mgs_principal"     => 'Sucesso',
                "mgs_secundaria"    => 'Status Alterado com Sucesso.'
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
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
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
            $nometipo = 'Ultrapassada';
        }
        else{
            $tipo = 'success';
            $nometipo = 'Em Uso';
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true && \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Seguranca/Senha/Status')!==false){
            $html = '<a href="'.URL_PATH.'Seguranca/Senha/Status/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Status?">'.$html.'</a>';
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
        $resultado = $this->_Modelo->db->Sql_Select('Seguranca_Senha', Array('id'=>$id),1);
        
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
                "mgs_principal"     => 'Sucesso',
                "mgs_secundaria"    => 'Destaque Alterado com Sucesso.'
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
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
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
            $nometipo = 'Não Destaque';
        }else{
            $tipo = 'success';
            $nometipo = 'Destaque';
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true && \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque')!==false){
            $html = '<a href="'.URL_PATH.'Seguranca/Senha/Destaque/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Destaque?">'.$html.'</a>';
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
            $tabela['Funções'][$i]      =   $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Todas_Edit/'.$valor->id.'/'    ,'')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Todas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Senha ?'));
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
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque');
        
        // Usadas
        $tabela = Array(
            'Id','Responsável','Categoria','Url','Login','Senha'
        );
        if($perm_destaque)  $tabela[] = 'Destaque';
        if($perm_status)    $tabela[] = 'Status';
        $tabela[] = 'Adicionada em';
        $tabela[] = 'Funções';
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Seguranca/Senha/Senhas_Todas');
        
        $titulo = 'Listagem de Todas as Senhas';  //(<span id="DataTable_Contador">Carregando...</span>)
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',0,Array("link"=>"Seguranca/Senha/Senhas_Todas_Add",'icon'=>'add','nome'=>'Adicionar Senha'));
        
        // Antigas
        $tabela = Array(
            'Id','Responsável','Categoria','Url','Login','Senha'
        );
        if($perm_destaque)  $tabela[] = 'Destaque';
        if($perm_status)    $tabela[] = 'Status';
        $tabela[] = 'Adicionada em';
        $tabela[] = 'Funções';
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Seguranca/Senha/Senhas_Todas_Antigas');
        $titulo = 'Listagem de Senhas Antigas';  //(<span id="DataTable_Contador">Carregando...</span>)
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Todas as Senhas');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Senhas_Todas_Add(){
        $this->Endereco_Senha_Todas();
        // Carrega Config
        $titulo1    = 'Adicionar Senha';
        $titulo2    = 'Salvar Senha';
        $formid     = 'form_Sistema_Admin_Senhas_Todas';
        $formbt     = 'Salvar';
        $formlink   = 'Seguranca/Senha/Senhas_Todas_Add2/';
        $campos = Seguranca_Senha_DAO::Get_Colunas();
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
        $titulo     = 'Senha Adicionada com Sucesso';
        $dao        = 'Seguranca_Senha';
        $funcao     = '$this->Senhas_Todas();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Senha cadastrada com sucesso.';
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
        $titulo2    = 'Alteração de Senha';
        $formid     = 'form_Sistema_AdminC_SenhaEdit';
        $formbt     = 'Alterar Senha';
        $formlink   = 'Seguranca/Senha/Senhas_Todas_Edit2/'.$id;
        $editar     = Array('Seguranca_Senha',$id);
        $campos = Seguranca_Senha_DAO::Get_Colunas();
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
        $titulo     = 'Senha Editada com Sucesso';
        $dao        = Array('Seguranca_Senha',$id);
        $funcao     = '$this->Senhas_Todas();';
        $sucesso1   = 'Senha Alterada com Sucesso.';
        $sucesso2   = 'Senha teve a alteração bem sucedida';
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
        $senha = $this->_Modelo->db->Sql_Select('Seguranca_Senha', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($senha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Senha Deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Senhas_Todas();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Senha deletada com Sucesso');  
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
        $resultado = $this->_Modelo->db->Sql_Select('Seguranca_Senha', Array('id'=>$id),1);
        
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
                "mgs_principal"     => 'Sucesso',
                "mgs_secundaria"    => 'Status Alterado com Sucesso.'
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
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
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
            $nometipo = 'Ultrapassada';
        }
        else{
            $tipo = 'success';
            $nometipo = 'Em Uso';
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true && \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Seguranca/Senha/Status')!==false){
            $html = '<a href="'.URL_PATH.'Seguranca/Senha/Status_Todas/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Status?">'.$html.'</a>';
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
        $resultado = $this->_Modelo->db->Sql_Select('Seguranca_Senha', Array('id'=>$id),1);
        
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
                "mgs_principal"     => 'Sucesso',
                "mgs_secundaria"    => 'Destaque Alterado com Sucesso.'
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
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
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
            $nometipo = 'Não Destaque';
        }else{
            $tipo = 'success';
            $nometipo = 'Destaque';
        }
        $html = '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        if($link===true && \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque')!==false){
            $html = '<a href="'.URL_PATH.'Seguranca/Senha/Destaque_Todas/'.$id.'" border="1" class="lajax explicar-titulo" title="'.$nometipo.'" acao="" confirma="Deseja Realmente alterar o Destaque?">'.$html.'</a>';
        }
        return $html;
    }
    
}
?>
  