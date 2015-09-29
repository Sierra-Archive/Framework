<?php
class Engenharia_UnidadeControle extends Engenharia_Controle
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
    * @uses unidade_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Engenharia/Unidade/Unidades');
        return false;
    }
    static function Endereco_Unidade($true=true,$empreendimento=false){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if($empreendimento===false){
            $titulo = __('Todas as Unidades');
            $link   = 'Engenharia/Unidade/Unidades';
        }else{
            Engenharia_EmpreendimentoControle::Endereco_Empreendimento();
            $titulo = $empreendimento->nome;
            $link   = 'Engenharia/Unidade/Unidades/'.$empreendimento->id;
        }
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Unidades_Tabela(&$unidades,$empreendimento=false){
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($unidades)) $unidades = Array(0=>$unidades);
        reset($unidades);
        foreach ($unidades as &$valor) {
            if($empreendimento===false || $empreendimento==0){
                
                $tabela['Empreendimento'][$i]   = $valor->empreendimento2;
                $edit_url   = 'Engenharia/Unidade/Unidades_Edit/'.$valor->id.'/';
                $del_url    = 'Engenharia/Unidade/Unidades_Del/'.$valor->id.'/';
            }else{
                $edit_url   = 'Engenharia/Unidade/Unidades_Edit/'.$valor->id.'/'.$valor->empreendimento.'/';
                $del_url    = 'Engenharia/Unidade/Unidades_Del/'.$valor->id.'/'.$valor->empreendimento.'/';
            }
            $tabela['Unidade'][$i]          = $valor->unidade;
            $tabela['Metragem'][$i]         = $valor->metragem;
            $tabela['N° Quartos'][$i]       = $valor->quartos;
            $tabela['N° Banheiros'][$i]     = $valor->banheiros;
            $tabela['Data Registrado'][$i]  = $valor->log_date_add;
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Unidade'        ,$edit_url    ,'')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Unidade'       ,$del_url     ,'Deseja realmente deletar essa Unidade ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades($empreendimento=false,$export=false){
        if($empreendimento=='falso') $empreendimento = false;
        if($empreendimento!==false){
            $empreendimento = (int) $empreendimento;
            if($empreendimento==0){
                $empreendimento_registro = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento',Array(),1,'id DESC');
                if($empreendimento_registro===false){
                    throw new \Exception('Não existe nenhuma empreendimento:', 404);
                }
                $empreendimento = $empreendimento_registro->id;
            }else{
                $empreendimento_registro = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento',Array('id'=>$empreendimento),1);
                if($empreendimento_registro===false){
                    throw new \Exception('Esse Empreendimento não existe:', 404);
                }
            }
            $where = Array(
                'empreendimento'   => $empreendimento,
            );
            self::Endereco_Unidade(false, $empreendimento_registro);
        }else{
            $where = Array();
            self::Endereco_Unidade(false, false);
        }
        $i = 0;
        
        if($empreendimento!==false){
            $titulo = 'Listagem de Unidades: '.$empreendimento_registro->nome;
            $titulo_add = 'Adicionar nova Unidade ao Empreendimento: '.$empreendimento_registro->nome;
            $add_url    = 'Engenharia/Unidade/Unidades_Add/'.$empreendimento;
            $proprio    = 'Engenharia/Unidade/Unidades/'.$empreendimento;
        }else{
            $titulo = __('Listagem de Unidades em Todos os Empreendimentos');
            $titulo_add = __('Adicionar nova Unidade');
            $add_url    = 'Engenharia/Unidade/Unidades_Add/falso';
            $proprio    = 'Engenharia/Unidade/Unidades/falso';
        }
        // Botao 1
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                $titulo_add.' em Lote',
                $add_url.'/Lote',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => $proprio,
            )
        )));
        // Botao 2
        $this->_Visual->Blocar('<a title="'.$titulo_add.'" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.$add_url.'">'.$titulo_add.'</a><div class="space15"></div>');
        $unidades = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento_Unidade',$where);
        if($unidades!==false && !empty($unidades)){
            list($tabela,$i) = self::Unidades_Tabela($unidades,$empreendimento);
            if($export!==false){
                self::Export_Todos($export,$tabela, $titulo);
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
            if($empreendimento!==false){
                $erro = __('Nenhuma Unidade nesse Empreendimento');
            }else{
                $erro = __('Nenhuma Unidade nos Empreendimentos');
            }            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$erro.'</font></b></center>');
        }
        $titulo = $titulo.' ('.$i.')';
        
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo',$titulo);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades_Add($empreendimento = false, $lote=false){
        if($empreendimento=='falso') $empreendimento = false;
        // Carrega Config
        $formid     = 'form_Sistema_Admin_Unidades';
        $formbt     = __('Salvar');
        $campos     = Engenharia_Empreendimento_Unidade_DAO::Get_Colunas();
        if($empreendimento===false){
            $formlink   = 'Engenharia/Unidade/Unidades_Add2/falso';
            $titulo1    = __('Adicionar Unidade');
            $titulo2    = __('Salvar Unidade');
            self::Endereco_Unidade(true, false);
        }else{
            $empreendimento = (int) $empreendimento;
            if($empreendimento==0){
                $empreendimento_registro = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento',Array(),1,'id DESC');
                if($empreendimento_registro===false){
                    throw new \Exception('Não existe nenhuma empreendimento:', 404);
                }
                $empreendimento = $empreendimento_registro->id;
            }else{
                $empreendimento_registro = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento',Array('id'=>$empreendimento),1);
                if($empreendimento_registro===false){
                    throw new \Exception('Esse Empreendimento não existe:', 404);
                }
            }
            $formlink   = 'Engenharia/Unidade/Unidades_Add2/'.$empreendimento;
            self::DAO_Campos_Retira($campos,'empreendimento');
            $titulo1    = 'Adicionar Unidade ao Empreendimento: '.$empreendimento_registro->nome ;
            $titulo2    = 'Salvar Unidade ao Empreendimento: '.$empreendimento_registro->nome ;
            self::Endereco_Unidade(true, $empreendimento_registro);
        }
        // FAz a Magica
        if($lote===false){
           \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
        }else{
            self::DAO_Campos_Retira($campos, 'cliente');
            self::DAO_Campos_Retira($campos, 'investidor');
            $titulo1 = $titulo1.' em Lote';
            $titulo2 = $titulo2.' em Lote';
            $formlink = $formlink.'/Lote';
            $this->Magica_Add1($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
        }
        
        
    }
    /**
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades_Add2($empreendimento=false, $lote=false){
        if($empreendimento=='falso') $empreendimento = false;
        $dao        = 'Engenharia_Empreendimento_Unidade';
        if($lote===false){
            $titulo     = __('Unidade Adicionada com Sucesso');
            $sucesso1   = __('Inserção bem sucedida');
            $sucesso2   = __('Unidade cadastrada com sucesso.');
        }else{
            $titulo     = __('Unidades Adicionadas com Sucesso');
            $sucesso1   = __('Inserções bem sucedidas');
            $sucesso2   = __('Unidades cadastradas com sucesso.');
        }
        if($empreendimento===false){
            $funcao     = '$this->Unidades(0);';
            $alterar    = Array();
        }else{
            $empreendimento = (int) $empreendimento;
            $alterar    = Array('empreendimento'=>$empreendimento);
            $funcao     = '$this->Unidades('.$empreendimento.');';
        }
        if($lote===false){
            $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        } else {
            $this->Magica_Add2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
        }
    }
    private function Magica_Add2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$colocar=false,$erro1 = '',$erro2 = ''){
        $unidade1 = intval($_POST['unidade1']);
        $unidade2 = intval($_POST['unidade2']);
        $erro1 = __('Algo Errado');
        if($unidade1>=$unidade2){
            $erro2 = __('Unidade Minima maior que a máxima');
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => $erro1,
                "mgs_secundaria"    => $erro2
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);  
            $this->layoult_zerar = false;
            return false;
        }else if($unidade1<=100){
            $erro2 = __('Unidades Minima menor ou igual a 100');
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => $erro1,
                "mgs_secundaria"    => $erro2
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);  
            $this->layoult_zerar = false;
            return false;
        }else if($unidade2>=3500){
            $erro2 = __('Nenhum prédio é tão alto');
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => $erro1,
                "mgs_secundaria"    => $erro2
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);  
            $this->layoult_zerar = false;
            return false;
        }else{
            $andar_inicio = intval($unidade1/100);
            $andar_final  = intval($unidade2/100);
            $apartamento_inicio = ($unidade1-(100*$andar_inicio));
            $apartamento_final  = ($unidade2-(100*$andar_final));
            if($apartamento_inicio>$apartamento_final){
                $erro2 = __('Apartamento inicial não pode ser maior que o final');
                $mensagens = array(
                    "tipo"              => 'erro',
                    "mgs_principal"     => $erro1,
                    "mgs_secundaria"    => $erro2
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                $this->_Visual->Json_Info_Update('Historico', false);  
                $this->layoult_zerar = false;
                return false;
            }else{
                // Começa o Cadastroo
                // 
                // 
                // Variaveis
                $camponovo = false;
                $tipo           = __('add');
                $tab            = \Framework\App\Conexao::anti_injection($dao);
                $identificador  = 0;
                // Cria novo Origem
                eval('$objeto = new '.$tab.'_DAO;');
                // Adiciona OU Edita Valores
                self::mysql_AtualizaValores($objeto);
                // Adiciona Valores
                if(is_array($colocar) && $colocar!==false){
                    foreach($colocar as $indice=>&$valor){
                        $objeto->$indice = $valor;
                    }
                }
                $where = Array(
                    'empreendimento' => $objeto->empreendimento,
                    'unidade'        => 0,
                );
                $cont = 0;
                $i = $andar_inicio;
                while($i<=$andar_final){
                    // Cadastra um Andar
                    $j = $apartamento_inicio;
                    while($j<=$apartamento_final){
                        // Cadastra cada Apartamento do andar
                        // Pesquisa pra ver se ja existe
                        $Registros_cadastrado = $objeto;
                        $Registros_cadastrado->unidade = intval(($i*100)+$j);
                        $where['unidade'] = $Registros_cadastrado->unidade;
                        $objeto_pesquisado  = $this->_Modelo->db->Sql_Select($tab,$where);
                        // Se for Encontrado outro Objeto Trava Funcao e Retorna Erro
                        if($objeto_pesquisado===false){
                            $this->_Modelo->db->Sql_Inserir($Registros_cadastrado);
                            ++$cont;
                        }
                        ++$j;
                    }
                    ++$i;
                }
            }
        }
        $mensagens = array(
            "tipo"              => 'sucesso',
            "mgs_principal"     => __('Sucesso'),
            "mgs_secundaria"    => __('Unidades Cadastradas com Sucesso.')
        );
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        $this->_Visual->Json_Info_Update('Historico', false);  
        $this->layoult_zerar = false;
        return false;
    }
    /**
     *  Add Multiplos
     * @param type $titulo1
     * @param type $titulo2
     * @param type $formlink
     * @param type $formid
     * @param type $formbt
     * @param type $campos
     * @param type $editar
     * @param type $bloco
     * @throws Exception
     */
    private function Magica_Add1($titulo1,$titulo2,$formlink,$formid,$formbt,&$campos,$editar=false,$bloco='All'){
        // Adiciona Titulo ao Endereço
        $this->Tema_Endereco($titulo1);  
        // Verifica se nao é editavel
        if($editar!==false){
            if(is_object($editar)){
                $objeto = &$editar;
                $id = (int) $objeto->id;
            }else{
                if(!is_array($editar))throw new \Exception('Variavel nao e um Array: '.$editar,2800);
                // recupera Arquivo
                $id = (int) $editar[1];
                $objeto = $this->_Modelo->db->Sql_Select($editar[0], Array('id'=>$id));
                if($objeto===false) throw new \Exception('Registro não existe: ID->'.$id,404);
            }
            foreach($campos as &$valor){
                if(strpos($valor['edicao']['change'], 'Control_Layoult_Form_Campos_Trocar')!==false){
                    if($valor['edicao']['valor_padrao']!=$objeto->$valor['mysql_titulo']){
                        self::DAO_Campos_TrocaAlternados($campos);
                    }
                }
            }
            self::mysql_AtualizaValores($campos, $objeto,$id);
        }
        // Puxa Form
        $form = new \Framework\Classes\Form($formid,$formlink,'formajax');
        self::DAO_Campos_Retira($campos, 'unidade');
        // Botao Extras
        $form->Input_Novo(
            'Unidade Inicial',
            'unidade1',
            '101',
            'text', 
            11,
            'obrigatorio',
            '',
            false,
            '',
            '',
            'Numero',
            '',
            false
        ); 
        $form->Input_Novo(
            'Unidade Final',
            'unidade2',
            '604',
            11,
            'text', 
            'obrigatorio',
            '',
            false,
            '',
            '',
            'Numero',
            '',
            false
        ); 
        // Formulario
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        // Carrega formulario
        if(isset($_GET['formselect']) && $_GET['formselect']!='' && LAYOULT_IMPRIMIR=='AJAX'){
            $formulario = $form->retorna_form();
            $conteudo = array(
                'id' => 'popup',
                'title' => $titulo2,
                'botoes' => array(
                    array(
                        'text' => $formbt,
                        'clique' => '$(\'#'.$formid.'\').submit();'
                    ),
                    array(
                        'text' => 'Cancelar',
                        'clique' => '$( this ).dialog( "close" );'
                    )
                ),
                'html' => \Framework\App\Sistema_Funcoes::HTML_min($formulario)
            );
            $this->_Visual->Json_IncluiTipo('Popup',$conteudo);
            $this->_Visual->Json_Info_Update('Historico', false);
        }else{
            $formulario = $form->retorna_form($formbt);
            $this->_Visual->Blocar($formulario);
            // Mostra Conteudo
            if($bloco=='All')   $this->_Visual->Bloco_Unico_CriaJanela($titulo2,'',0,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);');
            if($bloco=='right') $this->_Visual->Bloco_Menor_CriaJanela($titulo2,'',0,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);');
            if($bloco=='left')  $this->_Visual->Bloco_Maior_CriaJanela($titulo2,'',0,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);');
            // Pagina Config
            $this->_Visual->Json_Info_Update('Historico', true);
        }
        $this->_Visual->Json_Info_Update('Titulo',$titulo1);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades_Edit($id,$empreendimento = false){
        if($id===false){
            throw new \Exception('Unidade não existe:'. $id, 404);
        }
        $id         = (int) $id;
        if($empreendimento!==false){
            $empreendimento    = (int) $empreendimento;
        }
        // Carrega Config
        $titulo1    = 'Editar Unidade (#'.$id.')';
        $titulo2    = __('Alteração de Unidade');
        $formid     = 'form_Sistema_AdminC_UnidadeEdit';
        $formbt     = __('Alterar Unidade');
        $campos = Engenharia_Empreendimento_Unidade_DAO::Get_Colunas();
        if($empreendimento!==false){
            $empreendimento_registro = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento',Array('id'=>$empreendimento),1);
            if($empreendimento_registro===false){
                throw new \Exception('Esse Empreendimento não existe:', 404);
            }
            $formlink   = 'Engenharia/Unidade/Unidades_Edit2/'.$id.'/'.$empreendimento;
            self::DAO_Campos_Retira($campos,'empreendimento');
            self::Endereco_Unidade(true, $empreendimento_registro);
        }else{
            $formlink   = 'Engenharia/Unidade/Unidades_Edit2/'.$id;
            self::Endereco_Unidade(true, false);
        }
        $editar     = Array('Engenharia_Empreendimento_Unidade',$id);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades_Edit2($id,$empreendimento = false){
        if($id===false){
            throw new \Exception('Unidade não existe:'. $id, 404);
        }
        $id         = (int) $id;
        if($empreendimento!==false){
            $empreendimento    = (int) $empreendimento;
        }
        $titulo     = __('Unidade Editada com Sucesso');
        $dao        = Array('Engenharia_Empreendimento_Unidade',$id);
        if($empreendimento!==false){
            $funcao     = '$this->Unidades('.$empreendimento.');';
        }else{
            $funcao     = '$this->Unidades();';
        }
        $sucesso1   = __('Unidade Alterada com Sucesso.');
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
    public function Unidades_Del($id = false,$empreendimento=false){
        
        if($id===false){
            throw new \Exception('Unidade não existe:'. $id, 404);
        }
        // Antiinjection
    	$id = (int) $id;
        if($empreendimento!==false){
            $empreendimento    = (int) $empreendimento;
            $where = Array('empreendimento'=>$empreendimento,'id'=>$id);
        }else{
            $where = Array('id'=>$id);
        }
        // Puxa unidade e deleta
        $unidade = $this->_Modelo->db->Sql_Select('Engenharia_Empreendimento_Unidade', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($unidade);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Unidade deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Recupera Unidades
        if($empreendimento!==false){
            $this->Unidades($empreendimento);
        }else{
            $this->Unidades();
        }
        
        $this->_Visual->Json_Info_Update('Titulo', __('Unidade deletada com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
}
?>
