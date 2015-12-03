<?php
class _Sistema_RecursoControle extends _Sistema_Controle
{
    public function __construct(){
        
        parent::__construct();
    }
    public function Main($dominio,$campo_alterado,$id=0){
        $this->Select_Recarrega_Extrangeira($dominio,$campo_alterado,$id);
        $this->Json_Definir_zerar(false);
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    /**
     * 
     * @param type $dominiosigla -> Tabela que contem o select extrangeiro alterado
     * @param type $alterado -> Tabela que se refere o select extrangeiro alterado
     * @param type $campo_alterado -> Campo da Tabela do Formulario que foi alterado
     * @param type $id
     * @return booleanReferenceError: inArray is not defined
	

$('#produtocontrolador1 select').attr('id','produto1');

	

     */
    public function Select_Recarrega_Extrangeira($dominiosigla,$campo_alterado,$id=0){
        // Variaveis INICIAIS
        $extrangeira_outras = Array();
        $html = '';
        $novoid = 0;
        // Configura Json
        $usados = Array();
        $this->Json_Definir_zerar(false);
        $this->_Visual->Json_Info_Update('Historico', false);
        if($id==0 || !isset($id)){
            return false;
        }
        
        // Pega ["tabela"] e ["class"] da tabela que estava sendo alterada no forum
        $dominio = \Framework\App\Conexao::Tabelas_GetSiglas_Recolher($dominiosigla);
        // Inicia Classe, Gera suas colunas e acha a coluna alterada
        if (strpos($dominio['classe'], '_DAO') === false) {
            $alterado = $dominio['classe'].'_DAO';
        }else{
            $alterado = $dominio['classe'];
        }
        $alterado = new $alterado();
        $alterado = $alterado->Get_Extrangeiras_ComExterna();
        foreach($alterado as $indice=>&$valor){
            if($indice!==$campo_alterado){
                $achado         = Array();
                $resultado = preg_match(
                    '/{(.+)}/U',
                    $valor,
                    $achado
                );
                if($resultado===1 && $achado[1]===$campo_alterado){
                    // ACHADO TABELA A ALTERAR
                    $extrangeira_procurar = str_replace('{'.$campo_alterado.'}', $id, $valor);
                    $resultado = $this->_Modelo->db->Tabelas_CapturaExtrangeiras($extrangeira_procurar);
                    if($resultado!==false && !empty($resultado)){
                        if(is_object($resultado)) $resultado = Array(0=>$resultado);
                        $i = 0;
                        foreach ($resultado as $indice2=>$valor2) {
                            if($i==0){
                                $novoid = $indice2;
                                $seleciona = 1;
                            }else{
                                $seleciona = 0;
                            }
                            $html .= \Framework\Classes\Form::Select_Opcao_Stat($valor2, $indice2,$seleciona);
                            ++$i;
                        }
                    }else{
                        $html .= \Framework\Classes\Form::Select_Opcao_Stat('', '',1);
                    }
                    // Json
                    $conteudo = array(
                        'location'  =>  '#'.$indice,
                        //'js'        =>  '$("#'.$html_camada_alterada.'").trigger("liszt:updated");',
                        'js'        =>  '',
                        'html'      =>  $html
                    );
                    $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
                    // SE tiver dependente chama denovo 
                    if($novoid!==0){
                        self::Select_Recarrega_Extrangeira($dominiosigla,$indice,$novoid);
                    }
                }
            }
        }
    }
    public function Valida_Cep($cep=false,$campos=false){
        
        $cep = str_replace(Array('-','.'), Array('',''), trim($cep));
        if(strlen($cep)!==8 || !is_numeric($cep)){
            // CEP INVALIDO
            
            
            return false;
        }
        $arquivo = 'http://cep.republicavirtual.com.br/web_cep.php?formato=php&cep='.$cep;
        $xmls = file_get_contents($arquivo);
        $xmls = preg_replace("/<!--[\S|\s]*?-->/", "", $xmls);
        $xml = simplexml_load_string($xmls);
        $resultado = (Array) $xml->resultado;
        
        if($resultado[0]==='0'){
            // CEP INVALIDO
            
            
            return false;
        }
        // Captura Informacoes e Cria UNIVERSAL
        $universal = new \Universal_Vivo_Cep_DAO();
        var_dump($xml,$resultado[0]);
        $estado = (Array) $xml->uf;
        $cidade = (Array) $xml->cidade;
        $bairro = (Array) $xml->bairro;
        $tipo_logradouro = (Array) $xml->tipo_logradouro;
        $logradouro = (Array) $xml->logradouro;
        
        // Procura Bairro
        $where      =   Array('nome'=>$bairro);
        $opcoes     =   $this->_Modelo->db->Sql_Select('Sistema_Local_Bairro', $where, 1);
        $where      =   Array('!nome'=>$bairro,'!id'=>$opcoes->id,'cidade'=>$opcoes->cidade);
        $html       =   $imprimir($opcoes,1);
        $opcoes     =   $this->_Modelo->db->Sql_Select('Sistema_Local_Bairro', $where);
        $html       .=  $imprimir($opcoes);
    }
    public function Valida_CPF($cpf=false,$campos=false){
        $info_cpf = $cpf;
        $cpf = (int) str_replace(Array('.',',','-'), Array('','',''), $cpf);
        $this->_Visual->Json_Info_Update('Historico', false);
        
        
        $sql_cpf = $this->_Modelo->db->Sql_Select('Universal_Vivo_Cpf',Array('cpf'=>$cpf),1);
        
        if($sql_cpf===false){       
            // Carrega XML
            $login = 'sierratecnologia';
            $senha = '1020943';
            $login_teste = 'teste';
            $senha_teste = 'teste';
            $arquivo = 'http://ws.fontededados.com.br/consulta.asmx/SituacaoCadastralPJ?login='.$login.'&senha='.$senha.'&cpf='.$cpf;
            $arquivo_teste = 'http://ws.fontededados.com.br/consulta.asmx/SituacaoCadastralPF?login='.$login_teste.'&senha='.$senha_teste.'&cpf='.$cpf;
            $xmls = file_get_contents($arquivo_teste);
            $xmls = preg_replace("/<!--[\S|\s]*?-->/", "", $xmls);
            $xml = simplexml_load_string($xmls);
            if($xml->CodErro!==0){
                $xmls = file_get_contents($arquivo);
                $xmls = preg_replace("/<!--[\S|\s]*?-->/", "", $xmls);
                $xml = simplexml_load_string($xmls);
            }
            if($xml->CodErro!==0){
                return false;
            }

            // CRIA CNPJ
            $sql_cpf = new \Universal_Vivo_Cnpj_DAO();
            $sql_cpf->cpf = $cpf;
            $sql_cpf->info_cpf = $info_cpf;
            $sql_cpf->info_nome = $xml->Nome;
            $sql_cpf->info_situacaocadastral = $xml->SituacaoCadastral;
            $sql_cpf->info_codigocontrole = $xml->CodigoControle;
            $sql_cpf->info_datahora = $xml->DataHora;
            $sql_cpf->extra_validado = '1';
            $this->_Modelo->db->Sql_Insert($sql_cpf);
        }
        
        if($campos!==false){
            $campos = explode(',', $campos);
            foreach($campos as &$valor){
                list($camada,$value) = explode('=', $valor);
                if(isset($sql_cpf->$value)){
                    // Json
                    $conteudo = array(
                        'location'  =>  '#'.$camada,
                        //'js'        =>  '$("#'.$html_camada_alterada.'").trigger("liszt:updated");',
                        'js'        =>  '',
                        'html'      =>  $sql_cpf->$value
                    );
                    $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
                }
            }
        }

        return true;
    }
    /**
     * BUSCA DE CNPJ
     */
    
    public function Valida_CNPJ($cnpj=false,$campos=false){
        $info_cnpj = $cnpj;
        $cnpj = (int) str_replace(Array('.',',','-'), Array('','',''), $cnpj);
        $this->_Visual->Json_Info_Update('Historico', false);
        
        
        $sql_cnpj = $this->_Modelo->db->Sql_Select('Universal_Vivo_Cnpj',Array('cnpj'=>$cnpj),1);
        
        if($sql_cnpj===false){
        
            // Carrega XML
            $login = 'sierratecnologia';
            $senha = '1020943';
            $login_teste = 'teste';
            $senha_teste = 'teste';
            $arquivo = 'http://ws.fontededados.com.br/consulta.asmx/SituacaoCadastralPJ?login='.$login.'&senha='.$senha.'&cnpj='.$cnpj;
            $arquivo_teste = 'http://ws.fontededados.com.br/consulta.asmx/SituacaoCadastralPJ?login='.$login_teste.'&senha='.$senha_teste.'&cnpj='.$cnpj;
            $xmls = file_get_contents($arquivo_teste);
            $xmls = preg_replace("/<!--[\S|\s]*?-->/", "", $xmls);
            $xml = simplexml_load_string($xmls);
            if($xml->CodErro!==0){
                $xmls = file_get_contents($arquivo);
                $xmls = preg_replace("/<!--[\S|\s]*?-->/", "", $xmls);
                $xml = simplexml_load_string($xmls);
            }
            if($xml->CodErro!==0){
                return false;
            }
            $cep_num = $xml->CEP;
            $cep_num = (int) str_replace(Array('.',',','-'), Array('','',''), $cep_num);
            $cons_cep = $this->_Modelo->db->Sql_Select('Universal_Vivo_Cep',Array('cep'=>$cep_num),1);

            if($cons_cep!==false){
                // cria CEP
                $sql_cep = new \Universal_Vivo_Cep_DAO();
                $sql_cep->info_logradouro = $xml->Logradouro;
                $sql_cep->info_cep = $cep_num;
                $sql_cep->info_bairro = $xml->Bairro;
                $sql_cep->info_municipio = $xml->Municipio;
                $sql_cep->info_uf = $xml->UF;
                $sql_cep->extra_validado = '1';
                $this->_Modelo->db->Sql_Insert($sql_cep);
            }

            // CRIA CNPJ
            $sql_cnpj = new \Universal_Vivo_Cnpj_DAO();
            $sql_cnpj->cnpj = $cnpj;
            $sql_cnpj->info_cnpj = $info_cnpj;
            $sql_cnpj->info_cep = $cep_num;
            $sql_cep->info_numero = $xml->Numero;
            $sql_cep->info_complemento = $xml->Complemento;
            $sql_cnpj->info_dataabertura = $xml->DataAbertura;
            $sql_cnpj->info_nomeempresa = $xml->NomeEmpresa;
            $sql_cnpj->info_nomefantasia = $xml->NomeFantasia;
            $sql_cnpj->info_atividadeprincipal = $xml->AtividadePrincipal;
            $sql_cnpj->info_atividadesecundaria = $xml->AtividadeSecundaria;
            $sql_cnpj->info_naturezajuridica = $xml->NaturezaJuridica;
            $sql_cnpj->info_situacaocadastral = $xml->SituacaoCadastral;
            $sql_cnpj->info_datasituacaocadastral = $xml->DataSituacaoCadastral;
            $sql_cnpj->info_dataabertura = unserialize($xml->MotivoSituacaoCadastral);
            $sql_cnpj->info_situacaoespecial = $xml->SituacaoEspecial;
            $sql_cnpj->info_datasituacaoespecial = $xml->DataSituacaoEspecial;

            $sql_cnpj->extra_validado = '1';
            $this->_Modelo->db->Sql_Insert($sql_cnpj);
        }
        
        if($campos!==false){
            $campos = explode(',', $campos);
            foreach($campos as &$valor){
                list($camada,$value) = explode('=', $valor);
                if(isset($sql_cnpj->$value)){
                    // Json
                    $conteudo = array(
                        'location'  =>  '#'.$camada,
                        //'js'        =>  '$("#'.$html_camada_alterada.'").trigger("liszt:updated");',
                        'js'        =>  '',
                        'html'      =>  $sql_cnpj->$value
                    );
                    $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
                }
            }
        }
        return true;
    }
    
    
}
?>