<?php
class Agenda_PastaControle extends Agenda_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Agenda_ListarModelo Carrega Agenda Modelo
    * @uses Agenda_ListarVisual Carrega Agenda Visual
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
    * @uses Agenda_Controle::$AgendaPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        $this->Pastas();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Pastas'); 
    }
    protected function Endereco_Pasta($true=true){
        if($true===true){
            $this->Tema_Endereco('Pastas','Agenda/Pasta/Pastas');
        }else{
            $this->Tema_Endereco('Pastas');
        }
    }
    protected function Endereco_Cor($true=true){
        $this->Endereco_Pasta();
        if($true===true){
            $this->Tema_Endereco('Cores','Agenda/Pasta/Cores');
        }else{
            $this->Tema_Endereco('Cores');
        }
    }
    static function Pastas_Tabela($pastas){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($pastas)) $pastas = Array(0=>$pastas);
        reset($pastas);
        foreach ($pastas as $indice=>&$valor) {
            //$tabela['#Id'][$i]       = '#'.$valor->id;
            $tabela['Tipo de Pasta'][$i]        =   $valor->categoria2;
            $tabela['Cor'][$i]                  =   $valor->cor2;
            $tabela['Número'][$i]               =   $valor->num;
            $tabela['Nome'][$i]                 =   $valor->nome;
            $tabela['Observação'][$i]           =   $valor->obs;
            $tabela['Funções'][$i]              =   $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Pasta'        ,'Agenda/Pasta/Pastas_Edit/'.$valor->id.'/'    ,'')).
                                                    $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Pasta'       ,'Agenda/Pasta/Pastas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Pasta ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Pastas($export=false){
        $this->Endereco_Pasta(false);
        self::Pastas_Listar($export,$this->_Modelo,$this->_Visual);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Arquivo de Pastas');
    }
    static function Pastas_Listar($export=false,&$Modelo,&$Visual,$tipo='Unico'){
        $i = 0;
        // Botao Add
        $Visual->Blocar($Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Pasta',
                'Agenda/Pasta/Pastas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Agenda/Pasta/Pastas',
            )
        )));
        $pastas = $Modelo->db->Sql_Select('Usuario_Agenda_Pasta');
        if($pastas!==false && !empty($pastas)){
            list($tabela,$i) = self::Pastas_Tabela($pastas);
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Pastas');
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
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Pasta no Arquivo de Pastas</font></b></center>');
        }
        $titulo = 'Arquivo de Pastas ('.$i.')';
        if($tipo==='Unico'){
            $Visual->Bloco_Unico_CriaJanela($titulo);
        }else{
            $Visual->Bloco_Maior_CriaJanela($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Pastas_Add(){ 
        $this->Endereco_Pasta();  
        // Carrega Config
        $titulo1    = 'Adicionar Pasta';
        $titulo2    = 'Salvar Pasta';
        $formid     = 'form_Sistema_Admin_Pastas';
        $formbt     = 'Salvar';
        $formlink   = 'Agenda/Pasta/Pastas_Add2/';
        $campos = Usuario_Agenda_Pasta_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Pastas_Add2(){
        $titulo     = 'Pasta Adicionado com Sucesso';
        $dao        = 'Usuario_Agenda_Pasta';
        $funcao     = '$this->Pastas();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Pasta cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Pastas_Edit($id){
        $this->Endereco_Pasta();
        // Carrega Config
        $titulo1    = 'Editar Pasta (#'.$id.')';
        $titulo2    = 'Alteração de Pasta';
        $formid     = 'form_Sistema_AdminC_PastaEdit';
        $formbt     = 'Alterar Pasta';
        $formlink   = 'Agenda/Pasta/Pastas_Edit2/'.$id;
        $editar     = Array('Usuario_Agenda_Pasta',$id);
        $campos = Usuario_Agenda_Pasta_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Pastas_Edit2($id){
        $titulo     = 'Pasta Editado com Sucesso';
        $dao        = Array('Usuario_Agenda_Pasta',$id);
        $funcao     = '$this->Pastas();';
        $sucesso1   = 'Pasta Alterado com Sucesso.';
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Pastas_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa pasta e deleta
        $pasta = $this->_Modelo->db->Sql_Select('Usuario_Agenda_Pasta', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($pasta);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Pasta Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Pastas();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Pasta deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cores($export=false){
        $this->Endereco_Cor(false);
        $i = 0;
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Cor',
                'Agenda/Pasta/Cores_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'Agenda/Pasta/Cores',
            )
        )));
        // Conexao
        $cores = $this->_Modelo->db->Sql_Select('Usuario_Agenda_Pasta_Cor');
        if($cores!==false && !empty($cores)){
            if(is_object($cores)) $cores = Array(0=>$cores);
            reset($cores);
            foreach ($cores as $indice=>&$valor) {
                //$tabela['#Id'][$i]       = '#'.$valor->id;
                $tabela['Nome'][$i]      = $valor->nome;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Cor'        ,'Agenda/Pasta/Cores_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Cor'       ,'Agenda/Pasta/Cores_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Cor ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Cores');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Cor</font></b></center>');
        }
        $titulo = 'Listagem de Cores ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Cores');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cores_Add(){
        $this->Endereco_Cor();
        // Carrega Config
        $titulo1    = 'Adicionar Cor';
        $titulo2    = 'Salvar Cor';
        $formid     = 'form_Sistema_Admin_Cores';
        $formbt     = 'Salvar';
        $formlink   = 'Agenda/Pasta/Cores_Add2/';
        $campos = Usuario_Agenda_Pasta_Cor_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cores_Add2(){
        $titulo     = 'Cor Adicionada com Sucesso';
        $dao        = 'Usuario_Agenda_Pasta_Cor';
        $funcao     = '$this->Cores();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Cor cadastrada com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cores_Edit($id){
        $this->Endereco_Cor();
        // Carrega Config
        $titulo1    = 'Editar Cor (#'.$id.')';
        $titulo2    = 'Alteração de Cor';
        $formid     = 'form_Sistema_AdminC_CorEdit';
        $formbt     = 'Alterar Cor';
        $formlink   = 'Agenda/Pasta/Cores_Edit2/'.$id;
        $editar     = Array('Usuario_Agenda_Pasta_Cor',$id);
        $campos = Usuario_Agenda_Pasta_Cor_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cores_Edit2($id){
        $titulo     = 'Cor Editada com Sucesso';
        $dao        = Array('Usuario_Agenda_Pasta_Cor',$id);
        $funcao     = '$this->Cores();';
        $sucesso1   = 'Cor Alterada com Sucesso.';
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Cores_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa pasta e deleta
        $pasta = $this->_Modelo->db->Sql_Select('Usuario_Agenda_Pasta_Cor', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($pasta);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletada',
                "mgs_secundaria" => 'Cor Deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Cores();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Cor deletada com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
