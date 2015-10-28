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
     * @param int $id Chave Primária (Id do Registro)
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
        $alterado = $dominio['classe'];
        $alterado = new $alterado();
        // PRimeiro Foreach
        //var_dump($alterado,$alterado->Get_Extrangeiras_ComExterna());
        $alterado = $alterado->Get_Extrangeiras_ComExterna();
        
        if($alterado===false) return true;
        
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
        
        
        
        $arquivo = 'http://cep.republicavirtual.com.br/web_cep.php?formato=php&cep='.$cep;
        $xmls = file_get_contents($arquivo);
        $xmls = preg_replace("/<!--[\S|\s]*?-->/", "", $xmls);
        $xml = simplexml_load_string($xmls);
        $resultado = (Array) $xml->resultado;
        
        if($resultado[0]==='0'){
            // CEP INVALIDO
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
        // Captura Informacoes e Cria UNIVERSAL
        $universal = new \Universal_Vivo_Cep_DAO();
        //var_dump($xml,$resultado[0]);
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
        
        return true;
    }
    public function Valida_CPF($cpf=false,$campos=false){
        $info_cpf = $cpf; //$cpf;
        $cpf = (int) str_replace(Array('.',',','-'), Array('','',''), $cpf/*$cpf*/);
        $this->_Visual->Json_Info_Update('Historico', false);
        
        $invalido = false;
        if($invalido){
            // CEP INVALIDO
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Cpf Inválido'),
                "mgs_secundaria"    => __('Por favor forneça um CPF válido')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Javascript_Executar(
                    '$("#cpf").css(\'border\', \'2px solid #FFAEB0\').focus();'
            );
            $this->_Visual->Json_Info_Update('Historico', false);
            $this->layoult_zerar = false; 
            
            return false;
        }
        
        $sql_cpf = $this->_Modelo->db->Sql_Select('Universal_Vivo_Cpf',Array('cpf'=>$cpf),1);

        if($sql_cpf===false){       
            // Carrega XML            
            $arquivo_teste = 'http://www.situacaocadastral.com.br/';
 
            // Pega COOKIES e JS
            $headers = array (
            'HTTP_ACCEPT'           => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8', 
            'HTTP_ACCEPT_LANGUAGE'  => 'en-US,en;q=0.5',
            'HTTP_ACCEPT_ENCODING'  => 'gzip, deflate',
            'HTTP_DNT'              => '1',
            'HTTP_CONNECTION'       => 'keep-alive'
            );
            $ch=curl_init();
            curl_setopt($ch,    CURLOPT_URL,$arquivo_teste);
            curl_setopt($ch,    CURLOPT_PROXY, SISTEMA_PROXY); 
            curl_setopt($ch,    CURLOPT_AUTOREFERER,         true);
            curl_setopt($ch,    CURLOPT_COOKIESESSION,         true);
            curl_setopt($ch,    CURLOPT_FAILONERROR,         false);
            curl_setopt($ch,    CURLOPT_FOLLOWLOCATION,        false);
            curl_setopt($ch,    CURLOPT_FRESH_CONNECT,         true);
            curl_setopt($ch,    CURLOPT_HEADER,             true);
            curl_setopt($ch,    CURLOPT_POST,                 true);
            curl_setopt($ch,    CURLOPT_RETURNTRANSFER,        true);
            curl_setopt($ch,    CURLOPT_CONNECTTIMEOUT,     300);
            $result = curl_exec($ch) or die (curl_error($ch));
            preg_match_all('/Set-Cookie: (.*?; path=.*?)\n/', $result, $matches);
            array_shift($matches);
            $cookie = implode("\n", $matches[0]);
            preg_match_all('/fprint\.js.*\n.*js\/(.*)\.js/', $result, $matches);
            array_shift($matches);
            $js = implode("\n", $matches[0]);
            
            
            // Carrega JS
            curl_setopt($ch,    CURLOPT_URL,$arquivo_teste.'js/'.$js.'.js');
            curl_setopt($ch,    CURLOPT_PROXY, SISTEMA_PROXY); 
            curl_setopt($ch,    CURLOPT_AUTOREFERER,         true);
            curl_setopt($ch,    CURLOPT_COOKIESESSION,         true);
            curl_setopt($ch,    CURLOPT_COOKIE,         $cookie);
            curl_setopt($ch,    CURLOPT_FAILONERROR,         false);
            curl_setopt($ch,    CURLOPT_FOLLOWLOCATION,        false);
            curl_setopt($ch,    CURLOPT_FRESH_CONNECT,         true);
            curl_setopt($ch,    CURLOPT_HEADER,             true);
            curl_setopt($ch,    CURLOPT_POST,                 true);
            curl_setopt($ch,    CURLOPT_RETURNTRANSFER,        true);
            curl_setopt($ch,    CURLOPT_CONNECTTIMEOUT,     300);
            $result = curl_exec($ch) or die (curl_error($ch));
            
            // Pega Campo hidden no javascript
            preg_match_all('/type:\'hidden\', name: \'([A-z0-9]*)\'\}\)/', $result, $matches);
            array_shift($matches);
            $js = $matches[0][0].'=MjQwMzkxODU0fE1vemlsbGEvNS4wIChYMTE7IFVidW50dTsgTGludXggeDg2XzY0OyBydjo0My4wKSBHZWNrby8yMDEwMDEwMSBGaXJlZm94LzQzLjB8aHR0cDovL3d3dy5zaXR1YWNhb2NhZGFzdHJhbC5jb20uYnIvfGh0dHA6Ly93d3cuc2l0dWFjYW9jYWRhc3RyYWwuY29tLmJyL3x0cnVlfDE5MjB4MTA4MHgyNHwxOTE0eDUwOA==';

            
            // Then, once we have the cookie, let's use it in the next request:
            curl_setopt($ch,    CURLOPT_URL,$arquivo_teste);
            curl_setopt($ch,    CURLOPT_PROXY, SISTEMA_PROXY); 
            curl_setopt($ch,    CURLOPT_REFERER,         $arquivo_teste);
            curl_setopt($ch,    CURLOPT_COOKIESESSION,         false);
            curl_setopt($ch,    CURLOPT_FAILONERROR,         false);
            curl_setopt($ch,    CURLOPT_FOLLOWLOCATION,        false);
            curl_setopt($ch,    CURLOPT_FRESH_CONNECT,         true);
            curl_setopt($ch,    CURLOPT_HEADER,             true);
            curl_setopt($ch,    CURLOPT_CONNECTTIMEOUT,     300);
            curl_setopt($ch,    CURLOPT_RETURNTRANSFER,        true);
            curl_setopt($ch,    CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:43.0) Gecko/20100101 Firefox/43.0');
            curl_setopt($ch,    CURLOPT_POST, true);
            curl_setopt($ch,    CURLOPT_POSTFIELDS, 'doc='.$cpf.'&'.$js);
            curl_setopt($ch,    CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch) or die (curl_error($ch));
            curl_close($ch);
            
            if(stripos($result, '<span class="dados">')!==false){
                
                // Pega nome
                $dados_retorno = Array('cpf'=>$info_cpf);
                preg_match_all('/<span class="dados">(.*?)<\/span>/', $result, $matches);
                array_shift($matches);
                $dados_retorno['nome'] = $matches[0][0].

                // Condicao da Receira Federal
                preg_match_all('/<span class="dados texto">(.*?)<\/span>/', $result, $matches);
                array_shift($matches);
                if('* Sem pendência cadastral na Receita Federal.'){
                    $dados_retorno['situacao'] = '1';
                }else{
                    $dados_retorno['situacao'] = '0';
                }
                
                // CRIA CPF
                $sql_cpf = new \Universal_Vivo_Cpf_DAO();
                $sql_cpf->cpf = $cpf;
                $sql_cpf->info_cpf = $info_cpf;
                $sql_cpf->info_nome = $dados_retorno['nome'];
                $sql_cpf->info_situacaocadastral = $dados_retorno['situacao'];
                $sql_cpf->extra_validado = '1';
                $this->_Modelo->db->Sql_Insert($sql_cpf);
            }else{
                // CEP INVALIDO
                $mensagens = array(
                    "tipo"              => 'erro',
                    "mgs_principal"     => __('Cpf Inválido'),
                    "mgs_secundaria"    => __('Por favor forneça um CPF válido')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                $this->_Visual->Javascript_Executar(
                        '$("#cpf").css(\'border\', \'2px solid #FFAEB0\').focus();'
                );
                $this->_Visual->Json_Info_Update('Historico', false);
                $this->layoult_zerar = false; 

                return false;
            }
        }else{
            $dados_retorno = Array(
                'cpf' => $info_cpf,
                'nome' => $sql_cpf->info_nome,
                'situacao' => $sql_cpf->info_situacaocadastral
            );
        }
        if($campos!==false && trim($campos)!=='' && !is_int($campos)){
            $campos = \explode(',', $campos);
            foreach($campos as &$valor){
                if(strpos('=',$valor)===false){
                    continue;
                }
                list($camada,$value) = \explode('=', $valor);
                if(isset($dados_retorno[$value])){
                    // Json
                    $conteudo = [
                        'location'  =>  '#'.$camada,
                        'js'        =>  '',
                        'html'      =>  $dados_retorno[$value]
                    ];
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