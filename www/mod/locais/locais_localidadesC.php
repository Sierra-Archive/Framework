<?php
class locais_localidadesControle extends locais_Controle
{

    public function __construct(){
        parent::__construct();
    }
    public function Main() {

    }
    public function cep(){
        // Controla
        if(isset($_POST['pais'])){
            $pais = \Framework\App\Conexao::anti_injection($_POST['pais']);
        }else{
            $pais = '1'; // Brasil
        }
        if(isset($_POST['estado'])){
            $estado = \Framework\App\Conexao::anti_injection($_POST['estado']);
        }else{
            $estado = '';
        }
        if(isset($_POST['cidade'])){
            $cidade = \Framework\App\Conexao::anti_injection($_POST['cidade']);
        }else{
            $cidade = '';
        }
        if(isset($_POST['bairro'])){
            $bairro = \Framework\App\Conexao::anti_injection($_POST['bairro']);
        }else{
            $bairro = '';
        }
        
        // Limpa
        if($estado=='' || !isset($estado)){
            $estado = 'falso';
        }
        if($cidade=='' || !isset($cidade)){
            $cidade = 'falso';
        }
        if($bairro=='' || !isset($bairro)){
            $bairro = 'falso';
        }
        $imprimir = function(&$opcoes){
            $html = '';
            if($opcoes!==false && !empty($opcoes)){
                if(is_object($opcoes)) $opcoes = Array(0=>$opcoes);
                reset($opcoes);
                foreach ($opcoes as $indice2=>$valor2) {
                    $selecionado = 0;
                    $html .= \Framework\Classes\Form::Select_Opcao_Stat($valor2->nome, $valor2->id,$selecionado);
                }
            }
            return $html;
        };
        // Estado
        if($estado!='falso'){
            $where      =   Array('sigla'=>$estado,'pais'=>$pais);
            $opcoes     =   $this->_Modelo->db->Sql_Select('Sistema_Local_Estado', $where, 1);
            $where      =   Array('!sigla'=>$estado);
            // Verifica Se Estado Escolhido Existe
            if(is_object($opcoes)){
                $id_estado = $opcoes->id;
                $where['pais'] = $opcoes->pais;
                $where['!id'] = $id_estado;
            }else{
                $mensagem = 'Estado não Existe '."\n";
                $mensagem .= 'Estado: '.$estado."\n";
                $mensagem .= 'Cidade: '.$cidade."\n";
                $mensagem .= 'Bairro: '.$bairro;
                self::log($mensagem, 'Informações');
                $id_estado = false;
                $where['pais'] = $pais;
                $cidade = 'falso';
            }
            $html       =   $imprimir($opcoes,1);
            // Procura as outras opcoes
            $opcoes     =   $this->_Modelo->db->Sql_Select('Sistema_Local_Estado', $where);
            $html       .=  $imprimir($opcoes);
            // Json
            $conteudo = array(
                'location'  =>  '#estado',
                'js'        =>  '',
                'html'      =>  $html
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            // CIdade
            if($cidade!='falso'){
                $where      =   Array('estado'=>$id_estado,'nome'=>$cidade);
                $opcoes     =   $this->_Modelo->db->Sql_Select('Sistema_Local_Cidade', $where, 1);
                $where      =   Array('estado'=>$id_estado);
                // Verifica Se Estado Escolhido Existe
                if(is_object($opcoes)){
                    $id_cidade = $opcoes->id;
                    $where['!nome'] = $cidade;
                    $where['!id'] = $id_cidade;
                }else{
                    $mensagem = 'Cidade não Existe '."\n";
                    $mensagem .= 'Estado: '.$estado."\n";
                    $mensagem .= 'Cidade: '.$cidade."\n";
                    $mensagem .= 'Bairro: '.$bairro;
                    self::log($mensagem, 'Informações');
                    $id_cidade = false;
                    $bairro = 'falso';
                }
                $html       =   $imprimir($opcoes,1);
                $opcoes     =   $this->_Modelo->db->Sql_Select('Sistema_Local_Cidade', $where);
                $html       .=  $imprimir($opcoes);
                // Json
                $conteudo = array(
                    'location'  =>  '#cidade',
                    'js'        =>  '',
                    'html'      =>  $html
                );
                $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
                // Bairro
                if($bairro!='falso'){
                    // Procura Selecionado
                    $where      =   Array('cidade'=>$id_cidade,'nome'=>$bairro);
                    $opcoes     =   $this->_Modelo->db->Sql_Select('Sistema_Local_Bairro', $where, 1);
                    $where      =   Array('!nome'=>$bairro,'cidade'=>$id_cidade);
                    if(is_object($opcoes)){
                        $where['!id'] = $opcoes->id;
                    }else{
                        $mensagem = 'Bairro não Existe '."\n";
                        $mensagem .= 'Estado: '.$estado."\n";
                        $mensagem .= 'Cidade: '.$cidade."\n";
                        $mensagem .= 'Bairro: '.$bairro;
                        self::log($mensagem, 'Informações');
                    }
                    $html       =   $imprimir($opcoes,1);
                    // Procura Outros Resultados e Imprimi
                    $opcoes     =   $this->_Modelo->db->Sql_Select('Sistema_Local_Bairro', $where);
                    $html       .=  $imprimir($opcoes);
                    // Json
                    $conteudo = array(
                        'location'  =>  '#bairro',
                        'js'        =>  '',
                        'html'      =>  $html
                    );
                    $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
                }
            }
        }else{
            //Cep Não Reconhecido
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Cep Inválido'),
                "mgs_secundaria"    => __('Cep não Reconhecido pelos Corrêios')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Javascript_Executar(
                    '$("#cep").css(\'border\', \'2px solid #FFAEB0\').focus();'
            );
            $this->_Visual->Json_Info_Update('Historico', false);
            $this->layoult_zerar = false; 
            return false;
        }
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Paises(){
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar País" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'locais/localidades/Paises_Add">Adicionar novo País</a><div class="space15"></div>');
        $setores = $this->_Modelo->db->Sql_Select('Sistema_Local_Pais');
        if($setores!==false && !empty($setores)){
            if(is_object($setores)) $setores = Array(0=>$setores);
            reset($setores);
            foreach ($setores as $indice=>&$valor) {
                $tabela['Nome'][$i]             = $valor->nome;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar País'        ,'locais/localidades/Paises_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar País'       ,'locais/localidades/Paises_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse País ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{       
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum País</font></b></center>');
        }
        $titulo = __('Listagem de Paises').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Países'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Paises_Add(){
        // Carrega Config
        $titulo1    = __('Adicionar País');
        $titulo2    = __('Salvar País');
        $formid     = 'form_Sistema_Admin_Paises';
        $formbt     = __('Salvar');
        $formlink   = 'locais/localidades/Paises_Add2/';
        $campos = Sistema_Local_Pais_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * Retorno de Add Paises
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Paises_Add2(){
        $titulo     = __('País Adicionado com Sucesso');
        $dao        = 'Sistema_Local_Pais';
        $funcao     = '$this->Paises();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('País cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Paises_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar País (#'.$id.')';
        $titulo2    = __('Alteração de País');
        $formid     = 'form_Sistema_AdminC_PaisEdit';
        $formbt     = __('Alterar País');
        $formlink   = 'locais/localidades/Paises_Edit2/'.$id;
        $editar     = Array('Sistema_Local_Pais',$id);
        $campos = Sistema_Local_Pais_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * Retorno de Editar Paises
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Paises_Edit2($id){
        $titulo     = __('País Editado com Sucesso');
        $dao        = Array('Sistema_Local_Pais',$id);
        $funcao     = '$this->Paises();';
        $sucesso1   = __('País Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * Deletar Paises
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Paises_Del($id){
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Sistema_Local_Pais', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('País deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Paises();
        
        $this->_Visual->Json_Info_Update('Titulo', __('País deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Estados(){
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar Estado" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'locais/localidades/Estados_Add">Adicionar novo Estado</a><div class="space15"></div>');
        $setores = $this->_Modelo->db->Sql_Select('Sistema_Local_Estado');
        if($setores!==false && !empty($setores)){
            if(is_object($setores)) $setores = Array(0=>$setores);
            reset($setores);
            foreach ($setores as $indice=>&$valor) {
                $tabela['Nome'][$i]             = $valor->nome;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Estado'        ,'locais/localidades/Estados_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Estado'       ,'locais/localidades/Estados_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Estado ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Estado</font></b></center>');
        }
        $titulo = __('Listagem de Estados').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Estados'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Estados_Add(){
        // Carrega Config
        $titulo1    = __('Adicionar Estado');
        $titulo2    = __('Salvar Estado');
        $formid     = 'form_Sistema_Admin_Estados';
        $formbt     = __('Salvar');
        $formlink   = 'locais/localidades/Estados_Add2/';
        $campos = Sistema_Local_Estado_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Estados_Add2(){
        $titulo     = __('Estado Adicionado com Sucesso');
        $dao        = 'Sistema_Local_Estado';
        $funcao     = '$this->Estados();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Estado cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Estados_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar Estado (#'.$id.')';
        $titulo2    = __('Alteração de Estado');
        $formid     = 'form_Sistema_AdminC_EstadoEdit';
        $formbt     = __('Alterar Estado');
        $formlink   = 'locais/localidades/Estados_Edit2/'.$id;
        $editar     = Array('Sistema_Local_Estado',$id);
        $campos = Sistema_Local_Estado_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Estados_Edit2($id){
        $titulo     = __('Estado Editado com Sucesso');
        $dao        = Array('Sistema_Local_Estado',$id);
        $funcao     = '$this->Estados();';
        $sucesso1   = __('Estado Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Estados_Del($id){
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Sistema_Local_Estado', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Estado deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Estados();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Estado deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Cidades(){
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar Cidade" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'locais/localidades/Cidades_Add">Adicionar nova Cidade</a><div class="space15"></div>');
        $setores = $this->_Modelo->db->Sql_Select('Sistema_Local_Cidade');
        if($setores!==false && !empty($setores)){
            if(is_object($setores)) $setores = Array(0=>$setores);
            reset($setores);
            foreach ($setores as $indice=>&$valor) {
                $tabela['Nome'][$i]             = $valor->nome;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Cidade'        ,'locais/localidades/Cidades_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Cidade'       ,'locais/localidades/Cidades_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Cidade ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Cidade</font></b></center>');
        }
        $titulo = __('Listagem de Cidades').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Cidades'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Cidades_Add(){
        // Carrega Config
        $titulo1    = __('Adicionar Cidade');
        $titulo2    = __('Salvar Cidade');
        $formid     = 'form_Sistema_Admin_Cidades';
        $formbt     = __('Salvar');
        $formlink   = 'locais/localidades/Cidades_Add2/';
        $campos = Sistema_Local_Cidade_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Cidades_Add2(){
        $titulo     = __('Cidade Adicionada com Sucesso');
        $dao        = 'Sistema_Local_Cidade';
        $funcao     = '$this->Cidades();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Cidade cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Cidades_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar Cidade (#'.$id.')';
        $titulo2    = __('Alteração de Cidade');
        $formid     = 'form_Sistema_AdminC_CidadeEdit';
        $formbt     = __('Alterar Cidade');
        $formlink   = 'locais/localidades/Cidades_Edit2/'.$id;
        $editar     = Array('Sistema_Local_Cidade',$id);
        $campos = Sistema_Local_Cidade_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Cidades_Edit2($id){
        $titulo     = __('Cidade Editada com Sucesso');
        $dao        = Array('Sistema_Local_Cidade',$id);
        $funcao     = '$this->Cidades();';
        $sucesso1   = __('Cidade Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Cidades_Del($id){
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Sistema_Local_Cidade', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Cidade deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Cidades();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Cidade deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bairros(){
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar Bairro" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'locais/localidades/Bairros_Add">Adicionar novo Bairro</a><div class="space15"></div>');
        $setores = $this->_Modelo->db->Sql_Select('Sistema_Local_Bairro');
        if($setores!==false && !empty($setores)){
            if(is_object($setores)) $setores = Array(0=>$setores);
            reset($setores);
            foreach ($setores as $indice=>&$valor) {
                $tabela['Nome'][$i]             = $valor->nome;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Bairro'        ,'locais/localidades/Bairros_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Bairro'       ,'locais/localidades/Bairros_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Bairro ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Bairro</font></b></center>');
        }
        $titulo = __('Listagem de Bairros').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Bairros'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bairros_Add(){
        // Carrega Config
        $titulo1    = __('Adicionar Bairro');
        $titulo2    = __('Salvar Bairro');
        $formid     = 'form_Sistema_Admin_Bairros';
        $formbt     = __('Salvar');
        $formlink   = 'locais/localidades/Bairros_Add2/';
        $campos = Sistema_Local_Bairro_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bairros_Add2(){
        $titulo     = __('Bairro Adicionado com Sucesso');
        $dao        = 'Sistema_Local_Bairro';
        $funcao     = '$this->Bairros();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Bairro cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bairros_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar Bairro (#'.$id.')';
        $titulo2    = __('Alteração de Bairro');
        $formid     = 'form_Sistema_AdminC_BairroEdit';
        $formbt     = __('Alterar Bairro');
        $formlink   = 'locais/localidades/Bairros_Edit2/'.$id;
        $editar     = Array('Sistema_Local_Bairro',$id);
        $campos = Sistema_Local_Bairro_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bairros_Edit2($id){
        $titulo     = __('Bairro Editado com Sucesso');
        $dao        = Array('Sistema_Local_Bairro',$id);
        $funcao     = '$this->Bairros();';
        $sucesso1   = __('Bairro Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bairros_Del($id){
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Sistema_Local_Bairro', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Bairro deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Bairros();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Bairro deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
