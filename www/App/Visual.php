<?php 
namespace Framework\App;
/**
 * 
 * \Framework\App\Visual::
 */
class Visual
{
    // Registro e Classes do Framework
    /**
     * Armazena a Classe Registro (Classe singleton, ela garante a existencia de apenas uma instancia de cada classe)
     * @var Object 
     */
    protected $_Registro;
    /**
     * Classe de Controle de Acesso
     * @var Object 
     */
    protected $_Acl;
    
    // Config Visual
    private $head_js                    = '';
    
    // Staticas
    /**
     * Garante que os Ids das Abas e Divs nao irao se Repetir
     * @var int 
     */
    public static $layoult_idaleatorio      = 0;
    /**
     * Armazena o Arquivo de COnfiguracoes do Template dentro dela
     * @var function 
     */
    public static $config_template;
    
    // Lang
    /**
     * Linguagem que o sistema carregara (Ainda nao esta implementado em outra lingua)
     * @var type 
     */
    protected $sistema_linguagem        = 'ptBR';
    /**
     * Tipo de Layoult, Pode ser 0 Normal, 1 Ajax, ou 2 So COnteudo PURO
     * @var type 
     */
    protected $Layolt_Tipo              = 0;

    // Variaveis de Template
    /**
     * Nome do Tema, e o mesmo nome da pasta do tema dentro de /Layoult
     * @var varchar 
     */
    private $template_layoult           = TEMA_PADRAO;
    /**
     * Local de Armazenamento do Template atraves do HTTP, cliente
     * @var varchar 
     */
    private $template_url;
    /**
     * Local de Armazenamento do Template dentro do Servidor
     * @var varchar 
     */
    private $template_dir;
    /**
     * Local de Armazenamento do Config Template
     * @var varchar 
     */
    private $template_config_dir;
    /**
     * Diversos Widgets em Diferentes Formatos que serao usados pelo tema armazenado em /Layoult
     * @var type 
     */
    private $_widgets_params            = Array();
    
    // Minimiza
    private $arquivos_js                = Array();
    private $arquivos_css               = Array();
    private $arquivos_js_dependencia    = Array();
    private $arquivos_css_dependencia   = Array();
    
    // Variaveis do Json
    /**
     * Se o Json do HTML esta sendo usado (Ele sempre sera usado, em todas as requisicoes)
     * @var type 
     */
    private $jsonativado                = false;
    private $json                       = array();
    /**
     * Quantidade de Tipos sendo Usados dentro do Json do HTML
     * @var int 
     */
    private $jsontipoqnt                = 0;
    
    // Manipulação dos Blocos
    /**
     * Somente e Usado se o Tipo de Layoult for 2
     * Se for usado seu conteudo sera colado na tela
     * @var varchar 
     */
    private     $conteudo;
    protected   $blocos                 = Array();
    protected   $Layoult_BlocoUnico     = Array();
    protected   $Layoult_BlocoMaior     = Array();
    protected   $Layoult_BlocoMenor     = Array();
    // Widgets
    protected static $widgets_inline        = Array();

    //menu
    private $contmenu                   = ''; //janelas do menu
    public  $menu                       = array(
        'link'      => Array(),
        'nome'      => Array(),
        'img'       => Array(),
        'ativo'     => Array(),
        'icon'      => Array(),
        'filhos'    => Array()
    ); // menus (nomes e links)
    
    /**
    * Construtor
    *  HTML -> Contem todo o HEAD e a estrutura HTML menos o conteudo dentro do BODY
    * 
    * @name __construct
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct($naozerado=true) {
        $imprimir = new \Framework\App\Tempo('Construcao Visual - SEM SMARTY');
        if($naozerado){
            self::$config_template    = config_template();
            $this->_Registro        = &\Framework\App\Registro::getInstacia();
            $this->_Acl             = &$this->_Registro->_Acl;
        }
        
        $this->template_url        = URL_PATH.'layoult'.US.$this->template_layoult.US;
        $this->template_dir        = ROOT.'layoult'.DS.$this->template_layoult.DS;
    }
    /**
     * 
     * @param type $javascript
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Javascript_Executar($javascript=''){
        // Se parametro vier falso, zera javascript pra executar
        if($javascript===false){
            $this->head_js = '';
            return true;
        }else
        // Se parametro nao for falso e igual a zero entao add js
        if($javascript!==''){
            $this->head_js .= $javascript;
            return true;
        }else
        // Caso contrario (seja só vazio), retorna o js
        {
            return $this->head_js;
        }
    }
    /**
     * 
     * @param type $blocos
     * @param type $add
     * @param type $gravidade
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bloco_Customizavel($blocos,$add=true,$gravidade=0){
        if(!is_array($blocos)) return false;
        $i = 0;
        foreach($blocos as &$valor){
            if(!is_array($valor)) return false;
            $tamanho[$i]    = $valor['span'];
            $html[$i]       = '';
            foreach($valor['conteudo'] as &$valor2){
                $id = '';
                if($valor2['title_id']!==false){
                    $id = ' id="'.$valor2['title_id'].'"';
                }
                $bloco = Array(
                    'Tipo'          => 'Bloco',
                    'div_ext'       => $valor2['div_ext'],
                    'titulo'        => $valor2['title'],
                    'titulo_ext'    => $id,
                    'tamanho'       => $tamanho[$i],
                    'conteudo_tipo' => 'Normal',
                    'conteudo'      => $valor2['html'],
                    'btn_extra'     => false
                );
                $html[$i] .= $this->renderizar_bloco('template_bloco',$bloco);
            }
            ++$i;
        }
        if($i<1) return false;
        $bloco = Array(
            'Tipo'          => 'Customizavel',
            'tamanho'       => $tamanho,
            'conteudo'      => $html
        );
        if($add===true){
            $this->Layoult_BlocoUnico[] = Array(
                'html'      => $this->renderizar_bloco('template_bloco',$bloco),
                'gravidade' => $gravidade
            );
        }else{
            return $this->renderizar_bloco('template_bloco',$bloco);
        }
        return true;
    }
    /**
    * Add Conteudo Sem titulo ao bloco principal
    * 
    * @name Bloco_Unico_CriaConteudo
    * @access public
    * 
    * @uses \Framework\App\Visual::$Layoult_BlocoUnico
    * @uses \Framework\App\Visual::$blocos 
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Bloco_Unico_CriaConteudo($gravidade=0) {
        list($tipo,$bloco) = $this->retornablocos();
        $this->Layoult_BlocoUnico[] = Array(
            'html'      => $bloco,
            'gravidade' => $gravidade
        );
    }
    /**
     * 
     * @param type $titulo
     * @param type $gravidade
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bloco_Unico_CriaTitulo($titulo, $gravidade=0) {
        list($tipo,$bloco) = $this->retornablocos();
        $identificador = 'div_unico_titulo_'.rand(100000, 999999);
        $config = Array(
            'Id'            => $identificador,
            'Tipo'          => 'Bloco',
            'div_ext'       => '',    // atributos extras para camada externa
            'titulo'        => $titulo,
            'titulo_ext'    => '',    //atributos extras para h4
            'tamanho'       => 12,
            'conteudo_tipo' => $tipo,
            'conteudo'      => $bloco,
            'btn_extra'     => false
        );
        $html = $this->renderizar_bloco('template_bloco',$config);
        $this->Layoult_BlocoUnico[] = Array(
            'html' => $html,
            'gravidade' => $gravidade
        );
    }
    /**
     * 
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bloco_Unico_Retornar(){
        $html = '';
        orderMultiDimensionalArray($this->Layoult_BlocoUnico, 'gravidade', true);
        reset($this->Layoult_BlocoUnico);
        foreach($this->Layoult_BlocoUnico as &$valor){
            $html .= $valor['html'];
        }
        // Apaga Bloco unico ja que ja foi usado
        $this->Bloco_Unico_Zerar();
        return $html;
    }
    /**
     * 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    protected function Bloco_Unico_Zerar(){
        $this->Layoult_BlocoUnico = array();
    }
    /**
     * Add Conteudo Com titulo ao conteudo que engloba tudo
     * 
     * @name Bloco_Unico_CriaJanela
     * @access public
     * 
     * @param string $titulo
     * @param string $url
     * @param int $gravidade Quanto maior mais em cima ficara
     * @param string $botaoextra Array(icon,nome,link) or Javascript String
     * @param type $fechado
     * @return string
     * @throws \Exception
     * 
     * @uses \Framework\App\Visual::$Layoult_BlocoUnico
     * @uses \Framework\App\Visual::$blocos 
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.02
     */
    public function Bloco_Unico_CriaJanela($titulo,$url='', $gravidade=0,$botaoextra = false, $fechado=false) {
        if($url!='') $titulo = $titulo.'<a class="lajax-admin" href="'.$url.'" acao="">+</a>';
        list($tipo,$bloco) = $this->retornablocos();
        $identificador = 'div_unica_'.rand(100000, 999999);
        if(is_array($botaoextra)){
            if(!(isset($botaoextra['link']) && isset($botaoextra['icon']) && isset($botaoextra['nome']))){
                throw new \Exception('Botao Extra com Indices Faltando: '.serialize($botaoextra),2812);
            }else{
                $botaoextra['link'] = URL_PATH.$botaoextra['link'];
            }
        }
        $config = Array(
            'Id'            => $identificador,
            'Tipo'          => 'Bloco',
            'div_ext'       => '',    // atributos extras para camada externa
            'titulo'        => $titulo,
            'titulo_ext'    => '',    //atributos extras para h4
            'tamanho'       => 12,
            'conteudo_tipo' => $tipo,
            'conteudo'      => $bloco,
            'btn_extra'     => $botaoextra,
            'opc_fechada'   => $fechado
        );
        $html = $this->renderizar_bloco('template_bloco',$config);
        $this->Layoult_BlocoUnico[] = Array(
            'html' => $html,
            'gravidade' => $gravidade
        );
        return $identificador;
    }
    /**
    * Add Conteudo Sem titulo ao lado da esquerda
    * 
    * @name Bloco_Maior_CriaConteudo
    * @access public
    * 
    * @uses \Framework\App\Visual::$Layoult_BlocoMaior
    * @uses \Framework\App\Visual::$blocos 
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Bloco_Maior_CriaConteudo($gravidade=0) {
        list($tipo,$bloco) = $this->retornablocos();
        $this->Layoult_BlocoMaior[] = Array(
            'html' => $bloco,
            'gravidade' => $gravidade
        );
    }
    /**
     * 
     * @param type $titulo
     * @param type $gravidade
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bloco_Maior_CriaTitulo($titulo, $gravidade=0) {
        list($tipo,$bloco) = $this->retornablocos();
        $identificador = 'div_maior_titulo_'.rand(100000, 999999);
        $config = Array(
            'Id'            => $identificador,
            'Tipo'          => 'Bloco',
            'div_ext'       => '',    // atributos extras para camada externa
            'titulo'        => $titulo,
            'titulo_ext'    => '',    //atributos extras para h4
            'tamanho'       => 8,
            'conteudo_tipo' => $tipo,
            'conteudo'      => $bloco,
            'btn_extra'     => false
        );
        $html = $this->renderizar_bloco('template_bloco',$config);
        $this->Layoult_BlocoMaior[] = Array(
            'html' => $html,
            'gravidade' => $gravidade
        );
    }
    /**
     * O Template do SIstema é Divididos em um bloco Unico, embaixo um maior e um menor lado a lado.
     * Essa função Retorna os Dados desse Bloco em ordem de 'gravidade' e retorna o html
     * 
     * @return varchar
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Bloco_Maior_Retornar(){
        $html = '';
        orderMultiDimensionalArray($this->Layoult_BlocoMaior, 'gravidade', true);
        reset($this->Layoult_BlocoMaior);
        foreach($this->Layoult_BlocoMaior AS &$valor){
            $html .= $valor['html'];
        }
        // Apaga Bloco maior ja que ja foi usado
        $this->Bloco_Maior_Zerar();
        return $html;
    }
    /**
     * Zera o Conteudo do Bloco Maior
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Bloco_Maior_Zerar(){
        $this->Layoult_BlocoMaior = array();
    }
    /**
     * Add Conteudo Com titulo no lado da esquerda
     * NO bloco Maior
     * 
     * @name Bloco_Maior_CriaJanela
     * @access public
     * 
     * 
     * @param string $titulo Titulo Superior da Janela
     * @param varchar $url Link de Url de Add (Caso nao senha deixar em branco ='')
     * @param int $gravidade Ordem de PRioridade, quanto maior, mais em cima vai ficar
     * @param mixed $botaoextra Se não tiver um botão extra, fica em false
     * @param bolean $fechado Se esta aberto ou fechado
     * @return void
     * 
     * @uses \Framework\App\Visual::$Layoult_BlocoMaior
     * @uses \Framework\App\Visual::$blocos 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.02
     */
    public function Bloco_Maior_CriaJanela($titulo,$url='', $gravidade=0,$botaoextra = false, $fechado=false) {
        if($url!='') $titulo = $titulo.'<a class="lajax-admin" href="'.$url.'" acao="">+</a>';
        list($tipo,$bloco) = $this->retornablocos();
        $identificador = 'div_maior_'.rand(100000, 999999);
        $config = Array(
            'Id'            => $identificador,
            'Tipo'          => 'Bloco',
            'div_ext'       => '',    // atributos extras para camada externa
            'titulo'        => $titulo,
            'titulo_ext'    => '',    //atributos extras para h4
            'tamanho'       => 8,
            'conteudo_tipo' => $tipo,
            'conteudo'      => $bloco,
            'btn_extra'     => $botaoextra,
            'opc_fechada'   => $fechado
        );
        $html = $this->renderizar_bloco('template_bloco',$config);
        $this->Layoult_BlocoMaior[] = Array(
            'html' => $html,
            'gravidade' => $gravidade
        );
    }
    /**
     * Add Conteudo Sem titulo ao lado da direita
     * 
     * @name Bloco_Menor_CriaConteudo
     * @access public
     * 
     * @param int $gravidade Quanto Maior Mais em cima
     * 
     * @uses \Framework\App\Visual::$Layoult_BlocoMenor
     * @uses \Framework\App\Visual::$blocos 
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Bloco_Menor_CriaConteudo($gravidade=0) {
        list($tipo,$bloco) = $this->retornablocos();
        $this->Layoult_BlocoMenor[] = Array(
            'html' => $bloco,
            'gravidade' => $gravidade
        );
    }
    /**
     * Cria um Titulo no Bloco Menor
     * @param varchar $titulo
     * @param int $gravidade Quanto Maior, mais prioridade, mais emcima.
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bloco_Menor_CriaTitulo($titulo,$gravidade=0) {
        if($url!='') $titulo = $titulo.'<a class="lajax-admin" href="'.$url.'" acao="">+</a>';
        list($tipo,$bloco) = $this->retornablocos();
        $identificador = 'div_menor_titulo_'.rand(100000, 999999);
        $config = Array(
            'Id'            => $identificador,
            'Tipo'          => 'Bloco',
            'div_ext'       => '',    // atributos extras para camada externa
            'titulo'        => $titulo,
            'titulo_ext'    => '',    //atributos extras para h4
            'tamanho'       => 4,
            'conteudo_tipo' => $tipo,
            'conteudo'      => $bloco,
            'btn_extra'     => false
        );
        $this->Layoult_BlocoMenor[] = Array(
            'html' => $this->renderizar_bloco('template_bloco',$config),
            'gravidade' => $gravidade
        );
    }
    /**
     * Retorna os blocos Menores
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Bloco_Menor_Retornar(){
        $html = '';
        orderMultiDimensionalArray($this->Layoult_BlocoMenor, 'gravidade', true);
        reset($this->Layoult_BlocoMenor);
        foreach($this->Layoult_BlocoMenor AS &$valor){
            $html .= $valor['html'];
        }
        $this->Bloco_Menor_Zerar();
        return $html;
    }
    /**
     * Zera os Blocos Menores
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Bloco_Menor_Zerar(){
        $this->Layoult_BlocoMenor = array();
    }
    /**
     * Criar Bloco no Lado direito, no bloco Menor
     * @param string $titulo
     * @param type $gravidade
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bloco_Menor_CriaJanela($titulo,$url='', $gravidade=0,$botaoextra = false, $fechado=false) {
        if($url!='') $titulo = $titulo.'<a class="lajax-admin" href="'.$url.'" acao="">+</a>';
        list($tipo,$bloco) = $this->retornablocos();
        $identificador = 'div_menor_'.rand(100000, 999999);
        $config = Array(
            'Id'            => $identificador,
            'Tipo'          => 'Bloco',
            'div_ext'       => '',    // atributos extras para camada externa
            'titulo'        => $titulo,
            'titulo_ext'    => '',    //atributos extras para camada externa
            'tamanho'       => 4,
            'conteudo_tipo' => $tipo,
            'conteudo'      => $bloco,
            'btn_extra'     => $botaoextra,
            'opc_fechada'   => $fechado
        );
        $this->Layoult_BlocoMenor[] = Array(
            'html'          => $this->renderizar_bloco('template_bloco',$config),
            'gravidade'     => $gravidade
        );
    }
    /**
     * Pega Um titulo e todo o conteudo armazenado nos blocos e add ao Conteudo
     * @param varchar $titulo
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function janelaajax($titulo) {
        list($tipo,$bloco) = $this->retornablocos();
        $this->conteudo .= $titulo.'<br>'.$bloco.'';
    }
    /**
     * Cria e Armazena um Conteudo HTML na memória do Sistema
     * 
     * @param type $txt Texto html ou titulo caso tenha o 2 parametro
     * @param type $txt2 Texto html se o primeiro parametro for o titulo
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Blocar($txt,$txt2 = false){
        if($txt2===false){
            $this->blocos[] = $txt;
        }else{
            $this->blocos[] = Array(
                'title' =>  $txt,
                'bloco' =>  $txt2
            );
        }
    }
    /**
     * ARmazena dependencia de arquivo js por requerimento do sistema
     * 
     * @param type $endereco
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Arquivos_Js($endereco){
        if(is_array($endereco)){
            $js = &$this->arquivos_js;
            reset($endereco);
            while(key($endereco)!==NULL){
                $end_current = current($endereco);
                if(array_search($end_current, $js)===false){
                    $js[] = $end_current;
                }
                next($endereco);
            }
        }else{
            if(array_search($endereco, $this->arquivos_js)===false){
                $this->arquivos_js[] = $endereco;
            }
        }
    }
    /**
     * ARmazena dependencia de arquivo js Por Requirimento de Modulo
     * 
     * @param type $endereco
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Arquivos_Js_Dependencia($endereco){
        if(is_array($endereco)){
            $js = &$this->arquivos_js_dependencia;
            reset($endereco);
            while(key($endereco)!==NULL){
                $end_current = current($endereco);
                if(array_search($end_current, $js)===false){
                    $js[] = $end_current;
                }
                next($endereco);
            }
        }else{
            if(array_search($endereco, $this->arquivos_js_dependencia)===false){
                $this->arquivos_js_dependencia[] = $endereco;
            }
        }
    }
    /**
     * Cria Arquivo Unico
     * 
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Arquivos_Js_Get(){
        $this->arquivos_js = array_merge($this->arquivos_js, $this->arquivos_js_dependencia);
        if(empty($this->arquivos_js)) return false;
        //'<script type="text/javascript" src="'.WEB_URL.'"></script>'.
        
        // Cria Cache
        $this->Javascript_Executar('Sierra.Sessao_Deletar(\'Dependencias_Js\');'
                . 'setTimeout(function(){Sierra.Sessao_Gravar(\'Dependencias_Js\',\''.implode('|',$this->arquivos_js).'\');},10);');
        
        return '<script type="text/javascript" src="'.WEB_URL.'min/?f='.implode(".js,",$this->arquivos_js).'.js"></script>';
    }
    /**
     * Cria Arquivo Unico Dependente
     * 
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Arquivos_Js_Get_Dependentes(){
        if(empty($this->arquivos_js_dependencia)) return false;
        //'<script type="text/javascript" src="'.WEB_URL.'"></script>'.
        return $this->arquivos_js_dependencia;
        //return WEB_URL.'min/?f='.implode(".js,",$this->arquivos_js_dependencia);
    }
    /**
     * ARmazena Arquivos CSS
     * 
     * @param type $endereco
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Arquivos_Css($endereco){
        if(is_array($endereco)){
            $css = &$this->arquivos_css;
            reset($endereco);
            while(key($endereco)!==NULL){
                $end_current = current($endereco);
                if(array_search($end_current, $css)===false){
                    $css[] = $end_current;
                }
                next($endereco);
            }
        }else{
            if(array_search($this->arquivos_css, $endereco)===false){
                $this->arquivos_css[] = $endereco;
            }
        }
    }
    /**
     * ARmazena Arquivos CSS Por Requirimento de Modulo
     * 
     * @param type $endereco
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Arquivos_Css_Dependencia($endereco){
        if(is_array($endereco)){
            $css = &$this->arquivos_css_dependencia;
            reset($endereco);
            while(key($endereco)!==NULL){
                $end_current = current($endereco);
                if(array_search($end_current, $css)===false){
                    $css[] = $end_current;
                }
                next($endereco);
            }
        }else{
            if(array_search($endereco, $this->arquivos_css_dependencia)===false){
                $this->arquivos_css_dependencia[] = $endereco;
            }
        }
    }
    /**
     * Cria Arquivo Unico
     * 
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Arquivos_Css_Get(){
        $this->arquivos_css = array_merge($this->arquivos_css, $this->arquivos_css_dependencia);
        if(empty($this->arquivos_css)) return false;
        
        // Cria Cache
        $this->Javascript_Executar('Sierra.Sessao_Deletar(\'Dependencias_Css\');'
                . 'setTimeout(function(){Sierra.Sessao_Gravar(\'Dependencias_Css\',\''.implode('|',$this->arquivos_css).'\');},10);');
        
        return '<link href="'.WEB_URL.'min/?f='.implode(".css,",$this->arquivos_css).'.css" rel="stylesheet" />';
    }
    /**
     * Cria Arquivo Unico Dependente
     * 
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Arquivos_Css_Get_Dependentes(){
        if(empty($this->arquivos_css_dependencia)) return false;
        //'<script type="text/javascript" src="'.WEB_URL.'"></script>'.
        return $this->arquivos_css_dependencia;
        //return WEB_URL.'min/?f='.implode(".css,",$this->arquivos_css_dependencia);
    }
    
    /**
     * Carrega Tudo que For Essencial para que o Sistema RODE PERFEITAMENTE
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Sistema_Extras(){
        
        // Pega Config
        $temaconfig         = &self::$config_template['links_js'];
        // Carrega Javascripts
        $array_js = Array(
            // Linguagem
            'lang/'.$this->sistema_linguagem.'/Linguagem',
            // Identifica Oq cada Broser Suporta
            'sistema/modernizr/modernizr',
            // Jquery
            'sistema/jquery/jquery.min',
            // Detecta BRowser para Jquery
            'sistema/jquery.browser',
            // Historico HTML5
            'sistema/historico/jquery.history',
            // Carregamento igual Google
            'sistema/nprogress/nprogress',
            // Sistema de Mensagens
            'sistema/toastr/toastr.min',
            // Bloquear Tela
            'js/jquery/jquery.blockUI',
            
            'js/jquery/jquery.tabify',
            
            //'js/jquery/jquery-impromptu.3.1.min',
            
            // Mascara de Formulario
            'assets/bootstrap-mask/jquery.maskedinput-1.3.min',
            
            // Jquery UI
            //'sistema/jquery-ui/jquery-ui.min',
        
            'sistema/bootstrap/js/bootstrap',
            'sistema/bootstrap/js/bootstrap-fileupload',
        
            // DATATABLE
            'sistema/data-tables/jquery.dataTables',
        
            // FORMULARIOS
            //'assets/uniform/jquery.uniform.min',
            'sistema/chosen/chosen.jquery',
        
        
            //'assets/jquery-tags-input/jquery.tagsinput.min',
            // EDITAR HTML5
            //'assets/bootstrap-wysihtml5/wysihtml5-0.3.0',
            //'assets/bootstrap-wysihtml5/bootstrap-wysihtml5',
            // DIAL LIST
            'sistema/bootstrap-duallistbox/jquery.bootstrap-duallistbox',
        
        
            //'assets/jquery-slimscroll/jquery.slimscroll.min',
        
            // Formularios
            //'assets/bootstrap-inputmask/bootstrap-inputmask.min',
            //'assets/metr-folio/js/jquery.metro-gal.plugins.min',
            //'assets/metr-folio/js/jquery.metro-gal.megafoliopro',
            // Carrega Sistema
            'sistema/sistema'
        );
        
        // Carrega no JS
        $this->Arquivos_Js($array_js);
        
        // Começa Retorno
        return '<div class="push"></div>'.
        '<div id="escondido"></div>'.
        '<div class="growlUI" style="display:none;">'.
            '<h1>SierraTecnologia</h1> <h2>Ricardo Sierra <contato@ricardosierra.com.br></h2>'.
        '</div>'.
        '<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="popup" aria-hidden="true">'.
            '<div class="modal-dialog">'.
                '<div class="modal-content">'.
                    '<div class="modal-header">'.
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
                        '<h4 class="modal-title" id="popuptitulo">Popup</h4>'.
                    '</div>'.
                    '<div class="modal-body"></div>'.
                    '<div class="modal-footer"></div>'.
                '</div>'.
            '</div>'.
        '</div>'.
        //'<div id="dialog-confirm" title="Deletar Proposta?">'.
        //'<p><span class="ui-icon ui-glyphicon-alert" style="float:left; margin:0 7px 20px 0;"></span>Essa ação não pode ser revertida. Você esta certo disso?</p>'.
        //'</div>'.
        // Arquivo JS
        $this->Arquivos_Js_Get().
        '<script type="text/javascript" language="javascript">'.
        '$(document).ready(function() {'.
            $this->js_local().
            $this->Javascript_Executar().
        '});</script>'."\n\n".
        '<!-- RICARDO REBELLO SIERRA <web@ricardosierra.com.br>  -->';
    }
    
    
    
    
    /*****
     *  CSS NAO USADOS MAIS
     * 
     * 
        // calendario
        'css/plugins/jquery.fullcalendar',
        'css/plugins/jquery.fullcalendar.print', // media="print"
        'assets/jquery-tags-input/jquery.tagsinput',
        // DAta
        'assets/bootstrap-datepicker/css/datepicker',
        'assets/bootstrap-timepicker/compiled/timepicker',
        'assets/bootstrap-colorpicker/css/colorpicker',
        'assets/bootstrap-daterangepicker/daterangepicker',
     * 
     * 
     * 
     * 
     * 
     * 
    /*****
     *  JS NAO USADOS MAIS
     * 
            'js/jquery/jquery.limit',
            'assets/bootstrap-colorpicker/js/bootstrap-colorpicker',
            // Calendario Jquert
            'js/jquery/jquery.fullcalendar',
        // Imagem
        'js/jquery/jquery.lightbox-0.5';
             Popup
            'js/jquery/jquery.apprise',
            'css/plugins/jquery.apprise',
            
            
            // Graficos
            'assets/flot/jquery.flot',
            'assets/flot/jquery.flot.resize',
            'assets/flot/jquery.flot.pie',
            'assets/flot/jquery.flot.stack',
            'assets/flot/jquery.flot.crosshair',
            // Editor de texto
            'assets/ckeditor/ckeditor';
            // Formularios 
            'js/plugins/form-component',
            // Datas
            'assets/bootstrap-datepicker/js/bootstrap-datepicker',
            'assets/bootstrap-timepicker/js/bootstrap-timepicker',
            'assets/bootstrap-timepicker/jquery-ui-timepicker-addon',
            'assets/bootstrap-daterangepicker/date',
            'assets/bootstrap-daterangepicker/daterangepicker',
     * 
     * 
     * *** OUTROS
     * 
        // Cria Botoes que Podem ser Arrastados
        $array_js[] = 'assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons';
        $array_css[] = 'assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons';
     * 
     * 
     *  // TELA DE POPUP
        $array_js[] = 'assets/fancybox/source/jquery.fancybox.pack';
        $array_css[] = 'assets/fancybox/source/jquery.fancybox';
     * 
     * 
     * 
     *  // CAMADAS ELASTICAS< QUE VAO AUMENTANDO
        $array_js[] = 'js/jquery/jquery.elastic;
     * 
     */
    
    
    
    
    /**
     * 
     * @return string
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Sistema_Css(){
        
        $array_css = Array();
        
        // JQUERY UI, BOOTSTRAP, e outros usados pelo framework
        array_push($array_css,
            'sistema/jquery-ui/jquery-ui.min',
            'sistema/bootstrap/css/bootstrap',
            'sistema/bootstrap/css/bootstrap-theme',
            'sistema/bootstrap/css/bootstrap-fileupload',
            // Carregamento igual Google
            'sistema/nprogress/nprogress',
            // Sistema de Mensagens
            'sistema/toastr/toastr.min',
                
            // Pequeno Aviso
            //'css/plugins/jquery.tiptip',
            // Bloquear Tela
            'css/plugins/jquery.blockui',
             // OUTROS
            'css/jcalendar',
                
            // Pequeno Aviso
            'assets/font-awesome/css/font-awesome',
            'assets/metr-folio/css/metro-gallery', // media="screen"
            //FORMULARIO
            'assets/uniform/css/uniform.default',
            'sistema/chosen/chosen',
            // Editor HTML5
            //'assets/bootstrap-wysihtml5/bootstrap-wysihtml5',
            // DUAL LIST
            'sistema/bootstrap-duallistbox/bootstrap-duallistbox',
                
            // DATATABLE
            'sistema/data-tables/DT_bootstrap',
            
            // Sistema
            'sistema/sistema'
        );        
        
        $this->Arquivos_Css($array_css);
        return $this->Arquivos_Css_Get();
    }
    /**
     * 
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function retornablocos() {
        $temaconfig = &self::$config_template['plugins'];
        $tipo       = 'simples';
        $html       = '';
        $html1      = '';
        $html2      = '';
        $i=0; $j=0;
        foreach($this->blocos as &$valor){
            if(is_array($valor)){
                // Adquire um id unico
                self::$layoult_idaleatorio = self::$layoult_idaleatorio+1;
                $id = $temaconfig['abas_id'].self::$layoult_idaleatorio;
                // Carrega todo
                $config = Array(
                    'Tipo'          => 'Topo',
                    'id'            => $id,
                    'titulo'        => $valor['title'],
                    'i'             => $i,
                );
                if($temaconfig['abas_inverter']===true){
                    $html1 = $this->renderizar_bloco('template_abas',$config).$html1;
                }else{
                    $html1 .= $this->renderizar_bloco('template_abas',$config);
                }
                // Carrega Resto 
                $config = Array(
                    'Tipo'          => 'Final',
                    'id'            => $id,
                    'bloco'         => $valor['bloco'],
                    'i'             => $i,
                );
                $html2 .= $this->renderizar_bloco('template_abas',$config);
                ++$i;
            }else{
                $html  .= $valor;
                ++$j;
            }
        }
        $this->blocos = Array();
        if($i>0){
            $tipo = 'abas';
            $config = Array(
                'Tipo'          => 'Montagem',
                'html1'         => $html1,
                'html2'         => $html2
            );
            $html = $this->renderizar_bloco('template_abas',$config);
        }
        return Array($tipo,$html);
    }
    /**
     * Retorna HTML do WIdget Usuario Logado, com link para edicao de perfil e Logout
     * @return varchar Retorna HTML
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function tmp_usuario(){
        $html = '';
        if(is_object($this->_Acl) && $this->_Acl->logado!==false){
            if(file_exists(ARQ_PATH.'usuario'.DS.$this->_Acl->logado_usuario->id.'.'.$this->_Acl->logado_usuario->foto)){
                $foto = $this->_Acl->logado_usuario->foto;
            }else{
                $foto = '';
            }
            $config = Array(
                "url_path"      => URL_PATH,
                'user_name'     => $this->_Acl->logado_usuario->nome,
                'upload_foto'   => ($this->_Acl->logado_usuario->foto)?$this->_Acl->logado_usuario->foto:SISTEMA_URL.SISTEMA_DIR.'web/img/icons/clientes.png'/*$this->Show_Upload('usuario','Perfil','PerfilFoto','PerfilFoto',$foto,'usuario'.DS,$this->_Acl->logado_usuario->id,'','36','36')*/
            );
            $html = $this->renderizar_bloco('widget_usuario',$config);
        }
        return $html;
    }
    /**
     * 
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function tmp_menu(){
        return $this->renderizar_bloco('widget_menu',Array(
            "url" => WEB_URL,
            "menu"=> $this->menu
        ));
    }
    /**
     * 
     * @return string
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function js_local (){
        $temaconfig = &self::$config_template['javascript'];
        // Traduz pra js
        if(SQL_MAIUSCULO===true){
            $maiusculo = 'true';
        }else{
            $maiusculo = 'false';
        }
        // Começa
        $html = 'if(window.location.hash!=\'\') location.href=\''.URL_PATH.'\'+window.location.hash.replace(/#/g, \'\');'.
        'ConfigArquivoPadrao = \''.SISTEMA_URL.SISTEMA_DIR.'\';'.
        'Config_Form_Maiusculo = '.$maiusculo.';'.
        'UserLogado = ';
            if($this->_Acl===false || $this->_Acl->logado===false || !isset($this->_Acl->logado_usuario->id) || $this->_Acl->logado_usuario->id==''){
                $html .= '0';
            }
            else{
                $html .= $this->_Acl->logado_usuario->id;
            }
        $html .= ';';
        // Carrega COnfig Javascript
        $html .= 'Configuracoes_Template = new Array();';
        if(!empty($temaconfig)){
            foreach($temaconfig as $indice=>&$valor){
                $html .= 'Configuracoes_Template["'.$indice.'"]="'.$valor.'";';
            }
        }
        return $html;
    }
    /**
     * Controles de Visual
     */
    /**
     * 
     * @param type $id
     * @param type $html
     * @param type $ativar
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public static function Layoult_Abas_Carregar($id,$html='',$ativar=true){
        $abas_id            = &self::$config_template['plugins']['abas_id'];
        $registro           = &\Framework\App\Registro::getInstacia();
        $Visual             = $registro->_Visual;
        if($html!='' && isset($html)){
            $js = ($ativar)?Visual::Layoult_Abas_Ativar_JS($id):'';
            
            $conteudo = array(
                'location'  =>  '#'.$abas_id.$id,
                'js'        =>  $js,
                'html'      =>  $html
            );
            $Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }else{
            if($ativar===true) return \Framework\App\Visual::Layoult_Abas_Ativar_JS($id);
        }
        return true;
    }
    /**
     * 
     * @param type $nome
     * @param type $link
     * @param type $icon
     * @param type $numero
     * @param type $cor
     * @param type $duplo
     * @param type $gravidade
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public static function Layoult_Home_Widgets_Add($nome,$link,$icon=false,$numero=false,$cor='block-yellow',$duplo=false,$gravidade=0,$bloquer_permissao=true){
        if($bloquer_permissao){
            if(\Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url($link)===false){
                // Interrompe se nao tiver acesso
                return false;
            }
        }
        self::$widgets_inline[] = Array(
            'nome'          => $nome,
            'link'          => URL_PATH.$link,
            'icon'          => $icon,
            'numero'        => $numero,
            'cor'           => $cor,
            'duplo'         => $duplo,
            'gravidade'     => $gravidade,
        );
        return true;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public static function Layoult_Home_Widgets_Show($gravidade=10000){
        $registro = \Framework\App\Registro::getInstacia();
        $Visual   = $registro->_Visual;
        $widgets = &self::$widgets_inline;
        orderMultiDimensionalArray($widgets, 'gravidade', true);
        $Visual->Blocar($Visual->renderizar_bloco('elemento_miniwidget',Array('widgets'=>$widgets)));
        // Mostra Conteudo
        $Visual->Bloco_Unico_CriaConteudo($gravidade);
    }
    /**
     * 
     * @param type $numero
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public static function Layoult_Abas_Ativar_JS($numero){
        $temaconfig         = &self::$config_template['plugins']['abas_ativar'];
        return $temaconfig($numero);
    }
    /**
     * Widget UNICO
     * @param type $endereco
     * @param type $html
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Widget_Assimilar($endereco,$html){
        $this->_widgets_params[$endereco] = $html;
        return true;
    }
    /**
     * WIDGET MULTIPLO (VARIAS OPCOES)
     * @param type $endereco
     * @param type $html
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Widgets_Assimilar($endereco,$html){
        $this->_widgets_params[$endereco][] = $html;
        return true;
    }
    /**
     * Renderiza Todo o Site, prepara tudo  e chama o Template, 
     * principal arquivo php do tema dentro da pasta Layoult
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function renderizar() {
        $imprimir = new \Framework\App\Tempo('Renderizar Json Visual - SEM SMARTY');
	// logado =2 ajax
        $params = array(
            'site_titulo'   => $this->Json_Get_Titulo(),
            'url_css'       => $this->template_url.'css/',
            'url_js'        => $this->template_url.'js/',
            'url_img'       => $this->template_url.'img/',
            'url_assets'    => $this->template_url.'assets/',
            'menu'          => '',
            'sistema'       => array(
                'css'           => $this->Sistema_Css(),
                'extras'        => $this->Sistema_Extras()
            ),
            'template'      => array(
                'usuario'       => $this->tmp_usuario(),
                'menu'          => $this->tmp_menu(),
                'Bloco_Unico'   => $this->Bloco_Unico_Retornar(),
                'Bloco_Maior'   => $this->Bloco_Maior_Retornar(),
                'Bloco_Menor'   => $this->Bloco_Menor_Retornar()
            ),
            'widgets'       => $this->_widgets_params
        );
        // Conteudo Puro, quando json eh false
        if($this->Layolt_Tipo()==2){
            // Bloco Maior
            $params['template']['Bloco_Maior'] = $this->conteudo;
        }
        
        // Pega Mensagens e Coloca na Tela
        if($this->jsonativado!==false && isset($this->json['Info']) && array_search('Mensagens', $this->json['Info']['Tipo'])!==false){
            foreach($this->json['Mensagens'] as &$valor){
                if($valor['tipo']==='erro'){
                    $tipo_nome      = 'Erro';
                    $tipo_reportar = 'error';
                }else{
                    $tipo_nome      = 'Sucesso';
                    $tipo_reportar = 'success';
                }
                $params['template']['Bloco_Unico'] = '<div class="alert alert-block alert-'.$tipo_reportar.' fade in">'.
                '<button type="button" class="close" data-dismiss="alert">×</button>'.
                '<h4 class="alert-heading">'.$valor["mgs_principal"].'</h4><p style="text-align:center;">'.$valor["mgs_secundaria"].'</p></div>'.$params['template']['Bloco_Unico'];
            }
            //Acrescenta ao Titulo, caso nao exista
            if($params['site_titulo']===false){
                $params['site_titulo'] = $tipo_nome;
            }
            //Acrescenta ao Endereco, caso nao exista
            if(isset($params['widgets']['Navegacao_Endereco']) && preg_match('/<span class="divider">\/<\/span><\/li>$/', $params['widgets']['Navegacao_Endereco'])) {
                $params['widgets']['Navegacao_Endereco'] .= '<li class="active">'.$tipo_nome.'</li>';
            }
        }
            
        if($params['site_titulo']===false){
            $params['site_titulo'] = 'Sistema';
        }
        $this->renderizar_Template('template',$params,false);
    }
    /**
     * Carrega Uma Barra Superior cheia de botoes, ou apenas um botao simples com um link
     * Se a permissao não for mencionada, então verifica a permissão do link, o que pode se tornar lento
     * se for realiza dentro de um foreach por exemplo.
     * 
     * @param type $tipo
     * @param type $nome
     * @param bolean $permissao Opcional, se nao for mencionada, verifica se o link tem permissao
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Tema_Elementos_Btn($tipo='Editar',$nome = Array('Adicionar','#',''),$permissao='_'){
        if(!is_array($nome)) throw new \Exception('$nome não é array: '.$nome,2810);
        if($tipo=='Superior'){
            if(isset($nome[1]['Print'])){
                $ferramentas    = $nome[1];
                $nome           = $nome[0];
                $ferramentas = Array(
                    'Print'             => ($ferramentas['Print'])?true:false,
                    'Pdf'               => ($ferramentas['Pdf'  ] && SISTEMA_EXPORTAR_PDF)?true:false,
                    'Excel'             => ($ferramentas['Excel'] && SISTEMA_EXPORTAR_EXCEL)?true:false,
                    'Link'              =>  $ferramentas['Link' ],
                );
            }else{
                $ferramentas = false;
            }
            if($permissao==='_') $permissao = $this->_Registro->_Acl->Get_Permissao_Url($nome[1]);
            if($permissao!==false && isset($nome[2])){
                $array = Array(
                    'btn_add'           => Array(
                        'nome'              => $nome[0],
                        'url'               => $nome[1],
                        'onclick'           => $nome[2],
                    ),
                    'Ferramentas'       => $ferramentas,
                    'Tipo'              => $tipo
                );
            }else{
                if($ferramentas===false) return '';
                
                $array = Array(
                    'btn_add'           => false,
                    'Ferramentas'       => $ferramentas,
                    'Tipo'              => $tipo
                );
            }
            return $this->renderizar_bloco('elemento_botao',$array);  
        }else if($tipo=='Personalizado'){
            if($permissao==='_') $permissao = $this->_Registro->_Acl->Get_Permissao_Url($nome[1]);
            if($permissao===false) return '';
            //'onclick'           => $nome[2]
            return     '<a href="'.URL_PATH.$nome[1].'" class="btn btn-'.$nome[4].' lajax explicar-titulo" title="'.$nome[0].'" acao=""><i class="glyphicon-'.$nome[3].'"></i></a>';  
        }else{
            if($permissao==='_') $permissao = $this->_Registro->_Acl->Get_Permissao_Url($nome[1]);
            if($permissao===false) return '';
            //'onclick'           => $nome[2],
            if($tipo==='Destaque0'){
                $cor    = 'danger';
                $icone  = 'star-empty';
            }else if($tipo==='Destaque1'){
                $cor    = 'success';
                $icone  = 'star';                
            }else if($tipo==='Status0'){
                $cor    = 'danger';
                $icone  = 'thumbs-down';                
            }else if($tipo==='Status1'){
                $cor    = 'success';
                $icone  = 'thumbs-up';                
            }else if($tipo==='Email'){
                $cor    = 'primary';
                $icone  = 'envelope';                
            }else if($tipo==='Baixar'){
                $cor    = 'inverse';
                $icone  = 'download';                
            }else if($tipo==='Visualizar'){
                $cor    = 'success';
                $icone  = 'eye-open';                
            }else if($tipo==='Zoom'){
                $cor    = 'info';
                $icone  = 'zoom-in';                
            }else if($tipo==='Editar'){
                $cor    = 'warning" confirma="Deseja Realmente Editar?';
                $icone  = 'pencil';                
            }else/* if($tipo==='Deletar')*/{
                $cor    = 'danger" confirma="'.$nome[2];
                $icone  = 'trash';                
            }
            return '<a href="'.URL_PATH.$nome[1].'" class="btn lajax explicar-titulo btn-'.$cor.'" title="'.$nome[0].'" acao="">
        <i class="glyphicon-'.$icone.'"></i></a>';
        }
    }
    /**
     * Renderiza Página de Login tanto inteira quanto via Ajax
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function renderizar_login(){
        if(LAYOULT_IMPRIMIR=='AJAX'){
            $form = new \Framework\Classes\Form('Formlogin',SISTEMA_DIR_INT,''); //formajax /'.SISTEMA_MODULO.'/'.SISTEMA_SUB.'/'.SISTEMA_MET
            $form->Input_Novo('Login','sistema_login','','text', '',30, '');
            $form->Input_Novo('Senha','sistema_senha','','password', 30, '','');
            $this->Blocar($form->retorna_form('Entrar'));
            $this->Bloco_Menor_CriaJanela(__('Login'));
            
            echo $this->Json_Retorna();
            return true;
        }else{
            // logado =2 ajax
            $params = array(
                'site_titulo'   => 'Entrar',
                'url_css'       => $this->template_url.'css/',
                'url_js'        => $this->template_url.'js/',
                'url_img'       => $this->template_url.'img/',
                'url_assets'    => $this->template_url.'assets/',
                'menu'          => '',
                'mensagem'          => '',
                'sistema'       => array(
                    'css'           => $this->Sistema_Css(),
                    'extras'        => $this->Sistema_Extras()
                )/*,
                'template'  => array(
                    'usuario'       => $this->tmp_usuario(),
                    'menu'          => $this->tmp_menu(),
                    'Bloco_Unico'   => $this->Bloco_Unico_Retornar(),
                    'Bloco_Maior'   => $this->Bloco_Maior_Retornar(),
                    'Bloco_Menor'   => $this->Bloco_Menor_Retornar()
                )*/
            );
            
            // Pega Mensagens e Coloca na Tela
            if($this->jsonativado!==false && isset($this->json['Info']) && array_search('Mensagens', $this->json['Info']['Tipo'])!==false){
                foreach($this->json['Mensagens'] as &$valor){
                    if($valor['tipo']==='erro'){
                        $tipo_nome      = 'Erro';
                        $tipo_reportar = 'error';
                    }else{
                        $tipo_nome      = 'Sucesso';
                        $tipo_reportar = 'success';
                    }
                    $params['mensagem'] = '<div class="alert alert-block alert-'.$tipo_reportar.' fade in">'.
                    '<button type="button" class="close" data-dismiss="alert">×</button>'.
                    '<h4 class="alert-heading">'.$valor["mgs_principal"].'</h4><p style="text-align:center;">'.$valor["mgs_secundaria"].'</p></div>'.$params['template']['Bloco_Unico'];
                }
            }

            //$this->clear_cache($this->template_dir.'page_login.tpl');
            $this->renderizar_Template('page_login',$params,false);
        }
    }
    /**
     * Renderiza um Bloco de Conteudo,
     * 
     * @param type $tpl Nome do Arquivo
     * @param type $params Parametros do Aqruivo
     * @return string Html com os dados preenchidos
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function renderizar_bloco($tpl,$params = Array()){
        $imprimir = new \Framework\App\Tempo('Renderizar bloco Visual - SEM SMARTY');
        //$this->clear_cache($this->template_dir.$tpl.'.tpl');
        return $this->renderizar_Template($tpl,$params);
    }
    /**
     * Função Privada para Renderizar templates fornecendo os params do arquivo
     * e o nome do arquivo dentro que esta dentro da pasta layoult no nome do tema
     * 
     * @param string $url
     * @param type $params
     * @param type $retorno
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function renderizar_Template($url,$params,$retorno=true){
        $params = array_merge_recursive($params, array(
            'SOBRE_DIREITOS'    => SOBRE_DIREITOS,
            'SOBRE_SLOGAN'      => SOBRE_SLOGAN,
            'SOBRE_COMPANY'     => SOBRE_COMPANY,
            'WEB_URL'           => WEB_URL,
            'URL_PATH'          => URL_PATH,
            'ARQ_URL'           => ARQ_URL,
            'TEMA_COLOR'        => TEMA_COLOR,
            'TEMA_LOGO'         => TEMA_LOGO
        ));
        $url = $this->template_dir.$url.'.php';
        if(file_exists($url)){
            ob_start();
            include($url);
            $saida = ob_get_contents();
            ob_end_clean();
            if($retorno){
                return $saida;
            }else{
                echo $saida;
                return true;
            }
        }else{
            return false;
        }
    }
    /**
     * Altera o Tipo de Layoult que será exibido (normal, ajax)
     * @param type $alterar
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Layolt_Tipo($alterar=false){
        if($alterar===false){
            return $this->Layolt_Tipo;
        }else{
            $this->Layolt_Tipo = $alterar;
        }
    }
    /**
     * Gera Graficos em Forma de Pizza Usando uma lib interna
     * @param type $graficos
     * @return string
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function grafico_gerar(&$graficos){
        // monta os graficos desejados
        $html = '';
        foreach ($graficos as &$valor){
              $settings = array(
                'headers' => $valor['headers'],
                'data' => $valor['itens'],
              );
              $alt = $valor['alt'];
              $larg = $valor['larg'];
              if(count($valor['itens'])>1){
                 $html .= '<img src=\''.LIBS_URL.'phplot/graf_pizza.php?data='.serialize($valor['itens']).'&titulo='.$valor['titulo'].'&larg='.$valor['larg'].'&alt='.$valor['alt'].'&settings='.serialize($settings).'\' />';
              }
        }
        return $html;
    }
    /**
     * @Name Show_Tabela_DataTable   
     * Cria Tabela dinamica paginada, com busca, reordenação, tudo automatico
     * Enviar tabela em array
     * 
     * Funcionalidades: cria uma tabela no layoult
     * 
     * @param array $tabela Array com a Tabela ja Prédefinida
     * @param varchar $style Folha de Estilos Opcional
     * @param bolean $blocar Se Add ou não ao bloco
     * @param bolean $apagado1 Se Apaga ou nao a PRimeira coluna
     * @param array $aaSorting Array com a Ordenacao da Tabela será passado ao Datatable
     * @param bolean $ColunasOrd Se possue ordenação de colunas
     * @return varchar
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @Version 0.2.2
     */
    public function Show_Tabela_DataTable($tabela, $style='', $blocar=true, $apagado1=false, $aaSorting=Array(Array(0,'asc')), $ColunasOrd=false) {
        $aaSortingtxt = '';
        $i = 0;
        if(is_array($aaSorting)){
            foreach($aaSorting as &$valor){
                if($i>0) $aaSortingtxt .= ',';
                $aaSortingtxt .= '['.$valor[0].',\''.$valor[1].'\']';
                ++$i;
            }
        }
        $config = Array(
            'Tipo'      => 'Dinamica',
            'Opcao'     => Array(
                'Tabela'         => $tabela,
                'Style'          => $style,
                'Apagado1'       => $apagado1,
                'aaSorting'      => $aaSortingtxt,
                'Colunas  '      => $ColunasOrd // Ordenacao das Colunas
            )
        );
        if($blocar===true){
            $this->Blocar($this->renderizar_bloco('template_tabela',$config));
        }else{
            return $this->renderizar_bloco('template_tabela',$config);
        }
    }
    /**
     * Criação de Data Table com Muitos Dados
     * Só Carrega o Necessário
     * 
     * @param array $tabela Array com a Tabela ja Prédefinida
     * @param varchar $url Url que estará os Dados do Modelo que retornará os Dados
     * @param varchar $style Folha de Estilos Opcional
     * @param bolean $blocar Se Add ou não ao bloco
     * @param bolean $apagado1 Se Apaga ou nao a PRimeira coluna
     * @param array $aaSorting Array com a Ordenacao da Tabela será passado ao Datatable
     * @param bolean $ColunasOrd Se possue ordenação de colunas
     * @return type
     */
    public function Show_Tabela_DataTable_Massiva($tabela, $url=false, $style='', $blocar=true, $apagado1=false, $aaSorting=Array(Array(0,'asc')), $ColunasOrd=false) {
       if($url === false){
           $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
       }
        
        $aaSortingtxt = '';
        $i = 0;
        if(is_array($aaSorting)){
            foreach($aaSorting as &$valor){
                if($i>0) $aaSortingtxt .= ',';
                $aaSortingtxt .= '['.$valor[0].',\''.$valor[1].'\']';
                ++$i;
            }
        }
        $config = Array(
            'Tipo'      => 'Massiva',
            'Opcao'     => Array(
                'Tabela'         => $tabela,
                'Url'            => 'Modelo/'.$url,
                'Style'          => $style,
                'Apagado1'       => $apagado1,
                'aaSorting'      => $aaSortingtxt,
                'Colunas  '      => $ColunasOrd // Ordenacao das Colunas
            )
        );
        if($blocar===true){
            $this->Blocar($this->renderizar_bloco('template_tabela',$config));
        }else{
            return $this->renderizar_bloco('template_tabela',$config);
        }
    }
    /**
     * Upload Inline de Imagens (Unico, um arquivo) 
     * @param type $modulo
     * @param type $sub
     * @param type $acao
     * @param type $camada
     * @param type $imagem
     * @param type $diretorio
     * @param type $id
     * @param type $add
     * @param type $largura
     * @param type $altura
     * @param type $extensoes
     * @param type $descricao
     * @return string
     */
    public function Show_Upload($modulo,$sub,$acao,$camada,$imagem,$diretorio,$id,$add='',$largura='50',$altura='50',$extensoes='*.png;*.jpg;*.gif',$descricao='Arquivos de imagens...'){
        if($imagem=='') $imagem = '0.jpg';
        else            $imagem = $id.'.'.$imagem;
        if(!is_dir(ARQ_PATH.$diretorio)){
            if(!mkdir (ARQ_PATH.$diretorio, 0777,true )) throw new \Exception('Erro de Permissão: '.$diretorio,2826);
        }
        $html = '<div id="'.$camada.'">'.
        //'<script>Modelo_Upload(\''.$modulo.'\',\''.$sub.'\',\''.$acao.'\',\''.$camada.'\',\''.$imagem.'\',\''.$diretorio.'\',\''.$id.'\',\''.$largura.'\',\''.$altura.'\',\''.$extensoes.'\',\''.$descricao.'\'); </script>'.
        '<input type="file" id="'.$camada.'" name="'.$camada.'" />'.$add.
        '</div>';
        $this->Javascript_Executar('Sierra.Modelo_Upload(\''.$modulo.'\',\''.$sub.'\',\''.$acao.'\',\''.$camada.'\',\''.$imagem.'\',\''.$diretorio.'\',\''.$id.'\',\''.$largura.'\',\''.$altura.'\',\''.$extensoes.'\',\''.$descricao.'\');');
        return $html;
    }
    /**
     * Upload Inline de Imagens (Multiplo, varios arquivo) 
     * @param type $modulo
     * @param type $sub
     * @param type $acao
     * @param type $id
     * @param type $extensoes
     * @param type $descricao
     * @return string
     */
    public function Upload_Janela($modulo,$sub,$acao,$id=false,$extensoes='*.png;*.jpg;*.gif',$descricao='Arquivos de imagens...'){
        $inicio = (int) TEMPO_COMECO;
        $atributo_id = (string) 'Drop'.$inicio.'zone'.rand();
        // Carrega Dependencias
        $this->Arquivos_Css_Dependencia('sistema/dropzone/css/dropzone');
        $this->Arquivos_Js_Dependencia('sistema/dropzone/dropzone');
        // COmeça HTML
        $html = '<form action="'.URL_PATH.$modulo.'/'.$sub.'/'.$acao.'_Upload/'.$id.'" class="dropzone" id="'.$atributo_id.'"></form>';
        
        if(LAYOULT_IMPRIMIR=='AJAX'){
            $this->Javascript_Executar('new Dropzone($(\'#'.$atributo_id.'\'));');
        }
        
        return $html;
    }
    /***************************************************\
    *                                                   *
    *                FUNCOES PARA JS                    *
    *                                                   *
    \***************************************************/
    /**
     * Gerador de Calendário (JS+HTML)
     * @param varchar $idcalendar
     * @param array $events 'Id,'Titulo','DataInicial','DataFinal'
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Js_Calendar_Gerar($idcalendar,&$events){
         $this->Javascript_Executar(
         '$(\'#'.$idcalendar.'\').fullCalendar({
             monthNames:[\'Janeiro\', \'Fevereiro\', \'Março\', \'Abril\', \'Maio\', \'Junho\', \'Julho\', \'Agosto\', \'Setembro\', \'Outubro\', \'Novembro\', \'Dezembro\'],
             monthNamesShort:[\'Jan\', \'Fev\', \'Mar\', \'Abr\', \'Mai\', \'Jun\', \'Jul\', \'Ago\', \'Set\', \'Out\', \'Nov\', \'Dez\'],
             dayNames: [\'Domingo\', \'Segunda\', \'Terça\', \'Quarta\', \'Quinta\', \'Sexta\', \'Sábado\'],
             dayNamesShort:[\'Dom\', \'Seg\', \'Ter\', \'Qua\', \'Qui\', \'Sex\', \'Sab\'],
             buttonText: {
                prev:     \'&lsaquo;\', // <
                next:     \'&rsaquo;\', // >
                prevYear: \'&laquo;\',  // <<
                nextYear: \'&raquo;\',  // >>
                today:    \'Hoje\',
                month:    \'Mensal\',
                week:     \'Semanal\',
                day:      \'Diário\'
             },
             editable:false,
             header:{
                left:\'prev,next today\',
                center:\'title\',
                right:\'month,agendaWeek,agendaDay\'
             },
             events:['
                );
                $i = 0;
                foreach($events as &$valor){
                    if($i!=0){
                        $this->Javascript_Executar(',');
                    }
                    $this->Javascript_Executar('{'.
                    'id:\''.$valor['Id'].'\','.
                    'title:\''.$valor['Titulo'].'\','.
                    'start: \''.$valor['DataInicial'].'\','.
                    'end: \''.$valor['DataFinal'].'\','.
                    'comeco: \''.$valor['DataInicial'].'\','.
                    'final: \''.$valor['DataFinal'].'\''.
                    '}');  
                    ++$i;
                }
                $this->Javascript_Executar('
            ],
            eventClick: function(event) {
                if(UserLogado==0){
                    alert(\'Precisa ser cadastrado para alugar motos\');
                }else{
                    Modelo_Ajax_Chamar(\''.SISTEMA_MODULO.'/'.SISTEMA_SUB.'/Popup_Agendar_veiculo/\'+event.id+\'&nome=\'+event.title+\'&inicial=\'+event.comeco+\'&final=\'+event.final,\'\',\'GET\',true);	
                }
                return false;
            }
        });');
        $this->Blocar('<div id="'.$idcalendar.'"></div>');
    }
    /***************************************************\
    *                                                   *
    *                FUNCOES PARA JSON                  *
    *                                                   *
    \***************************************************/
    /**
     * Inicializa o Json, é usada pelo Visual e pelo Controle
     * @param varchar $title Titulo da Página
     * @param bolean $historico Se armazena ou não no histórico
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Json_Start($title='',$historico=true){
        if($this->jsonativado===false){
            $this->json['Info'] = array(
                'Titulo' => $title,
                'Historico' => $historico,
                'Tipo' => array(),
                'callback' => ''
            );
            $this->jsonativado = true;
        }
    }
    /**
     * Retorna Titulo da Página, Armazenada no Json
     * @return varchar
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Json_Get_Titulo(){
        if(isset($this->json['Info']['Titulo']) && $this->json['Info']['Titulo']!=='' && $this->json['Info']['Titulo']!==false){
            return $this->json['Info']['Titulo'];
        }else{
            return false;
        }
    }
    /**
     * Atualiza um tipo no Json, Esses Tipos são criados tanto no php qnt no js.
     * @param varchar $indice 'Tipo' -> Pode ser Titulo, Historico, Mensagens, ...
     * @param type $valor Pode ser um boleano, varchar ou um array padronizado com o js
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Json_Info_Update($indice,$valor){
        if($this->jsonativado===false){
            $this->Json_Start();
        }
        $this->json['Info'][$indice] = $valor;
    }
    /**
     * Verifica se Existe o Json do HTML
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Json_Exist(){
        if($this->jsonativado===false){
            return false;
        }else{
            return true;
        }
    }
    /**
     * Verifica se Existe esse Tipo no Json
     * @param type $tipo
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Json_ExisteTipo($tipo){
        if(isset($this->json[$tipo])){
            return true;
        }else{
            return false;
        }
        
    }
    /**
     * Retira eDeleta um Tipo dentro do Json do HTML do site
     * @param type $id
     * @return boolean
     */
    public function Json_RetiraTipo($id){
        if(!empty($this->json['Conteudo'])){
            foreach($this->json['Conteudo'] as $indice=>&$valor){
                if($valor['location'] == $id){
                    unset($this->json['Conteudo'][$indice]); 
                    return true;
                }
            }
        }
        return false;
    }
    /**
     * Adiciona ou Acrescenta em um tipo no Json, Esses Tipos são criados tanto no php qnt no js.
     * @param varchar $tipo 'Tipo' -> Pode ser Titulo, Historico, Mensagens, ...
     * @param array $array Pode ser um boleano, varchar ou um array padronizado com o js
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Json_IncluiTipo($tipo,&$array){
        // Se nao tiver json, ativa
        if($this->jsonativado===false){
            $this->Json_Start();
        }
        if(array_search($tipo, $this->json['Info']['Tipo'])===false){
            if($tipo=='JavascriptInterno'){
                array_push($this->json['Info']['Tipo'], $tipo);
            }else{
                array_unshift($this->json['Info']['Tipo'], $tipo);
            }
        }
        // Dependendo do Tipo, faz a inserção necessaria
        if($tipo=='Redirect'){
            if(!isset($this->json['Redirect'])){
                $this->json['Redirect'] = Array();
            }
            $this->json['Redirect'][] = $array;
        }else if($tipo=='Popup'){
            if(!isset($this->json['Popup'])){
                $this->json['Popup'] = Array();
            }
            $botoes = Array();
            if(isset($array['width'])){
                $largura    = $array['width'];
            }
            else{
                $largura    = 800;
            }
            if(isset($array['height'])){
                $altura     = $array['height'];
            }
            else{
                $altura     = 600;
            }
            if(isset($array['botoes'])){
                foreach ($array['botoes'] as &$valor) {
                    $botoes[] = Array(
                        'text'      => $valor['text'],
                        'clique'    =>  $valor['clique']
                    );
                }
            }
            $this->json['Popup'] = array(
                "id" => $array['id'],
                "title" => $array['title'],
                "width" => $largura,
                "height" => $altura,
                "botoes" => $botoes,
                "html" => $array['html']
            );
        }elseif($tipo=='Mensagens'){
            if(!isset($this->json['Mensagens'])){
                $this->json['Mensagens'] = Array();
            }
            $this->json['Mensagens'][] = array(
                "tipo" => $array['tipo'],
                "mgs_principal" => $array['mgs_principal'],
                "mgs_secundaria" => $array['mgs_secundaria']
            );
        }elseif($tipo=='Conteudo'){
            if(!isset($this->json['Conteudo'])){
                $this->json['Conteudo'] = Array();
            }
            $this->json['Conteudo'][] = array(
                "location" => $array['location'],
                "js" => $array['js'],
                "html" => $array['html']
            );
        }elseif($tipo=='Select'){
            if(!isset($this->json['Select'])){
                $this->json['Select'] = Array();
            }
            $this->json['Select'][] = array(
                "id" => $array['id'],
                "valores" => $array['valores']
            );
        }elseif($tipo=='Javascript'){
            if(!isset($this->json['Javascript'])){
                $this->json['Javascript'] = Array();
                if(is_array($array)){
                    $this->json['Javascript'] = $array;
                    return true;
                }
            }
            if(is_array($array)){
                $this->json['Javascript'] = array_merge($this->json['Javascript'], $array);
            }else{
                $this->json['Javascript'][] = $array;
            }
        }elseif($tipo=='JavascriptInterno'){
            if(!isset($this->json['JavascriptInterno'])){
                $this->json['JavascriptInterno'] = Array();
            }
            $this->json['JavascriptInterno'][] = $array;
        }elseif($tipo=='Css'){
            if(!isset($this->json['Css'])){
                $this->json['Css'] = Array();
                if(is_array($array)){
                    $this->json['Css'] = $array;
                    return true;
                }
            }
            if(is_array($array)){
                $this->json['Css'] = array_merge($this->json['Css'], $array);
            }else{
                $this->json['Css'][] = $array;
            }
        }
        return false;
    }
    /**
     * Prepara o Json pra Ser retornado pra tela, acrescenta js e css dependentes
     * e retorna tudo.
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Json_Retorna($zerar=true){
        $imprimir = new \Framework\App\Tempo('Retornar Json Visual - SEM SMARTY');
        
        
        // Inicia se nao tiver iniciado
        if($this->jsonativado===false){
            $this->Json_Start();
        }
        
        
        
        
        
        
        
                        
        // Pega Conteudo Alocado e Coloca Aqui
        $configuracao_layoult = config_template();

        if($configuracao_layoult['camada_unica']!==false){
            $html = $this->Bloco_Unico_Retornar();
            $js = '';
            if($html==''){
                $js = '$(\''.$configuracao_layoult['camada_unica'].'\').hide();';
            }else{
                $js = '$(\''.$configuracao_layoult['camada_unica'].'\').show();';
            }
            $conteudo = array(
                'location'  => $configuracao_layoult['camada_unica'],
                'js'        => $js,
                'html'      => $html
            );
            // Joga pro Json se nao for o caso de popup
            if($zerar===true || $html!=''){
                $this->Json_IncluiTipo('Conteudo',$conteudo);
            }
            $html = $this->Bloco_Maior_Retornar();
        }else{
            $html = $this->Bloco_Unico_Retornar().$this->Bloco_Maior_Retornar();
        }

        $js = '';
        if($html==''){
            $js = '$(\''.$configuracao_layoult['camada_maior'].'\').hide();';
        }else{
            $js = '$(\''.$configuracao_layoult['camada_maior'].'\').show();';
        }
        $conteudo = array(
            'location' => $configuracao_layoult['camada_maior'],
            'js' => $js,
            'html' => $html
        );
        // Joga pro Json se nao for o caso de popup
        if($zerar===true || $html!=''){
            $this->Json_IncluiTipo('Conteudo',$conteudo);
        }

        $html = $this->Bloco_Menor_Retornar();
        $js = '';
        if($html==''){
            $js = '$(\''.$configuracao_layoult['camada_menor'].'\').hide();';
        }else{
            $js = '$(\''.$configuracao_layoult['camada_menor'].'\').show();';
        }
        $conteudo = array(
            'location' => $configuracao_layoult['camada_menor'],
            'js' => $js,
            'html' =>  $html
        );
        // Joga pro Json se nao for o caso de popup
        if($zerar===true || $html!=''){
            $this->Json_IncluiTipo('Conteudo',$conteudo);
        }
        // inclui js e zera o head js
        $javascript = $this->Javascript_Executar();
        if($javascript!=''){
            $this->Json_IncluiTipo('JavascriptInterno',$javascript);
            //zera js
            $this->Javascript_Executar(false);
        }
        
        
        
        
        // Continuar
        if($this->json['Info']['Titulo']!=''){
            $html='';
            if(isset($this->menu['SubMenu'])){
                $tamanho = sizeof($this->menu['SubMenu']['link']);
                for($i = 0; $i<$tamanho; $i++){
                    $html .= '<li><a href="'.$this->menu['SubMenu']['link'][$i].'" class="lajax-mesub';
                    if($this->menu['SubMenu']['ativo'][$i]==1){
                        $html .= ' active';
                    }
                    $html .= '" acao="">'.$this->menu['SubMenu']['nome'][$i].'</a></li>';
                }
            }
            $conteudo = array(
                "location" => "#sub-menu",
                "js" => "",
                "html" => $html
            );
            $this->Json_IncluiTipo('Conteudo',$conteudo);
        }
        
        // Adiciona Dependentes
        $css    = $this->Arquivos_Css_Get_Dependentes();
        $js     = $this->Arquivos_Js_Get_Dependentes();
        if($js!==false){
            $this->Json_IncluiTipo('Javascript',$js);
        }
        if($css!==false){
            $array = Array();
            $this->Json_IncluiTipo('Css',$css);
        }
        
        return $this->Json_Codificar();
    }
    /**
     * Codifica o Json pra Ser Enviado pro Cliente
     * @return varchar
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    private function Json_Codificar(){
        
        if (\Framework\App\Sistema_Funcoes::VersionPHP('5.3.10'))
        {
            // retirei JSON_UNESCAPED_UNICODE
            return json_encode($this->json, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        }
        else
        {
            // caso a versao do php nao seja 5.3.10 para cima, entao nao suporta json_encode e fara o seguinte
            if (!function_exists('json_encode')) {
                function json_encode($data) {
                    switch ($type = gettype($data)) {
                        case 'NULL':
                            return 'null';
                        case 'boolean':
                            return ($data ? 'true' : 'false');
                        case 'integer':
                        case 'double':
                        case 'float':
                            return $data;
                        case 'string':
                            return '"' . addslashes($data) . '"';
                        case 'object':
                            $data = get_object_vars($data);
                        case 'array':
                            $output_index_count = 0;
                            $output_indexed = array();
                            $output_associative = array();
                            foreach ($data as $key => &$value) {
                                $output_indexed[] = json_encode($value);
                                $output_associative[] = json_encode($key) . ':' . json_encode($value);
                                if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                                    $output_index_count = NULL;
                                }
                            }
                            if ($output_index_count !== NULL) {
                                return '[' . implode(',', $output_indexed) . ']';
                            } else {
                                return '{' . implode(',', $output_associative) . '}';
                            }
                        default:
                            return ''; // Not supported
                    }
                }
            }
            // faltou JSON_UNESCAPED_UNICODE
            // Faz as substituicoes necessarias para o encode funcionar
            $contem     = array('<'    , '>'     , "'"     , '"'     , '&s');
            $alterar    = array('\u003C', '\u003E', "\u0027", '\u0022', '\u0026');

            $this->json = str_replace($contem, $alterar, $this->json);
            return json_encode($this->json);
        } 
    }
    /**
     * 
     * @param type $array
     * @param type $tabela
     * @param type $i
     * @param type $nivel
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Categorias_ShowTab(&$array,&$tabela,$i=0,$nivel=0){
        $antecipa = $nivel;
        $nomeantes = '';
        $j = 0;
        while($antecipa>0){
            --$antecipa;
            $nomeantes = $nomeantes.'— ';
        }
        if(!empty($array)){
              reset($array);
              foreach ($array as &$valor) {
                if($nivel==0){
                    $class = 'tbold tleft';
                }
                else{
                    $class = 'tleft backcolor';
                }
                // Imprime Acesso
                $acesso = '';
                if(!empty($valor['acesso'])){
                    foreach ($valor['acesso'] as &$valor2){
                        $oacesso = \Categoria_Acesso_DAO::Mod_Acesso_Get($valor2);
                        if($acesso==''){
                            $acesso .= $oacesso['nome'];
                        }
                        else{
                            $acesso .= '<br>'.$oacesso['nome'];
                        }
                    }
                }
                $tabela->addcorpo(array(
                    array("nome" => '#'.$valor['id']),
                    array("nome" => $nomeantes.$valor['nome'], "class" => $class),
                    array("nome" => $acesso, "class" => $class),
                    array("nome" => $this->Tema_Elementos_Btn('Editar'     ,Array('Editar Categoria'        ,'categoria/Admin/Categorias_Edit/'.$valor['id'].'/'    ,'')).
                                    $this->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Categoria'       ,'categoria/Admin/Categorias_Del/'.$valor['id'].'/'     ,'Deseja realmente deletar essa Categoria ?'))
                    )
                ));
                ++$i;
                if(!empty($array[$j]['filhos'])){
                    $i = $this->Categorias_ShowTab($array[$j]['filhos'],$tabela,$i,$nivel+1);
                }
                ++$j;
              }
          }
        return $i;
    }
    /**
     * 
     * @param type $array
     * @param type $form
     * @param type $padrao
     * @param type $i
     * @param type $nivel
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Categorias_ShowSelect(&$array,&$form,$padrao=0,$i=0,$nivel=0){
        $antecipa = $nivel;
        $nomeantes = '';
        $j = 0;
        while($antecipa>0){
            --$antecipa;
            $nomeantes = $nomeantes.'— ';
        }
        if(!empty($array)){
              reset($array);
              foreach ($array as &$valor) {
                if($padrao==$valor['id']){
                    $selecionado = 1;
                }
                else{
                    $selecionado = 0;
                }
                $form->Select_Opcao($nomeantes.$valor['nome'],$valor['id'],$selecionado);
                ++$i;
                if(!empty($array[$j]['filhos'])){
                    $i = $this->Categorias_ShowSelect($array[$j]['filhos'],$form,$padrao,$i,$nivel+1);
                }
                ++$j;
              }
          }
        return $i;
    }
    /**
     * 
     * @param type $array
     * @param type $form
     * @param type $padrao
     * @param type $i
     * @param type $nivel
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Categorias_ShowSelect_AJAX(&$array,&$form,$padrao=0,$i=0,$nivel=0){
        $antecipa = $nivel;
        $nomeantes = '';
        $j = 0;
        while($antecipa>0){
            --$antecipa;
            $nomeantes = $nomeantes.'— ';
        }
        if(!empty($array)){
              reset($array);
              foreach ($array as &$valor) {
                if($padrao==$valor['id']){
                    $selecionado = 1;
                }
                else{
                    $selecionado =0;
                }
                $form .= \Framework\Classes\Form::Select_Opcao_Stat($nomeantes.$valor['nome'],$valor['id'],$selecionado);
                ++$i;
                if(!empty($array[$j]['filhos'])){
                    $i = $this->Categorias_ShowSelect_AJAX($array[$j]['filhos'],$form,$padrao,$i,$nivel+1);
                }
                ++$j;
              }
          }
        return $i;
    }
    /**
     * Retorna os Temas de Links e Cores de acordo com o Bootstrap3.0
     * @param varchar $complemento Usado antes das variaveis das cores, pode ser label ou outros
     * @return Array
     */
    static function Tema_Tipos($complemento){
         return Array(4,Array(
             $complemento.'-success',
             $complemento.'-info',
             $complemento.'-warning',
             $complemento.'-danger'
         ));
    }
}
?>
