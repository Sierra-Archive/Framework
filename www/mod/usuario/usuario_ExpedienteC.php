<?php
class usuario_ExpedienteControle extends usuario_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_rede_PerfilModelo::Carrega Rede Modelo
    * @uses usuario_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
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
    * @uses usuario_Controle::$acoesPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function Main(){
        return false; 
    }
    static function Endereco_Expediente($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(__('Expediente'),'usuario/Expediente/Expediente');
        }else{
            $_Controle->Tema_Endereco(__('Expediente'));
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Expediente($export=false){
        self::Endereco_Expediente(false);
        $i = 0;
        // add botao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Expediente',
                'usuario/Expediente/Expedientes_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario/Expediente/Expedientes',
            )
        )));
        $expedientes = $this->_Modelo->db->Sql_Select('Usuario_Expediente');
        if($expedientes!==false && !empty($expedientes)){
            if(is_object($expedientes)) $expedientes = Array(0=>$expedientes);
            reset($expedientes);
            foreach ($expedientes as $indice=>&$valor) {
                $tabela['Pessoa'][$i]           = $valor->persona2;
                $tabela['Numero'][$i]           = $valor->expediente;
                $tabela['Obs'][$i]              = $valor->obs;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Expediente'        ,'usuario/Expediente/Expedientes_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Expediente'       ,'usuario/Expediente/Expedientes_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Expediente ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Expedientes');
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
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Expediente</font></b></center>');
        }
        $titulo = __('Listagem de Expedientes').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10);

        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Expedientes'));
    }
    public static function Expedientes_Campos_Remover(&$campos){
        self::DAO_Campos_Retira($campos, 'qnt');
        self::DAO_Campos_Retira($campos, 'status');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Expedientes_Add(){
        self::Endereco_Expediente();
        // Carrega Config
        $titulo1    = __('Adicionar Expediente');
        $titulo2    = __('Salvar Expediente');
        $formid     = 'form_Sistema_Expediente_Expedientes';
        $formbt     = __('Salvar');
        $formlink   = 'usuario/Expediente/Expedientes_Add2/';
        $campos = Usuario_Expediente_DAO::Get_Colunas();
        self::Expedientes_Campos_Remover($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Expedientes_Add2(){
        $titulo     = __('Expediente adicionada com Sucesso');
        $dao        = 'Usuario_Expediente';
        $funcao     = '$this->Expediente();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Expediente cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Expedientes_Edit($id){
        self::Endereco_Expediente();
        // Carrega Config
        $titulo1    = 'Editar Expediente (#'.$id.')';
        $titulo2    = __('Alteração de Expediente');
        $formid     = 'form_Sistema_ExpedienteC_ExpedienteEdit';
        $formbt     = __('Alterar Expediente');
        $formlink   = 'usuario/Expediente/Expedientes_Edit2/'.$id;
        $editar     = Array('Usuario_Expediente',$id);
        $campos = Usuario_Expediente_DAO::Get_Colunas();
        self::Expedientes_Campos_Remover($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Expedientes_Edit2($id){
        $titulo     = __('Expediente editada com Sucesso');
        $dao        = Array('Usuario_Expediente',$id);
        $funcao     = '$this->Expediente();';
        $sucesso1   = __('Expediente Alterado com Sucesso.');
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
    public function Expedientes_Del($id){
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Expediente', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Expediente deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Expediente();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Expediente deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public static function Disponivel($tipobloco='Unico'){
        $Registro = Framework\App\Registro::getInstacia();

        $tabela_colunas = Array();

        $tabela_colunas[] = __('Id');
        $tabela_colunas[] = __('Funcionário');
        $tabela_colunas[] = __('Inicio');
        $tabela_colunas[] = __('Fim');
        $tabela_colunas[] = __('Status');
        $tabela_colunas[] = __('Funções');

        
        // Inserir Expediente
        $html = '';
        $Registro->_Modelo->db->Sql_Select('Usuario');
        $Registro->_Modelo->db->Sql_Select('Usuario_Expediente','');
        $Registro->_Visual->Blocar($tabela_colunas,$html);
        
        
        
        $Registro->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'usuario/Expediente/Expedientes');
        $titulo = __('Disponiveis').' (<span id="DataTable_Contador">0</span>)';        
        if($tipobloco==='Unico'){
            $Registro->_Visual->Bloco_Unico_CriaJanela($titulo,'',100,Array("link"=>"usuario/Expediente/Expedientes_Add",'icon'=>'add','nome'=>__('Adicionar Expediente')));
        }else if($tipobloco==='Maior'){
            $Registro->_Visual->Bloco_Maior_CriaJanela($titulo,'',100,Array("link"=>"usuario/Expediente/Expedientes_Add",'icon'=>'add','nome'=>__('Adicionar Expediente')));
        }else{
            $Registro->_Visual->Bloco_Menor_CriaJanela($titulo,'',100,Array("link"=>"usuario/Expediente/Expedientes_Add",'icon'=>'add','nome'=>__('Adicionar Expediente')));
        }
        
        return true;
    }
}
?>
