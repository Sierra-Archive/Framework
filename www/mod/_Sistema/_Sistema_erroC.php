<?php

class _Sistema_erroControle extends _Sistema_Controle
{
    public function __construct(){
        parent::__construct();
    }
    public function Main($codigo = false){
        if(LAYOULT_IMPRIMIR=='AJAX'){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Erro '.$codigo,
                "mgs_secundaria" => self::_getError($codigo)
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }else{
            // CAso login invalido
            if($codigo=='5051'){
                
                $this->_Visual->Javascript_Executar('alert(\'Login ou senha Inválida\');');
                $this->_Visual->renderizar_login();
                self::Tema_Travar();
            }
            $this->_Visual->Blocar(self::_getError($codigo));
            $this->_Visual->Bloco_Maior_CriaJanela('Erro '.$codigo);
        }
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Erro ').$codigo);
    }
    static function Erro_Puro($codigo){
        $Visual = new \Framework\App\Visual(false);
        $Visual->Blocar(self::_getError($codigo));
        $Visual->Bloco_Unico_CriaJanela('Erro '.$codigo);
        $Visual->Json_Info_Update('Titulo', __('Erro ').$codigo);
        $Visual->renderizar();echo $codigo;
        self::Tema_Travar();
    }
    private static function _getError($codigo = false){
        if($codigo){
            $codigo = (int) $codigo;
        }else{
            $codigo = 'default';
        }
        
        
        /*Client Request Errors

    400 Bad Request
    401 Authorization Required
    402 Payment Required (not used yet)
    403 Forbidden
    404 Not Found
    405 Method Not Allowed
    406 Not Acceptable (encoding)
    407 Proxy Authentication Required
    408 Request Timed Out
    409 Conflicting Request
    410 Gone
    411 Content Length Required
    412 Precondition Failed
    413 Request Entity Too Long
    414 Request URI Too Long
    415 Unsupported Media Type

Server Errors

    500 Internal Server Error
    501 Not Implemented
    502 Bad Gateway
    503 Service Unavailable
    504 Gateway Timeout
    505 HTTP Version Not Supported
*/
        
        
        
        $error['default'] = 'Um erro ocorreu e a página não pode ser mostrada.';
        
        $error['401']     = 'Você necessita estar autenticado.';
        $error['403']     = 'Acesso Proibido.';
        $error['404']     = 'Essa página não existe em nossos servidores.';
        
        $error['2800']    = 'Problema no código, ligue para o administrador.';
        $error['2801']    = 'Problema no código, ligue para o administrador.';
        $error['2802']    = 'Faltando arquivos ao Sistema.';
        $error['2808']    = 'Problemas de Performace.';
        $error['2810']    = 'Problema no código. Parametro Errado';
        
        $error['2812']    = 'Array Inválido';
        
        
        $error['2826']    = 'Sem Permissão de Arquivos.';
        $error['2828']    = 'Servidor não autorizado, por favor consulte o administrador.';
        
        $error['2901']    = 'Grupo Inexistente';
        
        
        $error['3030']    = 'Inconsistência de Dados';
        $error['3040']    = 'Data Inválida';
        
        $error['3100']    = 'Erro de conexão com o servidor.';
        $error['3101']    = 'Erro de conexão com o servidor.';
        $error['3102']    = 'Erro de conexão com o servidor.';
        $error['3103']    = 'Erro de conexão com o servidor.';
        $error['3104']    = 'Erro de conexão com o servidor.';
        $error['3105']    = 'Erro de acento no banco de dados.';
        $error['3110']    = 'Erro de mysql.';
        $error['3120']    = 'Erro de chave primária';
        $error['3121']    = 'Erro de condição de query';
        $error['3130']    = 'Faltando Parametros de MYSQL';
        $error['3200']    = 'Query Inconsistente';
        $error['3250']    = 'DAO Inconsistente';
        $error['3251']    = 'DAO não existe';
                
        // LOGIN
        $error['5050']    = 'Essa página tem acesso restrito.';
        $error['5051']    = 'Login ou Senha inválida.';
        $error['5052']    = 'Acesso negado devido a falta de pagamento.';
        $error['5060']    = 'Sessão Expirada, faça o login novamente.';
        //PRedial
        $error['5061']    = 'Esse Apartamento não existe.';
        $error['5062']    = 'Esse Bloco não existe.';
        if($codigo==5063) $error['5063']    = 'Esse '.Framework\Classes\Texto::Transformar_Plural_Singular(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome')).' já está registrado';
        
        // Códigos de SEgurança
        $error['6010']    = 'Essa solicitação foi bloqueada por segurança.';
        
        
        // Erros de Template
        $error['7000']      = 'Erro no Tema';
        
        // Erros de URL
        $error['8010']    = 'Registro não existe.';
        $error['8110']    = 'Não existe nenhum Produto para comercializar';
        
        
        $error['9010']    = 'Você já votou nessa enquete.';
        
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }else{
            return $error['default'];
        }
        
        
    }
    /**
     * Trata Erros de paginas que sao enviadas ao Javascript
     */
    public function Javascript(){
        $this->Main(404);
    }
}
?>