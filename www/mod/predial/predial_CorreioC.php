<?php
class predial_CorreioControle extends predial_Controle
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
    * @uses predial_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
    }
    static function Endereco_Correio($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Corrêios';
        $link = 'predial/Correio/Correios';
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    public function Correios_Baixar($correio=false){
        GLOBAl $language;
        self::Endereco_Correio();
        if($correio===false || $correio == 0) return false;
        $correio = (int) $correio;
        $where = Array(
            'id' => $correio
        );
        $correios = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Correio',$where);
        $correios->data_recebido = date('d/m/Y H:i:s');
        $sucesso = $this->_Modelo->db->Sql_Update($correios);
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Sucesso',
                "mgs_secundaria" => 'Correio declarado Recebido com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Recupera pagina atualiza
        $this->Correios();
        $this->_Visual->Json_Info_Update('Titulo', 'Correio declarado Recebido com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    static function Correios_Tabela(&$correios,$recebido=false){
        $registro   = \Framework\App\Registro::getInstacia();
        $Modelo     = &$registro->_Modelo;
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($correios)) $correios = Array(0=>$correios);
        reset($correios);
        foreach ($correios as &$valor) {
            $email = false;
            $enviar = false;
            $apartamento  = $Modelo->db->Sql_Select(
                'Predial_Bloco_Apart', 
                Array(
                    'id'        =>  $valor->apart,
                    'bloco'        =>  $valor->bloco
                ),
                1,
                'id DESC'
            );
            if($apartamento!==false && is_int($apartamento->morador) && $apartamento->morador!=0){
                $usuario  = $Modelo->db->Sql_Select(
                    'Usuario', 
                    Array('id'=>$apartamento->morador),
                    1
                );
                if($usuario!==false){
                    $email = '';
                    if($usuario->email!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email)){
                        $email .= $usuario->email;
                    }
                    if($usuario->email2!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email2)){
                        if($email!='') $email .= '<br>';
                        $email .= $usuario->email2;
                    }
                    if($email==''){
                        $email = '<p class="text-error">Morador sem nenhum email válido</p>';
                    }
                }
            }
            // Avisa que nao foi, ou manda 
            if($email===false || $email==''){
                $email = '<p class="text-error">Morador não registrado</p>';
            }
            $tabela['Bloco'][$i]                        = $valor->bloco2;
            $tabela['Apartamento'][$i]                  = $valor->apart2;
            $tabela['Tipo de Correio'][$i]              = $valor->categoria2;
            $tabela['Responsável'][$i]                  = $valor->responsavel;
            $tabela['Email para Avisos'][$i]                  = $email;
            $tabela['Data Recebida Adm/Portaria'][$i]   = $valor->data_entregue;
            if($recebido!==false){
                $tabela['Data Entregue ao Morador'][$i]     = $valor->data_recebido;
                $tabela['Funções'][$i]                      = '';
            }else{
                $tabela['Funções'][$i]                      = $Visual->Tema_Elementos_Btn('Baixar'     ,Array('Declarar Recebido Pelo Morador'        ,'predial/Correio/Correios_Baixar/'.$valor->id.'/'    ,''));
            }
            $tabela['Funções'][$i]                      .=  $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Correio'        ,'predial/Correio/Correios_Edit/'.$valor->id.'/'    ,'')).
                                                            $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Correio'       ,'predial/Correio/Correios_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Correio ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    public function Correios(){
        self::Endereco_Correio(false);
        $this->Correios_Bloco(false, 10);
        $this->Correios_Bloco(true);
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Correios'); 
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    protected function Correios_Bloco($recebido=false,$gravidade=0){
        $i = 0;
        if($recebido===false){
            $titulo = 'Correios recebidos e não entregues';
            $where = Array(
                'data_recebido' => '0000-00-00 00:00:00'
            );
            // Botao Add
            $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
                Array(
                    'Adicionar Correio',
                    'predial/Correio/Correios_Add',
                    ''
                ),
                Array(
                    'Print'     => true,
                    'Pdf'       => true,
                    'Excel'     => true,
                    'Link'      => 'predial/Correio/Correios',
                )
            )));
        }else{
            $titulo = 'Histórico de Correios Entregues';
            $where = Array(
                '!data_recebido' => '0000-00-00 00:00:00'
            );
        }
        $correios = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Correio',$where);
        if($correios!==false && !empty($correios)){
            list($tabela,$i) = self::Correios_Tabela($correios,$recebido);
            $this->_Visual->Show_Tabela_DataTable($tabela);
        }else{     
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Correio</font></b></center>');
        }
        $titulo = 'Listagem de '.$titulo.' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',$gravidade);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar '.$titulo);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Correios_Add(){
        self::Endereco_Correio();
        // Carrega Config
        $titulo1    = 'Adicionar Correio';
        $titulo2    = 'Salvar Correio';
        $formid     = 'form_Sistema_Admin_Correios';
        $formbt     = 'Salvar';
        $formlink   = 'predial/Correio/Correios_Add2/';
        $campos = Predial_Bloco_Apart_Correio_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'data_recebido');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Correios_Add2(){
        //Validar_Email
        $titulo     = 'Correio Adicionado com Sucesso';
        $dao        = 'Predial_Bloco_Apart_Correio';
        $funcao     = '$this->Correios();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Correio cadastrado com sucesso.';
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        if($sucesso===true){
            // Pega o Correio
            $identificador  = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Correio', Array(),1,'id DESC');
            $identificador  = $identificador->id;
            // Captura Apartamento Responsavel
            $enviar = false;
            $apartamento  = $this->_Modelo->db->Sql_Select(
                'Predial_Bloco_Apart', 
                Array(
                    'id'        =>  $identificador->apart,
                    'bloco'        =>  $identificador->bloco
                ),
                1,
                'id DESC'
            );
            if(is_int($apartamento->morador) && $apartamento->morador!=0){
                $usuario  = $this->_Modelo->db->Sql_Select(
                    'Usuario', 
                    Array('id'=>$apartamento->morador),
                    1
                );
                if($usuario!==false){
                    $nome = $usuario->nome;
                    $enviar = '';
                    if($usuario->email!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email)){
                        $enviar .= '->setTo(\''.$usuario->email.'\', \''.$nome.'\')';
                    }
                    if($usuario->email2!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email2)){
                        $enviar .= '->setTo(\''.$usuario->email2.'\', \''.$nome.'\')';
                    }
                }
            }
            // Avisa que nao foi, ou manda 
            if($enviar===false || $enviar==''){
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => 'Aviso não Enviado',
                    "mgs_secundaria" => 'Verifique se o Morador está registrado no sistema e com um email válido.'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            }else{
                // Mandar Mensagem
                $mensagem   =   'Informamos que encontra-se na administração corrreio registrado<br>'.
                                '<b>Bloco / Apart:</b>'.$identificador->bloco.' / '.$identificador->apart.'<br>'.
                                '<b>Responsável:</b>'.$identificador->responsavel.'<br>'.
                                '<b>Data Entregue:</b>'.$identificador->data_entregue.'<br>';
                // Cadastra Aviso
                $aviso = new \Predial_Bloco_Apart_Correio_Aviso_DAO();
                $aviso->correio = $identificador;
                $aviso->mensagem = $mensagem;
                $this->_Modelo->bd->Sql_Inserir($aviso);
                // Manda Email
                eval('$send	= $mailer'.$enviar.'
                ->setSubject(\'Nova Encomenda (1Â° Aviso) - \'.SISTEMA_NOME)
                ->setFrom(SISTEMA_EMAIL, SISTEMA_NOME)
                ->addGenericHeader(\'X-Mailer\', \'PHP/\' . phpversion())
                ->addGenericHeader(\'Content-Type\', \'text/html; charset="utf-8"\')
                ->setMessage(\'<strong>'.$mensagem.'</strong>\')
                ->setWrap(78)->send();');
                if(!$send){
                    $mensagens = array(
                        "tipo" => 'erro',
                        "mgs_principal" => 'Aviso não Enviado',
                        "mgs_secundaria" => 'Verifique se o Morador está registrado no sistema e com um email válido.'
                    );
                    $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                }
            }
        }
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Correios_Edit($id){
        self::Endereco_Correio();
        // Carrega Config
        $titulo1    = 'Editar Correio (#'.$id.')';
        $titulo2    = 'Alteração de Correio';
        $formid     = 'form_Sistema_AdminC_CorreioEdit';
        $formbt     = 'Alterar Correio';
        $formlink   = 'predial/Correio/Correios_Edit2/'.$id;
        $editar     = Array('Predial_Bloco_Apart_Correio',$id);
        $campos = Predial_Bloco_Apart_Correio_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Correios_Edit2($id){
        $titulo     = 'Correio Editado com Sucesso';
        $dao        = Array('Predial_Bloco_Apart_Correio',$id);
        $funcao     = '$this->Correios();';
        $sucesso1   = 'Correio Alterado com Sucesso.';
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
    public function Correios_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $correio = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Correio', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($correio);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Correio deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Recupera pagina atualiza
        $this->Correios();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Correio deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    static function Personalizados_Tabela(&$correios,$recebido=false){
        $registro   = \Framework\App\Registro::getInstacia();
        $Modelo     = &$registro->_Modelo;
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($correios)) $correios = Array(0=>$correios);
        reset($correios);
        foreach ($correios as &$valor) {
            $tabela['Tipo de Correio'][$i]              = $valor->categoria2;
            $tabela['Responsável'][$i]                  = $valor->responsavel;
            $tabela['Data Recebida Adm/Portaria'][$i]   = $valor->data_entregue;
            if($recebido!==false){
                $tabela['Data Entregue ao Morador'][$i]     = $valor->data_recebido;
            }
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    static function Personalizados($apartamento,$recebido=false,$gravidade=0,$adicionar=true){
        $registro = \Framework\App\Registro::getInstacia();
        $i = 0;
        $html = '';
        if($recebido===false){
            $titulo = 'Correios recebidos e não entregues';
            $where = Array(
                'data_recebido' => '0000-00-00 00:00:00',
                'apart'         => $apartamento
            );
            // Botao Add
            $html .= $registro->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
                false,
                Array(
                    'Print'     => true,
                    'Pdf'       => true,
                    'Excel'     => true,
                    'Link'      => 'predial/Correio/Correios',
                )
            ));
        }else{
            $titulo = 'Histórico de Correios Entregues';
            $where = Array(
                '!data_recebido' => '0000-00-00 00:00:00',
                'apart'         => $apartamento
            );
        }
        $correios = $registro->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Correio',$where);
        if($correios!==false && !empty($correios)){
            list($tabela,$i) = self::Correios_Tabela($correios,$recebido);
            $html .= $registro->_Visual->Show_Tabela_DataTable($tabela,'',false);
        }else{     
            $html .= '<center><b><font color="#FF0000" size="3">Nenhum Correio para Você</font></b></center>';
        }
        $titulo = 'Listagem de '.$titulo.' ('.$i.')';
        return Array($titulo,$html);
    }
    
    
}
?>
