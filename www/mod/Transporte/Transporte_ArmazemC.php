<?php

class Transporte_ArmazemControle extends Transporte_Controle
{
    public function __construct(){
        parent::__construct();
    }
    static function Endereco_Armazem($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Armazens';
        $link = 'Transporte/Armazem/Armazens';
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
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Transporte/Armazem/Armazens');
        return false;
    }
    static function Armazens_Tabela(&$armazem){
        $registro   = \Framework\App\Registro::getInstacia();
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if(is_object($armazem)) $armazem = Array(0=>$armazem);reset($armazem);
        foreach ($armazem as &$valor) {                
            $tabela['Id'][$i]           = '#'.$valor->id;
            $tabela['Categoria'][$i]    = $valor->categoria2;
            $tabela['Titulo'][$i]       = $valor->nome;
            ++$i;
        }
        return Array($tabela,$i);
    }
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Armazens($export=false){
        $i = 0;
        self::Endereco_Armazem(false);
        $armazem = $this->_Modelo->db->Sql_Select('Transporte_Armazem');
        if(is_object($armazem)) $armazem = Array(0=>$armazem);
        if($armazem!==false && !empty($armazem)){
            list($tabela,$i) = self::Transportes_Tabela($armazem);
            // SE exportar ou mostra em tabela
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Blocos');
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
                $mensagem = 'Nenhum Armazem Cadastrada para exportar';
            }else{
                $mensagem = 'Nenhum Armazem Cadastrada';
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = 'Listagem de Transportes ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Armazemistrar Transportes');
    }
    /**
     * Painel Adminstrativo de Armazens
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Painel(){
        return true;
    }
    static function Painel_Armazem($camada,$retornar=true){
        $existe = false;
        if($retornar==='false') $retornar = false;
        // Verifica se Existe Conexao, se nao tiver abre o adicionar conexao, se nao, abre a pasta!
        $registro = \Framework\App\Registro::getInstacia();
        $resultado = $registro->_Modelo->db->Sql_Select('Transporte_Armazem','{sigla}usuario=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if(is_object($resultado)){
            $existe = true;
        }
        
        // Dependendo se Existir Cria Formulario ou Lista arquivos
        if($existe===false){
            $html = '<b>Ainda faltam insformações sobre o seu Armazem</b><br>'.self::Painel_Armazem_Add($motivo, $motivoid, $camada);
        }else{
            $html = 'Painel';
        }
        
        if($retornar===true){
            return $html;
        }else{
            $conteudo = array(
                'location'  =>  '#'.$camada,
                'js'        =>  '',
                'html'      =>  $html
            );
            $registro->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }
        /*
                $this->_Visual->Bloco_Customizavel(Array(
                    Array(
                        'span'      =>      5,
                        'conteudo'  =>  Array(Array(
                            'div_ext'   =>      false,
                            'title_id'  =>      false,
                            'title'     =>      $titulo.' #'.$identificador->id,
                            'html'      =>      $html,
                        ),),
                    ),
                    Array(
                        'span'      =>      7,
                        'conteudo'  =>  Array(Array(
                            'div_ext'   =>      false,
                            'title_id'  =>      false,
                            'title'     =>      'Pasta da '.$titulo.' #'.$identificador->id.' na Armazem',
                            'html'      =>      '<span id="proposta_'.$identificador->id.'">'.self::Painel_Armazem('comercio_Proposta',$identificador->id,'proposta_'.$identificador->id).'</span>',
                        )/*,Array(
                            'div_ext'   =>      false,
                            'title_id'  =>      false,
                            'title'     =>      'Sub-'.$tema,
                            'html'      =>      ' Aqui tem !',
                        ),*//*),
                    )
                ));*/
        return true;
    }
    static protected function Painel_Armazem_Add($camada){
        // Carrega Config
        $titulo1    = 'Salvar Dados';
        $titulo2    = 'Salvar Dados';
        $formid     = 'form_Transporte_Armazem_Add';
        $formbt     = 'Salvar Dados';
        $formlink   = 'Transporte/Armazem/Painel_Armazem_Add2/'.$camada;
        $campos = Transporte_Armazem_DAO::Get_Colunas();
        // Remove Essas Colunas
        self::DAO_Campos_Retira($campos, 'usuario');
        // Chama Formulario
       return \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,false,'html',false);
    }
    public function Painel_Armazem_Add2($camada){
        $resultado = $this->_Modelo->db->Sql_Select('Transporte_Armazem','{sigla}usuario=\''.$this->_Acl->Usuario_GetID().'\'',1);
        if(is_object($resultado)){
            self::Painel_Armazem($camada,false);
            return true;
        }
        $titulo     = 'Dados Atualizados com Sucesso';
        $dao        = 'Transporte_Armazem';
        $funcao     = 'Transporte_ArmazemControle::Painel_Armazem(\''.$camada.'\',\'false\');';
        $sucesso1   = 'Atualização bem sucedida';
        $sucesso2   = 'Dados Atualizados com sucesso.';
        $alterar    = Array(
            'usuario'        =>  $this->_Acl->Usuario_GetID(),
        );
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
}
?>
