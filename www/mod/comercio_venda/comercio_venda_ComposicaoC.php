<?php
class comercio_venda_ComposicaoControle extends comercio_venda_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_venda_rede_ComposicaoModelo::Carrega Rede Modelo
    * @uses comercio_venda_rede_ComposicaoView::Carrega Rede View
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
     * FUNCAO PRINCIPAL, EXECUTA O PRIMEIRO PASSO 
     * 
     * @name Main
     * @access public
     * 
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Main(){
        return false;
    }
    static function Endereco_Composicao($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Cardápios';
        $link = 'comercio_venda/Composicao/Composicoes';
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
    public function Composicoes($export=false){
        self::Endereco_Composicao(false);
        $i = 0;
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Cardápio',
                'comercio_venda/Composicao/Composicoes_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio_venda/Composicao/Composicoes',
            )
        )));
        // CONEXAO
        $composicoes = $this->_Modelo->db->Sql_Select('Comercio_Venda_Composicao');
        $produtos_usados = $this->_Modelo->db->Sql_Select('Comercio_Venda_Composicao_Produtos');
        $produtos_usados_array = Array();
        if($produtos_usados!==false && !empty($produtos_usados)){
            if(is_object($produtos_usados)) $produtos_usados = Array(0=>$produtos_usados);
            reset($produtos_usados);
            foreach ($produtos_usados as $indice=>&$valor) {
                $arry = &$produtos_usados_array[$valor->composicao];
                if(!isset($arry) || $arry===''){
                    $arry = '';
                }else{
                    $arry .= '<br>';
                }
                $arry .= '<b>'.$valor->produto2.'</b> (x'.$valor->qnt.')';
            }
        }
        if($composicoes!==false && !empty($composicoes)){
            if(is_object($composicoes)) $composicoes = Array(0=>$composicoes);
            reset($composicoes);
            foreach ($composicoes as $indice=>&$valor) {
                $tabela['#Id'][$i]       = '#'.$valor->id;
                if($valor->foto==='' || $valor->foto===false){
                    $foto = WEB_URL.'img'.US.'icons'.US.'clientes.png';
                }else{
                    $foto = $valor->foto;
                }
                $tabela['Foto'][$i]      = '<img src="'.$foto.'" style="max-width:100px;" />';
                $tabela['Nome'][$i]      = $valor->nome;
                $tabela['Descrição'][$i] = $valor->descricao;
                $tabela['Produtos Usados'][$i] = $produtos_usados_array[$valor->id];
                $tabela['Preço'][$i]     = $valor->preco;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Cardápio'        ,'comercio_venda/Composicao/Composicoes_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Cardápio'       ,'comercio_venda/Composicao/Composicoes_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Cardápio ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Comercio Vendas - Cardápios');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Cardápio</font></b></center>');
        }
        $titulo = 'Listagem de Cardápios ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Cardápios'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Composicoes_Add(){
        self::Endereco_Composicao(true);
        // Carrega Config
        $titulo1    = 'Adicionar Cardápio';
        $titulo2    = 'Salvar Cardápio';
        $formid     = 'form_Sistema_Admin_Composicoes';
        $formbt     = 'Salvar';
        $formlink   = 'comercio_venda/Composicao/Composicoes_Add2/';
        
        $campos = Comercio_Venda_Composicao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Composicoes_Add2(){
        $titulo     = 'Cardápio Adicionado com Sucesso';
        $dao        = 'Comercio_Venda_Composicao';
        $funcao     = '$this->Composicoes();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Cardápio cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Composicoes_Edit($id){
        self::Endereco_Composicao(true);
        // Carrega Config
        $titulo1    = 'Editar Cardápio (#'.$id.')';
        $titulo2    = 'Alteração de Cardápio';
        $formid     = 'form_Sistema_AdminC_ComposicaoEdit';
        $formbt     = 'Alterar Cardápio';
        $formlink   = 'comercio_venda/Composicao/Composicoes_Edit2/'.$id;
        $editar     = Array('Comercio_Venda_Composicao',$id);
        $campos = Comercio_Venda_Composicao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Composicoes_Edit2($id){
        $titulo     = 'Cardápio Editado com Sucesso';
        $dao        = Array('Comercio_Venda_Composicao',$id);
        $funcao     = '$this->Composicoes();';
        $sucesso1   = 'Cardápio Alterado com Sucesso.';
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
    public function Composicoes_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Comercio_Venda_Composicao', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Cardápio Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Composicoes();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Cardápio deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>