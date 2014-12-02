<?php

class Transporte_CargaControle extends Transporte_Controle
{
    public function __construct(){
        parent::__construct();
    }
    static function Endereco_Noticia($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Cargas';
        $link = 'Transporte/Carga/Cargas';
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
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Transporte/Carga/Cargas');
        return false;
    }
    
    static function Cargas_Tabela(&$carga,$show_usuario=true){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $editar = false;
        $i = 0;
        if(is_object($carga)) $carga = Array(0=>$carga);reset($carga);
        foreach ($carga as &$valor) {                
            $tabela['Id'][$i]           = '#'.$valor->id;
            $tabela['Foto'][$i]         = '<img src="'.$valor->foto.'" style="max-width:100px;" />';
            $tabela['Carga'][$i]       = $valor->nome;
            if($valor->status==3 || $valor->status=='3'){
                $texto = 'Entregue';
                $valor->status='3';
            }else if($valor->status==2 || $valor->status=='2'){
                $texto = 'Em Armazenamento';
                $valor->status='2';
            }else if($valor->status==1 || $valor->status=='1'){
                $texto = 'Em Transporte';
                $valor->status='1';
            }else{
                $texto = 'Em Leilão';
                $valor->status='0';
                $editar = true;
            }
            $tabela['Funções'][$i]      =/* '<span id="status'.$valor->id.'">'.*/$Visual->Tema_Elementos_Btn('Status'.$valor->status     ,Array($texto        ,'Transporte/Carga/Status/'.$valor->id.'/'    ,''))/*.'</span>'*/;
            /*if($valor->destaque==1){
                $texto = 'Em Destaque';
            }else{
                $texto = 'Não está em destaque';
            }
            $tabela['Funções'][$i]      .= '<span id="destaques'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Destaque'.$valor->destaque   ,Array($texto   ,'Transporte/Carga/Destaques/'.$valor->id.'/'    ,'')).'</span>';
            */
            if($editar===true){
                $tabela['Funções'][$i]      .= $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Transporte de Carga'        ,'Transporte/Carga/Cargas_Edit/'.$valor->id.'/'    ,'')).
                                           $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Transporte de Carga'       ,'Transporte/Carga/Cargas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Transporte de Carga ?'));
            }
            ++$i;
        }
        return Array($tabela,$i);
    }
    
    /**
     * Listagem das Cargas Criadas pelo Usuario
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cargas($export=false){
        $i = 0;
        self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Transporte de Carga',
                'Transporte/Carga/Cargas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Carga/Cargas',
            )
        )));
        $carga = $this->_Modelo->db->Sql_Select('Transporte_Carga','{sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($carga)) $carga = Array(0=>$carga);
        if($carga!==false && !empty($carga)){
            list($tabela,$i) = self::Cargas_Tabela($carga,false);
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Meus Transportes de Carga');
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
                $mensagem = 'Nenhum Transporte de Carga Cadastrada para exportar';
            }else{
                $mensagem = 'Nenhum Transporte de Carga Cadastrada';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem de Transportes de Cargas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Listagem de Cargas');
    }
    /**
     * Listagem das Cargas Criadas pelo Usuario
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cargas_Add(){
        self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Adicionar Transporte de Carga';
        $titulo2    = 'Salvar Transporte de Carga';
        $formid     = 'formTransporte_Carga_Noticia';
        $formbt     = 'Salvar';
        $formlink   = 'Transporte/Carga/Cargas_Add2/';
        $campos = Transporte_Carga_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * Listagem das Cargas Criadas pelo Usuario
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cargas_Add2(){
        $titulo     = 'Transporte de Carga Adicionado com Sucesso';
        $dao        = 'Transporte_Carga';
        $funcao     = '$this->Cargas();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Transporte de Carga cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * Listagem das Cargas Criadas pelo Usuario
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cargas_Edit($id){
        self::Endereco_Noticia(true);
        // Carrega Config
        $titulo1    = 'Editar Transporte de Carga (#'.$id.')';
        $titulo2    = 'Alteração de Transporte de Carga';
        $formid     = 'formTransporte_CargaC_NoticiaEdit';
        $formbt     = 'Alterar Transporte de Carga';
        $formlink   = 'Transporte/Carga/Cargas_Edit2/'.$id;
        $editar    =  $this->_Modelo->db->Sql_Select('Transporte_Carga', Array('id'=>$id,'log_user_add'=>  $this->_Acl->Usuario_GetID()));
        if(!is_object($editar)){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Você não Possue essa Carga'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            exit;
        }
        $campos = Transporte_Carga_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * Listagem das Cargas Criadas pelo Usuario
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cargas_Edit2($id){
        $id = (int) $id;
        $titulo     = 'Transporte de Carga Alterado com Sucesso';
        $dao        = Array('Transporte_Carga',$id);
        $funcao     = '$this->Cargas();';
        $sucesso1   = 'Transporte de Carga Alterado com Sucesso';
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * Listagem das Cargas Criadas pelo Usuario
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cargas_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa Transporte e deleta
        $carga    =  $this->_Modelo->db->Sql_Select('Transporte_Carga', Array('id'=>$id,'log_user_add'=>  $this->_Acl->Usuario_GetID()));
        $sucesso =  $this->_Modelo->db->Sql_Delete($carga);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Transporte de Carga Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Cargas();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Transporte de Carga deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }/*
    public function Status($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Carga', Array('id'=>$id),1);
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
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Transporte/Carga/Status/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo','Status Alterado'); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo','Erro'); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Destaques($id=false){
        if($id===false){
            throw new \Exception('Registro não informado:'. $raiz, 404);
        }
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Carga', Array('id'=>$id),1);
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
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Destaque'.$resultado->destaque     ,Array($texto        ,'Transporte/Carga/Destaques/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo','Destaque Alterado'); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => 'Erro',
                "mgs_secundaria"    => 'Ocorreu um Erro.'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo','Erro'); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }*/
    static function Leilao_Transportadora_Tabela(&$carga,$show_usuario=true){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $editar = false;
        $i = 0;
        if(is_object($carga)) $carga = Array(0=>$carga);reset($carga);
        foreach ($carga as &$valor) {                
            $tabela['Id'][$i]           = '#'.$valor->id;
            $tabela['Foto'][$i]         = '<img src="'.$valor->foto.'" style="max-width:100px;" />';
            $tabela['Carga'][$i]       = $valor->nome;
            if($valor->status==3 || $valor->status=='3'){
                $texto = 'Entregue';
                $valor->status='3';
            }else if($valor->status==2 || $valor->status=='2'){
                $texto = 'Em Armazenamento';
                $valor->status='2';
            }else if($valor->status==1 || $valor->status=='1'){
                $texto = 'Em Transporte';
                $valor->status='1';
            }else{
                $texto = 'Em Leilão';
                $valor->status='0';
                $editar = true;
            }
            $tabela['Funções'][$i]      =/* '<span id="status'.$valor->id.'">'.*/$Visual->Tema_Elementos_Btn('Status'.$valor->status     ,Array($texto        ,'Transporte/Carga/Status/'.$valor->id.'/'    ,''))/*.'</span>'*/;
            /*if($valor->destaque==1){
                $texto = 'Em Destaque';
            }else{
                $texto = 'Não está em destaque';
            }
            $tabela['Funções'][$i]      .= '<span id="destaques'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Destaque'.$valor->destaque   ,Array($texto   ,'Transporte/Carga/Destaques/'.$valor->id.'/'    ,'')).'</span>';
            */
            if($editar===true){
                $tabela['Funções'][$i]      .= $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Transporte de Carga'        ,'Transporte/Carga/Leilao_Transportadora_Edit/'.$valor->id.'/'    ,'')).
                                           $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Transporte de Carga'       ,'Transporte/Carga/Leilao_Transportadora_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Transporte de Carga ?'));
            }
            ++$i;
        }
        return Array($tabela,$i);
    }
    
    /**
     * Listagem das Leilao_Transportadora Criadas pelo Usuario
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Leilao_Transportadora($export=false){
        $i = 0;
        self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Transporte de Carga',
                'Transporte/Carga/Leilao_Transportadora_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Carga/Leilao_Transportadora',
            )
        )));
        $carga = $this->_Modelo->db->Sql_Select('Transporte_Carga','{sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($carga)) $carga = Array(0=>$carga);
        if($carga!==false && !empty($carga)){
            list($tabela,$i) = self::Leilao_Transportadora_Tabela($carga,false);
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Meus Transportes de Carga');
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
                $mensagem = 'Nenhum Transporte de Carga Cadastrada para exportar';
            }else{
                $mensagem = 'Nenhum Transporte de Carga Cadastrada';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem de Transportes de Leilao_Transportadora ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Listagem de Leilao_Transportadora');
    }
    static function Leilao_Caminhoneiro_Tabela(&$carga,$show_usuario=true){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $editar = false;
        $i = 0;
        if(is_object($carga)) $carga = Array(0=>$carga);reset($carga);
        foreach ($carga as &$valor) {                
            $tabela['Id'][$i]           = '#'.$valor->id;
            $tabela['Foto'][$i]         = '<img src="'.$valor->foto.'" style="max-width:100px;" />';
            $tabela['Carga'][$i]       = $valor->nome;
            if($valor->status==3 || $valor->status=='3'){
                $texto = 'Entregue';
                $valor->status='3';
            }else if($valor->status==2 || $valor->status=='2'){
                $texto = 'Em Armazenamento';
                $valor->status='2';
            }else if($valor->status==1 || $valor->status=='1'){
                $texto = 'Em Transporte';
                $valor->status='1';
            }else{
                $texto = 'Em Leilão';
                $valor->status='0';
                $editar = true;
            }
            $tabela['Funções'][$i]      =/* '<span id="status'.$valor->id.'">'.*/$Visual->Tema_Elementos_Btn('Status'.$valor->status     ,Array($texto        ,'Transporte/Carga/Status/'.$valor->id.'/'    ,''))/*.'</span>'*/;
            /*if($valor->destaque==1){
                $texto = 'Em Destaque';
            }else{
                $texto = 'Não está em destaque';
            }
            $tabela['Funções'][$i]      .= '<span id="destaques'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Destaque'.$valor->destaque   ,Array($texto   ,'Transporte/Carga/Destaques/'.$valor->id.'/'    ,'')).'</span>';
            */
            if($editar===true){
                $tabela['Funções'][$i]      .= $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Transporte de Carga'        ,'Transporte/Carga/Leilao_Caminhoneiro_Edit/'.$valor->id.'/'    ,'')).
                                           $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Transporte de Carga'       ,'Transporte/Carga/Leilao_Caminhoneiro_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Transporte de Carga ?'));
            }
            ++$i;
        }
        return Array($tabela,$i);
    }
    
    /**
     * Listagem das Leilao_Caminhoneiro Criadas pelo Usuario
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Leilao_Caminhoneiro($export=false){
        $i = 0;
        self::Endereco_Noticia(false);
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Transporte de Carga',
                'Transporte/Carga/Leilao_Caminhoneiro_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Transporte/Carga/Leilao_Caminhoneiro',
            )
        )));
        $carga = $this->_Modelo->db->Sql_Select('Transporte_Carga','{sigla}log_user_add=\''.$this->_Acl->Usuario_GetID().'\'');
        if(is_object($carga)) $carga = Array(0=>$carga);
        if($carga!==false && !empty($carga)){
            list($tabela,$i) = self::Leilao_Caminhoneiro_Tabela($carga,false);
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Meus Transportes de Carga');
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
                $mensagem = 'Nenhum Transporte de Carga Cadastrada para exportar';
            }else{
                $mensagem = 'Nenhum Transporte de Carga Cadastrada';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem de Transportes de Leilao_Caminhoneiro ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Listagem de Leilao_Caminhoneiro');
    }
}
?>
