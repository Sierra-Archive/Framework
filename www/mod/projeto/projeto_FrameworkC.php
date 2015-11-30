<?php
class projeto_FrameworkControle extends projeto_Controle
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
    protected function Endereco_Modulo($true=true){
        if($true===true){
            $this->Tema_Endereco('Modulos','projeto/Framework/Modulos');
        }else{
            $this->Tema_Endereco('Modulos');
        }
    }
    static function Modulos_Tabela($modulos){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($modulos)) $modulos = Array(0=>$modulos);
        reset($modulos);
        foreach ($modulos as $indice=>&$valor) {
            $tabela['#Id'][$i]          =   '#'.$valor->id;
            $tabela['Submodulo'][$i]    =   $valor->submodulo2;
            $tabela['Nome'][$i]         =   $valor->nome;
            $tabela['Funções'][$i]      =   $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Modulo'        ,'projeto/Framework/Modulos_Edit/'.$valor->id.'/'    ,'')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Modulo'       ,'projeto/Framework/Modulos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Modulo ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Modulos($export=false){
        $this->Endereco_Modulos(false);
        $i = 0;
        // Add BOtao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Modulo',
                'projeto/Framework/Modulos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'projeto/Framework/Modulos',
            )
        )));
        // Query
        $modulos = $this->_Modelo->db->Sql_Select('Framework_Modulo');
        if($modulos!==false && !empty($modulos)){
            list($tabela,$i) = self::Modulos_Tabela($modulos);
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Modulos');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Modulo</font></b></center>');
        }
        $titulo = 'Listagem de Modulos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Modulos');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Modulos_Add(){
        $this->Endereco_Modulo();
        // Carrega Config
        $titulo1    = 'Adicionar Modulo';
        $titulo2    = 'Salvar Modulo';
        $formid     = 'form_projeto_Framework_Modulos_Add';
        $formbt     = 'Salvar';
        $formlink   = 'projeto/Modulo/Modulos_Add2/';
        $campos = Framework_Modulo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Modulos_Add2(){
        $titulo     = 'Modulo Adicionado com Sucesso';
        $dao        = 'Framework_Modulo';
        $funcao     = '$this->Modulos();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Modulo cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Modulos_Edit($id){
        $this->Endereco_Modulo();
        // Carrega Config
        $titulo1    = 'Editar Modulo (#'.$id.')';
        $titulo2    = 'Alteração de Modulo';
        $formid     = 'form_projeto_Framework_Modulos_Edit';
        $formbt     = 'Alterar Modulo';
        $formlink   = 'projeto/Framework/Modulos_Edit2/'.$id;
        $editar     = Array('Framework_Modulo',$id);
        $campos = Framework_Modulo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Modulos_Edit2($id){
        $titulo     = 'Modulo Editado com Sucesso';
        $dao        = Array('Framework_Modulo',$id);
        $funcao     = '$this->Modulos();';
        $sucesso1   = 'Modulo Alterado com Sucesso.';
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
    public function Modulos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $modulos = $this->_Modelo->db->Sql_Select('Framework_Modulo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($modulos);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Modulo Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Modulos();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Modulo deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    
    
    protected function Endereco_Submodulo($true=true){
        if($true===true){
            $this->Tema_Endereco('Submodulos','projeto/Framework/Submodulos');
        }else{
            $this->Tema_Endereco('Submodulos');
        }
    }
    static function Submodulos_Tabela($submodulos){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($submodulos)) $submodulos = Array(0=>$submodulos);
        reset($submodulos);
        foreach ($submodulos as $indice=>&$valor) {
            $tabela['#Id'][$i]          =   '#'.$valor->id;
            $tabela['Modulo'][$i]       =   $valor->modulo2;
            $tabela['Nome'][$i]         =   $valor->nome;
            $tabela['Funções'][$i]      =   $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Submodulo'        ,'projeto/Framework/Submodulos_Edit/'.$valor->id.'/'    ,'')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Submodulo'       ,'projeto/Framework/Submodulos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Submodulo ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Submodulos($export=false){
        $this->Endereco_Submodulos(false);
        $i = 0;
        // Add BOtao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Submodulo',
                'projeto/Framework/Submodulos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'projeto/Framework/Submodulos',
            )
        )));
        // Query
        $submodulos = $this->_Modelo->db->Sql_Select('Framework_Submodulo');
        if($submodulos!==false && !empty($submodulos)){
            list($tabela,$i) = self::Submodulos_Tabela($submodulos);
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Submodulos');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Submodulo</font></b></center>');
        }
        $titulo = 'Listagem de Submodulos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Submodulos');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Submodulos_Add(){
        $this->Endereco_Submodulo();
        // Carrega Config
        $titulo1    = 'Adicionar Submodulo';
        $titulo2    = 'Salvar Submodulo';
        $formid     = 'form_projeto_Framework_Submodulos_Add';
        $formbt     = 'Salvar';
        $formlink   = 'projeto/Submodulo/Submodulos_Add2/';
        $campos = Framework_Submodulo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Submodulos_Add2(){
        $titulo     = 'Submodulo Adicionado com Sucesso';
        $dao        = 'Framework_Submodulo';
        $funcao     = '$this->Submodulos();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Submodulo cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Submodulos_Edit($id){
        $this->Endereco_Submodulo();
        // Carrega Config
        $titulo1    = 'Editar Submodulo (#'.$id.')';
        $titulo2    = 'Alteração de Submodulo';
        $formid     = 'form_projeto_Framework_Submodulos_Edit';
        $formbt     = 'Alterar Submodulo';
        $formlink   = 'projeto/Framework/Submodulos_Edit2/'.$id;
        $editar     = Array('Framework_Submodulo',$id);
        $campos = Framework_Submodulo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Submodulos_Edit2($id){
        $titulo     = 'Submodulo Editado com Sucesso';
        $dao        = Array('Framework_Submodulo',$id);
        $funcao     = '$this->Submodulos();';
        $sucesso1   = 'Submodulo Alterado com Sucesso.';
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
    public function Submodulos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $submodulos = $this->_Modelo->db->Sql_Select('Framework_Submodulo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($submodulos);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Submodulo Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Submodulos();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Submodulo deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    
    
    protected function Endereco_Metodo($true=true){
        if($true===true){
            $this->Tema_Endereco('Metodos','projeto/Framework/Metodos');
        }else{
            $this->Tema_Endereco('Metodos');
        }
    }
    static function Metodos_Tabela($metodos){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($metodos)) $metodos = Array(0=>$metodos);
        reset($metodos);
        foreach ($metodos as $indice=>&$valor) {
            $tabela['#Id'][$i]          =   '#'.$valor->id;
            $tabela['Nome'][$i]         =   $valor->nome;
            $tabela['Funções'][$i]      =   $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Metodo'        ,'projeto/Framework/Metodos_Edit/'.$valor->id.'/'    ,'')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Metodo'       ,'projeto/Framework/Metodos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Metodo ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Metodos($export=false){
        $this->Endereco_Metodos(false);
        $i = 0;
        // Add BOtao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Metodo',
                'projeto/Framework/Metodos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'projeto/Framework/Metodos',
            )
        )));
        // Query
        $metodos = $this->_Modelo->db->Sql_Select('Framework_Metodo');
        if($metodos!==false && !empty($metodos)){
            list($tabela,$i) = self::Metodos_Tabela($metodos);
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Metodos');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Metodo</font></b></center>');
        }
        $titulo = 'Listagem de Metodos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Metodos');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Metodos_Add(){
        $this->Endereco_Metodo();
        // Carrega Config
        $titulo1    = 'Adicionar Metodo';
        $titulo2    = 'Salvar Metodo';
        $formid     = 'form_projeto_Framework_Metodos_Add';
        $formbt     = 'Salvar';
        $formlink   = 'projeto/Metodo/Metodos_Add2/';
        $campos = Framework_Metodo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Metodos_Add2(){
        $titulo     = 'Metodo Adicionado com Sucesso';
        $dao        = 'Framework_Metodo';
        $funcao     = '$this->Metodos();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Metodo cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Metodos_Edit($id){
        $this->Endereco_Metodo();
        // Carrega Config
        $titulo1    = 'Editar Metodo (#'.$id.')';
        $titulo2    = 'Alteração de Metodo';
        $formid     = 'form_projeto_Framework_Metodos_Edit';
        $formbt     = 'Alterar Metodo';
        $formlink   = 'projeto/Framework/Metodos_Edit2/'.$id;
        $editar     = Array('Framework_Metodo',$id);
        $campos = Framework_Metodo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Metodos_Edit2($id){
        $titulo     = 'Metodo Editado com Sucesso';
        $dao        = Array('Framework_Metodo',$id);
        $funcao     = '$this->Metodos();';
        $sucesso1   = 'Metodo Alterado com Sucesso.';
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
    public function Metodos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $metodos = $this->_Modelo->db->Sql_Select('Framework_Metodo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($metodos);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Metodo Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Metodos();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Metodo deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
