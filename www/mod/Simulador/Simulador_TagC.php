<?php
class Simulador_TagControle extends Simulador_Controle
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
    * @uses tag_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Simulador/Tag/Tags');
        return false;
    }
    static function Endereco_Tag($true=true){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(__('Tag'),'Simulador/Tag/Tags');
        }else{
            $_Controle->Tema_Endereco(__('Tag'));
        }
    }
    static function Tags_Tabela(&$tags){
        $funcao = '';
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Controle     = &$Registro->_Controle;
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if($tags!==false){
            // Percorre Tags
            if(is_object($tags)) $tags = Array(0=>$tags);
            reset($tags);
            if(!empty($tags)){
                $perm_editar = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Edit');
                $perm_del = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Del');

                foreach ($tags as &$valor) {
                    $tabela['Id'][$i]    = $valor->id;
                    $tabela['Nome'][$i]      = $valor->nome;
                    $tabela['Tipo de Resultado'][$i]      = $valor->resultado_tipo;
                    $tabela['Observação'][$i]      = $valor->obs;
                    
                    $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Caracteristica')        ,'Simulador/Tag/Tags_Edit/'.$valor->id.'/'.$raiz    ,''),$perm_editar).
                                                      $Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Caracteristica')       ,'Simulador/Tag/Tags_Del/'.$valor->id.'/'.$raiz     ,__('Deseja realmente deletar essa Caracteristica ?')),$perm_del);

                    $funcao .= $tabela['Funções'][$i];
                    ++$i;
                }
            }
        }
        if($funcao===''){
            unset($tabela['Funções']);
        }
        // Desconta Primeiro Registro
        if($raiz!==false && $raiz!=0){
            $i = $i-1;
        }
        // Retorna List
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tags($raiz = false){
        self::Endereco_Tag(false);
        
        // Processa Tag
        list($titulo,$html,$i) = $this->Tags_Processar($raiz);
        $this->_Visual->Blocar($html);
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,Array("link"=>"Simulador/Tag/Tags_Add",'icon'=>'add','nome'=>__('Adicionar Caracteristica')));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Listagem de Caracteristicas'));
    }
    private function Tags_Processar($raiz = false){
        return self::Tags_Processar_Static($raiz);
    }
    private static function Tags_Processar_Static(){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        $_Visual = &$Registro->_Visual;
        // Tag
        $endereco = __('Caracteristica');
        $i = 0;
        
        $tabela_colunas = Array();

        $tabela_colunas[] = __('Id');
        $tabela_colunas[] = __('Nome');
        $tabela_colunas[] = __('Tipo de Resultado');
        $tabela_colunas[] = __('Observação');
        $tabela_colunas[] = __('Funções');

        $html = $_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'Simulador/Tag/Tags','',false,false);
        
        $titulo = $endereco.' (<span id="DataTable_Contador">0</span>)';
        return Array($titulo,$html,$i);
    }
    /**
     * ADD SOMENTE PASTA
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tags_Add($raiz = 0){
        self::Endereco_Tag();
        // Carrega Config
        $titulo1    = __('Adicionar Caracteristica');
        $titulo2    = __('Salvar Caracteristicas');
        $formid     = 'form_Sistema_Admin_Tags';
        $formbt     = __('Salvar Caracteristica');
        $formlink   = 'Simulador/Tag/Tags_Add2/'.$raiz;
        $campos = Simulador_Tag_DAO::Get_Colunas();
        //self::DAO_Campos_Retira($campos, 'parent');
        // Chama Formulario
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * ADD SOMENTE PASTA
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tags_Add2($raiz = 0){
        $titulo     = __('Caracteristica Adicionada com Sucesso');
        $dao        = 'Simulador_Tag';
        $funcao     = '$this->Tags('.$raiz.');';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Caracteristica cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tags_Edit($id,$raiz=0){
        self::Endereco_Tag();
        // Recupera Caracteristica
        $resultado = $this->_Modelo->db->Sql_Select('Simulador_Tag', '{sigla}id=\''.$id.'\'',1);
        if($resultado===false){
            return _Sistema_erroControle::Erro_Fluxo('Essa Caracteristica não existe:'. $raiz,404);
        }
        // Carrega Config
        $titulo1    = 'Editar Caracteristica (#'.$id.')';
        $titulo2    = __('Alteração de Caracteristica');
        $formid     = 'form_Sistema_AdminC_TagEdit';
        $formbt     = __('Alterar Caracteristica');
        $formlink   = 'Simulador/Tag/Tags_Edit2/'.$id.'/'.$raiz;
        $editar     = $resultado;
        $campos = Simulador_Tag_DAO::Get_Colunas();
        // SE É PASTA
        // Retira Endereço Virtual
        self::DAO_Campos_Retira($campos, 'end_virtual');
        self::DAO_Campos_Retira($campos, 'tipo');
        self::DAO_Campos_Retira($campos, 'arquivo');
        //self::DAO_Campos_Retira($campos, 'parent');
        self::DAO_Campos_Retira($campos, 'usuario');
        self::DAO_Campos_Retira($campos, 'grupo');
        self::DAO_Campos_Retira($campos, 'ext');
        self::DAO_Campos_Retira($campos, 'tamanho');
        /*if($resultado->tipo==1){
            self::DAO_Campos_Retira($campos, $campomysql);
        }*/
        $this->_Visual->Blocar(\Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar,'html'));
        
        $this->Tema_Endereco($titulo1);
        $this->_Visual->Json_Info_Update('Historico', true);
        $this->_Visual->Json_Info_Update('Titulo',$titulo1);
        $this->_Visual->Bloco_Unico_CriaJanela($titulo2,'',10,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);');
        
        return true;
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tags_Edit2($id,$raiz=0){
        $titulo     = __('Editado com Sucesso');
        $dao        = Array('Simulador_Tag',$id);
        $funcao     = '$this->Tags('.$raiz.');';
        $sucesso1   = __('Caracteristica/Tag Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tags_Del($id,$raiz=0){
    	$id = (int) $id;
        // Puxa tag e deleta
        $tag = $this->_Modelo->db->Sql_Select('Simulador_Tag', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($tag);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Tag/Caracteristica deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Tags($raiz);
        
        $this->_Visual->Json_Info_Update('Titulo', 'Caracteristica deletado com Sucesso');
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    /**
     * Adicionar Tag Dinamica a Item de Outro Modulo
     * @param type $motivo Identificador do Modulo
     * @param type $motivoid Identificador
     * @param type $camada Camada de Retorno
     * @param boolean $retornar Se Escreve ou retorna html
     * @return string
     */
    static function Tag_Dinamica($motivo,$motivoid,$camada,$retornar=true){
        $existe = false;
        if($retornar==='false') $retornar = false;
        // Verifica se Existe Conexao, se nao tiver abre o adicionar conexao, se nao, abre a tag!
        $Registro = &\Framework\App\Registro::getInstacia();
        $resultado = $Registro->_Modelo->db->Sql_Select('Simulador_Tag_Conexao','{sigla}motivo=\''.$motivo.'\' AND {sigla}motivoid=\''.$motivoid.'\'',1);
        if(is_object($resultado)){
            $existe = true;
        }
        
        // Dependendo se Existir Cria Formulario ou Lista arquivos
        if($existe===false){
            $html = self::Tag_Dinamica_Add($motivo, $motivoid, $camada);
        }else{
            /*list($titulo,$html,$i)*/$html = self::Tags_Processar_Static($resultado->tag, false);
            $html = '<span id="tag_arquivos_mostrar">'.$html[1].'</span>'.
                    $Registro->_Visual->Upload_Janela(
                        'tag',
                        'Tag',
                        'Tags',
                        $resultado->tag,
                        '*.*',
                        __('Todos os Caracteristicas')
                    );
            /*$this->_Visual->Blocar('<span id="tag_arquivos_mostrar">'.$html.'</span>');
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);*/
        }
        
        if($retornar===true){
            return $html;
        }else{
            $conteudo = array(
                'location'  =>  '#'.$camada,
                'js'        =>  '',
                'html'      =>  $html
            );
            $Registro->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }
    }
    static protected function Tag_Dinamica_Add($motivo,$motivoid,$camada){
        // Carrega Config
        $titulo1    = __('Criar Conexão com Tag');
        $titulo2    = __('Salvar Conexão');
        $formid     = 'form_Sistema_Admin_TagsDinamica';
        $formbt     = __('Salvar Conexão');
        $formlink   = 'Simulador/Tag/Tag_Dinamica_Add2/'.$motivo.'/'.$motivoid.'/'.$camada;
        $campos = Simulador_Tag_Conexao_DAO::Get_Colunas();
        // Remove Essas Colunas
        self::DAO_Campos_Retira($campos, 'motivo');
        self::DAO_Campos_Retira($campos, 'motivoid');
        // Chama Formulario
       return \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,false,'html',false);
    }
    public function Tag_Dinamica_Add2($motivo,$motivoid,$camada){
        $resultado = $this->_Modelo->db->Sql_Select('Simulador_Tag_Conexao','{sigla}motivo=\''.$motivo.'\' AND {sigla}motivoid=\''.$motivoid.'\'',1);
        if(is_object($resultado)){
            SimuladorControle::Tag_Dinamica($motivo,$motivoid,$camada,false);
            return true;
        }
        $titulo     = __('Conexão de Tag Feita com Sucesso');
        $dao        = 'Simulador_Tag_Conexao';
        $funcao     = 'SimuladorControle::Tag_Dinamica(\''.$motivo.'\',\''.$motivoid.'\',\''.$camada.'\',\'false\');';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Conexão cadastrada com sucesso.');
        $alterar    = Array(
            'motivo'        =>  $motivo,
            'motivoid'      =>  $motivoid
        );
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
}
?>
