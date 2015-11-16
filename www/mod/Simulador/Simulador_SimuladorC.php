<?php
class Simulador_SimuladorControle extends Simulador_Controle
{
    public function __construct() {
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses simulador_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Simulador/Simulador/Simuladores');
        return false;
    }
    static function Endereco_Simulador($true=true) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true===true) {
            $_Controle->Tema_Endereco(__('Simuladores'),'Simulador/Simulador/Simuladores');
        } else {
            $_Controle->Tema_Endereco(__('Simuladores'));
        }
    }
    static function Simuladores_Tabela(&$simuladores) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        
        $tabela = Array();
        $i = 0;
        if (is_object($simuladores)) $simuladores = Array(0=>$simuladores);
        reset($simuladores);
        foreach ($simuladores as &$valor) {
            $tabela['Nome do Simulador'][$i]          =   $valor->nome;
            
            $tabela['Data Cadastrada'][$i]          =   $valor->log_date_add;
            $status                                 = $valor->status;
            if ($status!=1) {
                $status = 0;
                $texto = __('Desativado');
            } else {
                $status = 1;
                $texto = __('Ativado');
            }
            $tabela['Status'][$i]                   = '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$status     ,Array($texto        ,'Simulador/Simulador/Status/'.$valor->id.'/'    ,'')).'</span>';
            $tabela['Funções'][$i]                  =   $Visual->Tema_Elementos_Btn('Personalizado' ,Array('Testar Simulador'    ,'Simulador/Simulador/Simuladores_Assistir/'.$valor->id.'/'    ,'', 'play', 'success')).
                                                        $Visual->Tema_Elementos_Btn('Visualizar'    ,Array('Visualizar Perguntas do Simulador'    ,'Simulador/Pergunta/Perguntas/'.$valor->id.'/'    ,'')).
                                                        $Visual->Tema_Elementos_Btn('Editar'        ,Array('Editar Simulador'        ,'Simulador/Simulador/Simuladores_Edit/'.$valor->id.'/'    ,'')).
                                                        $Visual->Tema_Elementos_Btn('Deletar'       ,Array('Deletar Simulador'       ,'Simulador/Simulador/Simuladores_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Simulador ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Simuladores($export=false) {
        self::Endereco_Simulador(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Simulador',
                'Simulador/Simulador/Simuladores_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Simulador/Simulador/Simuladores',
            )
        )));
        $simuladores = $this->_Modelo->db->Sql_Select('Simulador');
        if ($simuladores!==false && !empty($simuladores)) {
            list($tabela,$i) = self::Simuladores_Tabela($simuladores);
            
            if ($export!==false) {
                self::Export_Todos($export,$tabela, 'Simuladores');
            } else {
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
        } else {            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Simulador</font></b></center>');
        }
        $titulo = __('Listagem de Simuladores').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Simuladores'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Simuladores_Add() {
        self::Endereco_Simulador();
        // Carrega Config
        $titulo1    = __('Adicionar Simulador');
        $titulo2    = __('Salvar Simulador');
        $formid     = 'form_Simulador_Simulado_Simuladores';
        $formbt     = __('Salvar');
        $formlink   = 'Simulador/Simulador/Simuladores_Add2/';
        $campos = Simulador_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Simuladores_Add2() {
        $titulo     = __('Simulador Adicionado com Sucesso');
        $dao        = 'Simulador';
        $funcao     = '$this->Simuladores();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Simulador cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Simuladores_Edit($id) {
        self::Endereco_Simulador();
        // Carrega Config
        $titulo1    = 'Editar Simulador (#'.$id.')';
        $titulo2    = __('Alteração de Simulador');
        $formid     = 'form_Simulador_SimuladoC_SimuladorEdit';
        $formbt     = __('Alterar Simulador');
        $formlink   = 'Simulador/Simulador/Simuladores_Edit2/'.$id;
        $editar     = Array('Simulador',$id);
        $campos = Simulador_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Simuladores_Edit2($id) {
        $titulo     = __('Simulador Editado com Sucesso');
        $dao        = Array('Simulador',$id);
        $funcao     = '$this->Simuladores();';
        $sucesso1   = __('Simulador Alterado com Sucesso.');
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
    public function Simuladores_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa simulador e deleta
        $simulador = $this->_Modelo->db->Sql_Select('Simulador', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($simulador);
        // Mensagem
    	if ($sucesso===true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Simulador deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Simuladores();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Simulador deletado com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    public function Status($id=false) {
        if ($id===false) {
            return false;
        }
        $resultado = $this->_Modelo->db->Sql_Select('Simulador', Array('id'=>$id),1);
        if ($resultado===false || !is_object($resultado)) {
            return _Sistema_erroControle::Erro_Fluxo('Esse registro não existe:'. $id,404);
        }
        if ($resultado->status=='1') {
            $resultado->status='0';
        } else {
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if ($sucesso) {
            if ($resultado->status==1) {
                $texto = __('Ativado');
            } else {
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Simulador/Simulador/Status/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Simuladores_Assistir($simulador,$token=false,$pergunta=false) {
        // Verifica Token, se nao vier cria
        if ($token===false) {
            $token = Framework\App\Sistema_Funcoes::Seguranca_Gerar_Token();
        } else {
            $token = Framework\App\Conexao::anti_injection($token);
        }
        
        // Inicializa Variavies
        $simulador = (int) $simulador;
        $respondidas_perguntas = Array();
        $respondidas_respostas = Array();
        
        //Procura Simulador
        $simulador_registro = $this->_Modelo->db->Sql_Select('Simulador', '{sigla}id=\''.$simulador.'\'',1);
        if ($simulador_registro===false || !is_object($simulador_registro)) {
            return _Sistema_erroControle::Erro_Fluxo('Simulador não existe:'. $simulador,404);
        }
        
        // Procura as Respostas Ja Respondidas
        $respondidas = $this->_Modelo->db->Sql_Select('Simulador_Assistir', '{sigla}token=\''.$token.'\'');
        if (is_object($respondidas)) {
            $respondidas = Array($respondidas);
        }
        if ($respondidas!==false) {
            foreach($respondidas as &$valor) {
                $respondidas_perguntas[] = $valor->pergunta;
                $respondidas_respostas[] = $valor->resposta;
            }
        }
        
        // Se tiver POST, cadastra a resposta
        if ($pergunta!==false && isset($_POST['resposta'])) {
            $pergunta = (int) $pergunta;
                
                
                
        
            $titulo     = __('Pergunta Respondida com Sucesso');
            $dao        = 'Simulador_Assistir';
            $funcao     = false;
            $sucesso1   = __('Pergunta Respondida com Sucesso');
            $sucesso2   = __('Pergunta Respondida com Sucesso');
            $alterar    = Array(
                'token'     => $token,
                'simulador' => $simulador,
                'pergunta'  => $pergunta
            );
            $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
            
            $respondidas_perguntas[] = $pergunta;
            $respondidas_respostas[] = (int) $_POST['resposta'];
        }
        
        // PRocura Proxima Resposta
        $where = Array(
            'simulador'     => $simulador,
            'NOTINid'       => $respondidas_perguntas
        );
        $pergunta_proxima = $this->_Modelo->db->Sql_Select('Simulador_Pergunta', $where, 1);
        
        // Escolhe a próxima Página
        if ($pergunta_proxima===false) {
            //IMprimi Resultado
            $caracteristicas = Array();
            // PRocura Resultados
            $where = Array(
                'simulador'     => $simulador,
                'INid'          => $respondidas_respostas
            );
            $assistir_respostas = $this->_Modelo->db->Sql_Select('Simulador_Pergunta_Resposta', $where);
            if (is_object($assistir_respostas)) {
                $assistir_respostas = Array($assistir_respostas);
            }
            if ($assistir_respostas!==false) {var_dump($assistir_respostas);
                foreach($assistir_respostas as &$valor) {
                    $caracteristicas[] = Array(
                        'Tag'       => $valor->tag,
                        'Resposta'  => $valor->filtro_valor,
                        'Tipo'      => $valor->filtro_tipo
                    );
                }
            }
            var_dump($caracteristicas);
        } else {
            //Procura as Respostas
            /*$where = Array(
                'simulador'     => $simulador,
                'pergunta'      => $pergunta_proxima->id
            );
            $pergunta_respostas = $this->_Modelo->db->Sql_Select('Simulador_Pergunta_Resposta', $where);
            if (is_object($pergunta_respostas)) {
                $pergunta_respostas = Array($pergunta_respostas);
            }
            if ($pergunta_respostas!==false) {
                foreach($pergunta_respostas as &$valor) {
                    $respondidas_perguntas[] = $valor->pergunta;
                    $respondidas_respostas[] = $valor->resposta;
                }
            }*/
            // Carrega Config
            $titulo1    = __($pergunta_proxima->nome);
            $titulo2    = __($pergunta_proxima->nome);
            $formid     = 'form_Simulador_Simulado_Simuladores_Assistir';
            $formbt     = __('Próxima');
            $formlink   = 'Simulador/Simulador/Simuladores_Assistir/'.$simulador.'/'.$token.'/'.$pergunta_proxima->id;
            $campos = Simulador_Assistir_DAO::Get_Colunas();
            self::DAO_Campos_Retira($campos, 'simulador');
            self::DAO_Campos_Retira($campos, 'pergunta');
            self::DAO_Ext_Alterar($campos,'resposta',$pergunta_proxima->id);
            \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);

        }
    }
}
?>
